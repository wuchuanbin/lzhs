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

        $order = empty($_REQUEST['order']) ? 'uid' : htmlspecialchars($_REQUEST['order']);
        $type = empty($_REQUEST['type']) ? false : htmlspecialchars($_REQUEST['type']);
        $where = array();
        $where = '1 = 1';
        if(!empty($type)){
            if($type=='teacher'){
//                $where['is_admin'] = 2;
                $where .= " and  is_admin = 2 ";
                $this->assign('title','老师列表');
            } elseif($type=='admin'){
//                $where['is_admin'] = 1;
                $where .= " and  is_admin = 1 ";
                $this->assign('title','管理员列表');
            }
        } else {
//            $where['is_admin'] = 0;
            $where .= " and  is_admin = 0 ";
            $this->assign('title','学生列表');
        }

        if($_GET['class_id']>0){
            $where.= " and class_id1 = ".$_GET['class_id'] .' or class_id2 = '.$_GET['class_id'];
        }

        //class list
        $cate = M('class_msg_cate');

        $list = $cate->select();

        $this->assign('cate_list', $list);

        $obj = M('users');

        import('ORG.Util.Page');
//echo $where;die;
        $count = $obj->where($where)->count();
//        echo $obj->getLastSql();
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
        set_time_limit(0);
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
                // echo 1;die;
                $info =  $upload->getUploadFileInfo();
                $data = file($info[0]['savepath'].$info[0]['savename']);
                // $data = $this->arrayCoding($data,'gb2312','utf-8');
                unset($data[0]);
                $dtime = time();
                $obj = M('users');
                $i=0;
                // echo count($data);
                // print_r($data);die;
                foreach($data as $key=> $v){
                    // echo $v.'<br>';
                    // if(strlen($v)>0){
                        $s = explode(',',$v);
                        
                        // $t[$i]['uid'] = $s[0];
                        // $t[$i]['user_name'] = empty(iconv('gb2312','utf-8',$s[2])) ? '空的' : iconv('gb2312','utf-8',$s[2]);
                        // $t[$i]['email'] = $s[1];
                        // $t[$i]['password'] = $s[3];
                        // $t[$i]['is_admin'] = $s[4];
                        // $t[$i]['class_id1'] = $s[5];
                        // $t[$i]['class_id2'] = intval($s[6]);
                        // $t[$i]['status'] = 1;
                        // $t[$i]['reg_time'] = $dtime;
                        
                        // // echo $t[$i]['uid'].'---'.$t[$i]['user_name'].'<br>';
                        // $i++;


                        $kj['uid'] = $s[0];



                        $name = iconv('gb2312','utf-8',$s[2]);
                        if(empty($name)){
                            $name = '空的'.rand(1,999999);
                        }
                        $kj['user_name'] = $name;
                        $kj['email'] = $s[1];
                        $kj['password'] = $s[3];
                        $kj['is_admin'] = $s[4];
                        $kj['class_id1'] = $s[5];
                        $kj['class_id2'] = intval($s[6]);
                        $kj['status'] = 1;
                        $kj['reg_time'] = $dtime;
                        // $obj->create($kj);
                        $obj->add($kj);
                        // echo $obj->getLastSql().'<br>';



                    // }
                    
                    // $
                    // if($s[0]>0){
                    //     $uid = $s[0];
                    // } else {
                    //     $uid = '';
                    // }
                    // echo $uid.'<br>';
                    // $sql = "insert into users (`uid`,`user_name`,`email`,`password`,`is_admin`,`class_id1`,`class_id2`,`status`,`reg_time`)";
                    // $sql .=" VALUES ('{$uid}','{$s[2]}','{$s[1]}','{$s[3]}','{$s[4]}','{$s[5]}','{$s[6]}',1,{$dtime})";
                    // // echo $sql;die;
                    // $obj->query($sql);
                    // unset($sql);
                }
                // die;
                // echo count($t);die;
                // $obj->create($t);
                // echo '<pre>';
                // print_r($t);die;
                // $obj->addAll($kj);

                // echo $obj->getLastSql();
                // die;
                // print_r($t);die;
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






$obj2 = M('uploaded_file');
        foreach($list as $key=>$value){
//            $where = ' belong = "'.$value['id'].'" ';
//            print_r($where);
            $where = "belong = '{$value['id']}'";
            $list[$key]['count'] = $obj2->where($where)->count();
//            echo $obj->getLastSql();
        }
