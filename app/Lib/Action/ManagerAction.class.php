<?php
/**
 * Manager Controller
 */
class ManagerAction extends Action {
    public function index(){
        $this->display();
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
     * UserList
     */

    function UserList(){

		if($this->checkPermission() <= 0 || $this->checkPermission() == 2) {
			
			$this->assign('title', '您未登录或无权限访问此页面！');
			$this->error();
		}

        $order = empty($_REQUEST['order']) ? 'reg_time' : htmlspecialchars($_REQUEST['order']);
        $type = empty($_REQUEST['type']) ? false : htmlspecialchars($_REQUEST['type']);
        $where = array();
        if(!empty($type)){
            if($type=='teacher'){
                $where['is_admin'] = 2;
                $this->assign('title','老师列表');
            } elseif($type=='admin'){
                $where['is_admin'] = 1;
                $this->assign('title','管理员列表');
            }
        } else {
            $where['is_admin'] = 0;
            $this->assign('title','学生列表');
        }

        $obj = M('users');

        import('ORG.Util.Page');

        $count = $obj->where($where)->count();
//        echo $count;
//        echo 888;
        $page = new Page($count, 20, 'order=' . $order);
//echo 555;
        $show = $page->show();
//echo 123;
        $list = $obj->where($where)->order($order . ' desc')->limit($page->firstRow . ',' . $page->listRows)->select();
//        echo $obj->getLastSql();
//print_r($list);
        $user = M('users');

        foreach($list as $key => $val) {
        }

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('Manager:UserList');
    }



    /**
     * 删除用户
     */
    function delOne(){

        $id = intval($_GET['uid']);
//        echo $id;
        if($id>0){
            $obj = M('users');
            $obj->where("uid = ".$id)->delete();
//            echo $obj->getLastSql();
            $data['done'] = true;
            echo json_encode($data);
        } else {
            $data['done'] = false;
            echo json_encode($data);
        }
    }

    /**
     * 学生信息导入
     */
    function importStudents(){
        if($_POST){
            import('ORG.Net.UploadFile');
            $upload = new UploadFile();// 实例化上传类
            $upload->maxSize  = 2000000 ;// 上传大小2M
            $upload->allowExts  = array('csv');// 设置附件上传类型
            $upload->savePath = "./app/Uploads/student/";

            if(!$upload->upload()) {
                $this->assign('title', '上传失败');
                $this->assign('message', $upload->getErrorMsg());
                $this->error();
            } else {
                $info =  $upload->getUploadFileInfo();
                $data = file($info[0]['savepath'].$info[0]['savename']);
                $data = $this->arrayCoding($data,'gb2312','utf-8');
                unset($data[0]);
                $dtime = time();
                $obj = M('users');
                $i=0;
                foreach($data as $v){
                    $s = explode(',',$v);
                    $sql = "insert into users (`uid`,`user_name`,`email`,`password`,`is_admin`,`class_id1`,`class_id2`,`status`,`reg_time`)";
                    $sql .=" VALUES ('NULL','{$s[2]}','{$s[1]}','{$s[3]}','{$s[4]}','{$s[5]}','{$s[6]}',1,{$dtime})";
                    $obj->query($sql);
                    unset($sql);
                }
                $this->success('ok!');
            }
        } else {
            $this->display('import');
        }
    }


    //array coding
    function arrayCoding ($array, $inCharset, $outCharset) {
        if (!is_array($array))
            return false;
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                arrayCoding($value, $inCharset, $outCharset);
            } else {
                $value = iconv($inCharset, $outCharset, $value);
            }
        }
        return $array;
    }

    function exportStudents(){
        // 文件标签
        // Header("Content-type: application/octet-stream");
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        Header("Content-Disposition: attachment; filename=users.csv");
        //echo '商品名称，商品价格';
        //遍历商品信息
        $obj = M('users');
        $list = $obj->select();
        echo iconv('utf-8', 'gb2312', '用户ID,邮箱,名字,密码,老师写2 管理员1 学生0,第一所属班级ID,第二班级ID'."\n");
        foreach($list as $v1){
            echo iconv('utf-8', 'gb2312', $v1['uid'].','.$v1['email'].','.$v1['user_name'].','.$v1['password'].','.$v1['is_admin'].','.$v1['class_id1'].','.$v1['class_id2'].",\n");
        }
    }

    /**
     * 用户信息编辑 单个用户增加
     */
    function userExec(){

		if($this->checkPermission() <= 0 || $this->checkPermission() == 2) {
			
			$this->assign('title', '您未登录或无权限访问此页面！');
			$this->error();
		}

        $obj = M('users');
        $uid = $_GET['uid'];//if not exec addaction   else   editaction


        //class list
        $cate = M('class_msg_cate');

        $list = $cate->select();

        $this->assign('cate_list', $list);

        if($_POST) {
            //info
            $data['email'] = $_POST['email'];
            $data['user_name'] = $_POST['user_name'];
            $data['password'] = $_POST['password'];
            $data['reg_time'] = strtotime($_POST['reg_time']);
            $data['status'] = $_POST['status'];
            $data['is_admin'] = $_POST['is_admin'];
            $data['class_id1'] = $_POST['class_id1'];
            $data['class_id2'] = $_POST['class_id2'];

            if($data['class_id1']==$data['class_id2']){
                $this->error('两个班级不能一样！');
            }

            if ($uid > 0) {
                //edit
                $where['uid'] = $uid;
                $ret = $obj->where($where)->save($data);
            } else {
                //add
                $ret = $obj->add($data);
            }
            if ($ret) {
                $this->success('ok');
            } else {
                $this->error('Fail');
            }
        } else {
            if($uid>0){
                $info = $obj->where("uid = ".$uid)->find();
                $this->assign('info',$info);
                $this->assign('title','编辑用户');
            } else {
                $this->assign('title','新增用户');
            }

            $this->display('userExec');
        }
    }


    function HomeWorkList(){
        $order = empty($_REQUEST['order']) ? 'create_time' : htmlspecialchars($_REQUEST['order']);
        $type = empty($_REQUEST['type']) ? false : htmlspecialchars($_REQUEST['type']);
        $where = array();


        $obj = M('homework');

        import('ORG.Util.Page');

        $count = $obj->where($where)->count();
//        echo $count;
//        echo 888;
        $page = new Page($count, 20, 'order=' . $order);
//echo 555;
        $show = $page->show();
//echo 123;
        $list = $obj->where($where)->order($order . ' desc')->limit($page->firstRow . ',' . $page->listRows)->select();
//        echo $obj->getLastSql();
//print_r($list);


        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('Manager:HomeWorkList');
    }

    function dianPing(){
        $order = empty($_REQUEST['order']) ? 'add_time' : htmlspecialchars($_REQUEST['order']);
        $type = empty($_REQUEST['type']) ? false : htmlspecialchars($_REQUEST['type']);
        $id = $_GET['id'];
        $where = array('belong'=>$id);



        $obj = M('uploaded_file');

        import('ORG.Util.Page');

        $count = $obj->where($where)->count();
//        echo $count;
//        echo 888;
        $page = new Page($count, 20, 'order=' . $order);
//echo 555;
        $show = $page->show();
//echo 123;
        $list = $obj->where($where)->order($order . ' desc')->limit($page->firstRow . ',' . $page->listRows)->select();
//        echo $obj->getLastSql();
//print_r($list);


        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('Manager:dianPing');
    }

    function setPing(){
        unset($_POST['submit']);
        unset($_POST['__hash__']);
        $obj = M('uploaded_file');
        foreach($_POST as $key=>$value){
            $data['file_name'] = $value['file_name'];
            $data['remark'] = $value['remark'];
            $obj->where("file_id = ".$key)->save($data);
        }
        $this->assign('title', '评语设置成功！');
        $this->assign('jumpUrl', U('Manager/HomeWorkList'));
        $this->success();
    }


    function workExec(){
        $obj = M('homework');
        $id = $_GET['id'];//if not exec addaction   else   editaction


        //class list
        $cate = M('class_msg_cate');

        $list = $cate->select();

        $this->assign('cate_list', $list);

        if($_POST) {
            //info
            $data['name'] = $_POST['name'];
            $data['class_id'] = $_POST['user_name'];
            $data['tid'] = $_SESSION['uid'];
            $data['create_time'] = time();

            if ($id > 0) {
                //edit
                $where['id'] = $id;
                unset($data['create_time']);
                $ret = $obj->where($where)->save($data);
            } else {
                //add
                $ret = $obj->add($data);
            }
            if ($ret) {
                $this->success('ok');
            } else {
                $this->error('Fail');
            }
        } else {
            if($id>0){
                $info = $obj->where("id = ".$id)->find();
                $this->assign('info',$info);
                $this->assign('title','编辑作业');
            } else {
                $this->assign('title','新建作业');
            }

            $this->display('workExec');
        }
    }



    public function UpWork()
    {


//        $r = mkdir(dirname(__FILE__)."/app/Uploads/" . date('Y-m-d') . '/',0777,true);
//        echo dirname(__FILE__)."/app/Uploads/" . date('Y-m-d') . '/';
//        var_dump($r);
//        die;
        if (!$_POST) {
            $cate = M('homework');
            $list = $cate->select();
            $this->assign('list', $list);

            $this->display('UpWork');
        } else {

            import('ORG.Net.UploadFile');

            $upload = new UploadFile();// 实例化上传类

            $upload->maxSize = 2000000;// 上传大小2M

            $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

            mkdir("./app/Uploads/" . date('Y-m-d') . '/', 0777, true);
            $upload->savePath = "./app/Uploads/" . date('Y-m-d') . '/';
            if (!$upload->upload()) {
                $this->assign('title', '上传失败');
                $this->assign('message', $upload->getErrorMsg());
                $this->error();

            } else {
                $info = $upload->getUploadFileInfo();
            }
            $upload_file = M("uploaded_file");

            foreach ($info as $key => $val) {

                $data['uid'] = I('session.uid', '', null);
                $data['file_type'] = $val['extension'];
                $data['file_size'] = $val['size'];
                $data['file_name'] = strstr($val['name'],'.',true);
                //$tmp = explode($str, $val['savepath']);
                $data['file_path'] = $val['savepath'] . $val['savename'];    // 1 上线 2 下线
                $data['add_time'] = time();
                $data['belong'] = I('post.belong', '', 'intval');
                $data['item_id'] = 2;

                $upload_file->data($data)->add();
            }

            $this->assign('title', '上传成功');
            $this->assign('jumpUrl', U('Manager/UpWork'));
            $this->success();
        }
    }
        /**
         * 上传一寸照
         */
        public function upAvatar(){
            if(!$_POST) {
                $this->display('upAvatar');
            } else {
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();// 实例化上传类
                $upload->maxSize  = 2000000 ;// 上传大小2M
                $upload->allowExts  = array('jpg');// 设置附件上传类型
                mkdir('./app/Uploads/avatar/',0777,true);
                $upload->savePath = "./app/Uploads/avatar/";
                $upload->saveRule = '';
                if(!$upload->upload()) {
                    $this->assign('title', '上传失败');
                    $this->assign('message', $upload->getErrorMsg());
                    $this->error();

                } else {
                    $info =  $upload->getUploadFileInfo();
                }

                $this->assign('title', '上传成功');
                $this->assign('jumpUrl', U('Manager/UserList'));
                $this->success();
            }
    }


}