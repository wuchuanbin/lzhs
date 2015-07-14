<?php

/**
 *	文章类
 */
 class ArticleAction extends Action{
	
	public function __construct() {
		
		//检查是否登录，是否有权限
		parent::__construct();
		
	}

	/**
	 *	文章列表
	 *	order 排序方式 add_time时间 / sort_order权重 / cate_id类别 默认 add_time  
	 */
	public function index() {

		$order = empty($_REQUEST['order']) ? 'add_time' : htmlspecialchars($_REQUEST['order']);

		$article = M('article');

		import('ORG.Util.Page');

		$count = $article->count();

		$page = new Page($count, 2, 'order=' . $order);

		$show = $page->show();

		$list = $article->order($order . ' desc')->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//$user = M('users');
		$cate = M('article_cate');

		foreach($list as $key => $val) {
			//$username = $user->field('user_name')->where('uid=' . $val['uid_id'])->find();
			$catename     = $cate->field('cate_name')->where('cate_id=' . $val['cate_id'])->find();
			$list[$key]['username'] = $username['user_name'];
			$list[$key]['cate']     = $catename['cate_name'];
		}

		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->display();
	}
	
	/**
	 *	添加文章
	 */
	public function add() {
		
		if($_POST) {
			
			$article = M('article');

//			if(!$article->create()) {
//				$this->ajaxReturn('', $article->getError(), -1);
//			}

			$data = $_POST;

			$data['title']      = I('post.title');
			$data['cate_id']    = I('post.cate_id', '', 'intval');
			$data['content']    = I('post.content', '', 'htmlspecialchars');
			$data['sort_order'] = I('post.sort_order', 1);	//权重默认为 1
			$data['uid_id']     = I('session.uid_id', 3);	//暂时默认用户test 对应id 3 
			$data['if_show']    = I('post.if_show', '', 'intval');	// 1 上线 2 下线
			$data['add_time']   = time();
			$data['ip']         = get_client_ip();

			$ret = $article->data($data)->add();
	
			if($ret) {
				$this->ajaxReturn(U('article/index'), '新增成功', 1);
			} else {
				$this->ajaxReturn('', '新增失败', -1);
			}
		} else {
			$cate = M('article_cate');

			$list = $cate->select();

			$this->assign('cate_list', $list);
			$this->display();
		}
	}

	/**
	 *	编辑文章
	 */
	public function edit() {
		
		$aid = isset($_REQUEST['aid']) ? intval($_REQUEST['aid']) : NULL;

		if(!$aid) {
			$this->assign('title', '编辑失败');
			$this->assign('message', '文章ID有误');
			$this->error();
		}

		$article = D('article');

		$condition = array();
		$condition['article_id'] = array('eq', $aid);

		$info = $article->where($condition)->find();

		if(!$info) {
			$this->assign('title', '编辑失败');
			$this->assign('message', '文章ID有误');
			$this->error();
		}

		$cate = M('article_cate');

		$list = $cate->select();

		$this->assign('cate_list', $list);

		if($_POST) {

			if(!$article->create()) {
				$this->assign('title', '编辑失败');
				$this->assign('message', $article->getError());
				$this->error();
			}

			$data['title']      = I('post.title');
			$data['cate_id']    = I('post.cate_id', '', 'intval');
			$data['content']    = I('post.content', '', 'htmlspecialchars');
			$data['sort_order'] = I('post.sort_order');	//权重默认为 1
			$data['if_show']    = I('post.if_show', '', 'intval');	// 1 上线 2 下线

			$ret = $article->where($condition)->save($data);
	
			if($ret) {
				$this->assign('title', '编辑成功');
				$this->success();
			} else {
				$this->assign('title', '编辑失败');
				$this->assign('message', '请求失败，请重试');
				$this->error();
			}
		}

		$this->assign('info', $info);

		$this->display();
	}

	/**
	 *	操作 if_show = 1 上线 / if_show = 2 下线 
	 */
	public function operation() {
		
		$aid     = isset($_GET['aid'])     ? intval($_GET['aid'])     : NULL;
		$if_show = isset($_GET['if_show']) ? intval($_GET['if_show']) : NULL;

		if(!$aid) {
			$this->assign('title', '操作失败');
			$this->assign('message', '文章ID有误');
			$this->error();
		}

		if(!$if_show) {
			$this->assign('title', '操作失败');
			$this->assign('message', '文章上（下）线请求失败，请重试');
			$this->error();
		}

		$article = M('article');

		$condition = array();
		$condition['article_id'] = array('eq', $aid);

		$info = $article->where($condition)->find();

		if(!$info) {
			$this->assign('title', '操作失败');
			$this->assign('message', '文章ID有误');
			$this->error();
		}

		$data['if_show'] = $if_show;

		$ret = $article->where($condition)->save($data);
	
		if($ret) {
			$this->assign('title', '操作成功');
			$this->success();
		} else {
			$this->assign('title', '操作失败');
			$this->assign('message', '文章上（下）线请求失败，请重试');
			$this->error();
		}

	}

	/**
	 *	上传文件
	 */
	public function upload(){ 
		
		$max_file_size = 2000000; //上传文件大小
        $extensions = array("jpg","bmp","gif","png");	//上传文件类型
		if($_SERVER['HTTP_HOST'] == 'www.txlz.cc') {
			$uploadPath = "/home/lzhstljzph2s/wwwroot/app/Uploads/" . date('Y-m-d') . '/';
		} else {
			
			$uploadPath = "E:/lzhs/app/Uploads/" . date('Y-m-d') . '/';
		}
		
        $uploadFilename = $_FILES['upload']['name'];

		if($max_file_size < $_FILES['upload']["size"]) {  
			echo "<font color=\"red\"size=\"2\">*请上传小于2M的图片</font>";  
			exit;  
		}

		if(!file_exists($uploadPath)) {  
			if(!mkdir($uploadPath, 0777, true)) {
				echo "<font color=\"red\"size=\"2\">*上传目录不存在</font>"; 
				exit;
			}
		}  

        $extension = pathInfo($uploadFilename,PATHINFO_EXTENSION);
		
        if(in_array($extension,$extensions)){  
 
            $uuid = str_replace('.','',uniqid("",TRUE)).".".$extension;  
            $desname = $uploadPath.$uuid;  
            $previewname = 'app/Uploads/' . date('Y-m-d') . '/'. $uuid;  
            $tag = move_uploaded_file($_FILES['upload']['tmp_name'],$desname);  
            $callback = $_REQUEST["CKEditorFuncNum"];  

            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'".$previewname."','');</script>";
			exit;
        }else{  
            echo "<font color=\"red\"size=\"2\">*文件格式不正确（必须为.jpg/.gif/.bmp/.png文件）</font>"; 
			exit;
        }  
    }  

}
?>