//        echo $obj->getLastSql();
//print_r($list);


        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display('Manager:HomeWorkList');
    }

	public function delWork() {
		
		$wid = isset($_REQUEST['wid']) ? intval($_REQUEST['wid'])     : NULL;

		if(!$wid) {
			$this->ajaxReturn('', '参数ID有误', -1);
		}

		$model = M('homework');

		$condition = array();
		$condition['id'] = array('eq', $wid);

		$info = $model->where($condition)->find();

		if(!$info) {
			$this->ajaxReturn('', '参数ID有误', -1);
		}


		$ret = $model->where($condition)->delete();

		$this->ajaxReturn('', '删除成功', 1);
	}

    function dianPing(){
        $order = empty($_REQUEST['order']) ? 'file_name' : htmlspecialchars($_REQUEST['order']);
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
        $u_mod = M('users');
        foreach($list as $key=>$value){
            $name = $u_mod->field('user_name')->where("uid = '".$value['file_name']."'")->find();
            $list[$key]['user_name'] = $name['user_name'];
        }
//        print_r($list);

        //获取上传了作业的总数
        $this->assign('count',$count);


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

            $u_mod = M('users');
            $str = '';
            foreach($_FILES['photo']['name'] as $key=>$val){
//                print_r($val);
                $id1 = pathinfo($val);
                $id =  intval($id1['filename']);
                //chaxun count
                $c = $u_mod->where('uid = '.$id)->count();
                if($c<=0){
                    $str .= $id1['filename'].' 对应的学生不存在！请核对后重新上传！'."\n";
                }


            }
//            echo $str;die;
            if(strlen($str)>0){
                echo "<script>alert(decodeURI('".urlencode($str)."'));window.location.href=document.referrer</script>";

                die;
            }

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



    /**
     * 遍历文件夹
     */
    public function listDir($dir)
    {
        $dir .= substr($dir, -1) == '/' ? '' : '/';
        $dirInfo = array();
        foreach (glob($dir . '*') as $v) {
            $dirInfo[] = $v;
            if (is_dir($v)) {
                $dirInfo = array_merge($dirInfo, $this->listDir($v));
            }
        }
    }

    /**
     * 首页的作品列表的管理页面
     */

    public function indexPic(){
        if (!$_POST) {
            $url = $_SERVER['DOCUMENT_ROOT'].'/app/Uploads/indexPic/';
            $info = glob($url.'*');
            $r = array();
            foreach($info as $v){

                $tmp = pathinfo($v);

                $r[] = '/app/Uploads/indexPic/'.$tmp['basename'];
            }
//            print_r($r);
            $this->assign('list',$r);
//
            $this->display('indexPic');
        } else {
            import('ORG.Net.UploadFile');
            $upload = new UploadFile();// 实例化上传类
            $upload->maxSize = 2000000;// 上传大小2M
            $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            mkdir("./app/Uploads/indexPic/", 0777, true);
            $upload->savePath = "./app/Uploads/indexPic/";
            if (!$upload->upload()) {
                $this->assign('title', '上传失败');
                $this->assign('message', $upload->getErrorMsg());
                $this->error();
            } else {
                $upload->getUploadFileInfo();
            }
            $this->assign('title', '上传成功');
            $this->assign('jumpUrl', U('Manager/indexPic'));
            $this->success();
        }
    }

    /**
     * 首页的画室环境页面
     */
    public function indexRoom(){
        if (!$_POST) {
            $url = $_SERVER['DOCUMENT_ROOT'].'/app/Uploads/indexRoom/';
            $info = glob($url.'*');
            $r = array();
            foreach($info as $v){

                $tmp = pathinfo($v);

                $r[] = '/app/Uploads/indexRoom/'.$tmp['basename'];
            }
//            print_r($r);
            $this->assign('list',$r);
//
            $this->display('indexRoom');
        } else {
            import('ORG.Net.UploadFile');
            $upload = new UploadFile();// 实例化上传类
            $upload->maxSize = 2000000;// 上传大小2M
            $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            mkdir("./app/Uploads/indexRoom/", 0777, true);
            $upload->savePath = "./app/Uploads/indexRoom/";
            if (!$upload->upload()) {
                $this->assign('title', '上传失败');
                $this->assign('message', $upload->getErrorMsg());
                $this->error();
            } else {
                $upload->getUploadFileInfo();
            }
            $this->assign('title', '上传成功');
            $this->assign('jumpUrl', U('Manager/indexRoom'));
            $this->success();
        }
    }

    /**
     * 删除图片
     */
    public function delThisPic(){
        $url = $_SERVER['DOCUMENT_ROOT'].trim($_POST['url']);
//        echo $url;
        @unlink($url);
        echo 1;

    }

}