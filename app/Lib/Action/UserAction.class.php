<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {
    public function index(){

//        print_r($_SESSION);

        if($_SESSION['userInfo']['is_admin']==2){
            header('Location:/index.php?m=User&a=teacher');
        }
//echo 1;
        //我所在的班级
        $obj = M('class_msg_cate');
        $user = $_SESSION['userInfo'];
        if($user['class_id1']<=0 && $user['class_id2']<=0){
            $class = false;
        } else {
            $class = $obj->where("cate_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        }
//        print_r($class);
        $this->assign('class',$class);

//echo 1;
        //班级作业
        $h_mob = M('homework');
        $hList = $h_mob->where("class_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        $this->assign('hList',$hList);
//echo 2;

        //班级通知

        $t_mod = M('class_msg');
        $tList = $t_mod->field("title,msg_id")->where("cate_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        $this->assign('tList',$tList);

//echo 3;
        //班级相册

        $f_mod = M('uploaded_file');
        $pList = $f_mod->where("belong in (".$user['class_id1'].','.$user['class_id2'].") and item_id = 1")->select();
        $this->assign('pList',$pList);
//echo 4;
        //班级作业图片
//var_dump($hList);
//        $f_mod = M('uploaded_file');
        if(empty($hList[1]['id'])) $hList[1]['id'] = 0;
        $pList2 = $f_mod->where("belong in (".$hList[0]['id'].','.$hList[1]['id'].") and item_id = 2")->select();
//        echo 44;
        $this->assign('pList2',$pList2);
//echo 44;
        $this->display('User:index');










    }

    public function teacher(){
//echo 1;
        //我所在的班级


//echo 1;
        //我所在的班级
        $obj = M('class_msg_cate');
        $user = $_SESSION['userInfo'];
        if($user['class_id1']<=0 && $user['class_id2']<=0){
            $class = false;
        } else {
            $class = $obj->where("cate_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        }
//        print_r($class);
        $this->assign('class',$class);


        //班级1 学生名单
        $s_mod = M('users');

        if($user['class_id1']>0){
            $c1 = $s_mod->where("class_id1 = '{$user['class_id1']}' or class_id2 = '{$user['class_id1']}'")->select();
            $this->assign('c1',$c1);
        }
        if($user['class_id2']>0){
            $c1 = $s_mod->where("class_id1 = '{$user['class_id2']}' or class_id2 = '{$user['class_id2']}'")->select();
            $this->assign('c1',$c1);
        }

//echo 1;
        //班级作业
        $h_mob = M('homework');
        $hList = $h_mob->where("tid ='{$_SESSION['uid']}'")->select();
        $this->assign('hList',$hList);
//echo 2;

        //班级通知

        $t_mod = M('class_msg');
        $tList = $t_mod->field("title,msg_id")->where("uid_id = '{$_SESSION['uid']}'")->select();
        $this->assign('tList',$tList);

//echo 3;
        //班级相册

        $f_mod = M('uploaded_file');
        $pList = $f_mod->where("belong in (".$user['class_id1'].','.$user['class_id2'].") and item_id = 1")->select();
        $this->assign('pList',$pList);
//echo 4;
        //班级作业图片
//var_dump($hList);
//        $f_mod = M('uploaded_file');

//echo 44;
        $this->display('User:teacher');











    }

    /**
     * 作业详情
     */
    public function homework(){
        $id = intval($_GET['id']);
        $obj = M('uploaded_file');
//        print_r($_SESSION);die;
        $uid = $_SESSION['uid'];
        $list = $obj->where("file_name = '{$uid}' and belong = ".$id)->select();
//        echo $obj->getLastSql();
        $this->assign('list',$list);
        $obj2 = M('homework');
        $this->assign('homework',$obj2->where("id = ".$id)->find());
        $this->display('homework');
    }


}