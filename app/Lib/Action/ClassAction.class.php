<?php

/**
 *	班级类
 */
 class ClassAction extends Action{
	
	public function __construct() {
		
		//检查是否登录，是否有权限
		parent::__construct();
		
	}

	/**
	 *	检查权限
	 */
	private function checkPermission() {
		
		if(!$_SESSION['uid']) {
			return -1;	//未登录
		}

		$level = $_SESSION['userInfo']['is_admin'];

		return $level;
	}

	/**
	 *	班级照片列表
	 *	order 排序方式 add_time时间 / belong 班级 默认 add_time 
	 *	item_id 1 班级 2 作业 3 一寸照
	 */
	public function photoList() {

		if($this->checkPermission() <= 0) {
			$this->assign('title', '您未登录或无权限访问此页面！');
			$this->error();
		}

		$order = empty($_REQUEST['order']) ? 'add_time' : htmlspecialchars($_REQUEST['order']);

		$item_id = 1; // 班级

		$upload_file = M('uploaded_file');

		import('ORG.Util.Page');

		$count = $upload_file->where('item_id=' . $item_id)->count();

		$page = new Page($count, 20, 'order=' . $order);

		$show = $page->show();

		$list = $upload_file->where('item_id=' . $item_id)->order($order . ' desc')->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$cate = M('class_msg_cate');

		foreach($list as $key => $val) {
			$catename     = $cate->field('cate_name')->where('cate_id=' . $val['belong'])->find();
			$list[$key]['class']     = $catename['cate_name'];
		}

		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->display('Class:photoList');
	}
	
	/**
	 *	上传照片
	 */
	public function upload() {

		if($this->checkPermission() <= 0) {
			
			$this->assign('title', '您未登录或无权限访问此页面！');
			$this->error();
		}

		if(!$_POST) {
			$cate = M('class_msg_cate');
			$list = $cate->select();
			$this->assign('cate_list', $list);

			$this->display();
		} else {

			import('ORG.Net.UploadFile');

			$upload = new UploadFile();// 实例化上传类

			$upload->maxSize  = 2000000 ;// 上传大小2M

			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

            mkdir("./app/Uploads/" . date('Y-m-d') . '/',0777,true);
            $upload->savePath = "./app/Uploads/" . date('Y-m-d') . '/';
			
			if(!$upload->upload()) {
				$this->assign('title', '上传失败');
				$this->assign('message', $upload->getErrorMsg());
				$this->error();

			} else {
				$info =  $upload->getUploadFileInfo();
			}

			$upload_file = M("uploaded_file");
			
			foreach($info as $key => $val) {

				$data['uid']       = I('session.uid_id', '', null);
				$data['file_type'] = $val['extension'];
				$data['file_size'] = $val['size'];
				$data['file_name'] = $val['name'];

				$data['file_path'] = $val['savepath'] . $val['savename'];	// 1 上线 2 下线
				$data['add_time']  = time();
				$data['belong']    = I('post.belong', '', 'intval');
				$data['item_id']   = 1;

				$upload_file->data($data)->add();
			}
		
			$this->assign('title', '上传成功');
			$this->assign('jumpUrl', U('class/photoList'));
			$this->success();
		}
	}
	
	/**
	 *	删除 
	 */
	public function del() {

		if($this->checkPermission() <= 0) {
			
			$this->ajaxReturn('', '您未登录或无权限访问此页面！', -1);
		}
		
		$fid = isset($_REQUEST['fid']) ? intval($_REQUEST['fid']) : NULL;

		if(!$fid) {
			$this->ajaxReturn('', '参数ID有误', -1);
		}

		$upload_file = M('uploaded_file');

		$condition = array();
		$condition['file_id'] = array('eq', $fid);

		$info = $upload_file->where($condition)->find();

		if(!$info) {
			$this->ajaxReturn('', '参数ID有误', -1);
		}

		$ret = $upload_file->where($condition)->delete();


	
		if($ret) {
			$this->ajaxReturn('', '删除成功', 1);
		} else {
			$this->ajaxReturn('', '删除失败', -1);
		}

	}

     /**
      * 班级首页
      */
     public function detail(){
         $id = intval($_GET['id']);
//         echo $id;
         if($id>0){


             $obj = M('class_msg_cate');
             $where = "cate_id = ".$id;
             $info = $obj->where($where)->find();
//             print_r($info);
             $this->assign('info',$info);

             //画室的相册

             //画室的消息

//echo 3;
             //班级作业
//             $h_mob = M('homework');
//             $hList = $h_mob->where("class_id in (".$id.")")->select();
//             $this->assign('hList',$hList);

             //班级通知
//             echo 2;

             $t_mod = M('class_msg');
             $tList = $t_mod->field("title,msg_id")->where("cate_id =".$id)->select();
//             echo $t_mod->getLastSql();
             $this->assign('tList',$tList);

//             print_r($tList);

//             $this->display('Class:detail');

             //班级相册

             $f_mod = M('uploaded_file');
             $pList = $f_mod->where("belong ={$id} and item_id = 1")->select();
             $this->assign('pList',$pList);

//             print_r($pList);

//             echo $id;die;

             $this->display('Class:detail');




//             print_r($info);
         } else {
             $this->error('班级错误！');
         }
     }

}
?>