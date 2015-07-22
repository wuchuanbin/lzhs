<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {
    public function index(){

        //我所在的班级
        $obj = M('class_msg_cate');
        $user = $_SESSION['userInfo'];
        if($user['class_id1']<=0 && $user['class_id2']<=0){
            $class = false;
        } else {
            $class = $obj->where("cate_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        }
        $this->assign('class',$class);


        //班级作业
        $h_mob = M('homework');
        $hList = $h_mob->where("class_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        $this->assign('hList',$hList);


        //班级通知

        $t_mod = M('class_msg');
        $tList = $t_mod->field("title,msg_id")->where("cate_id in (".$user['class_id1'].','.$user['class_id2'].")")->select();
        $this->assign('tList',$tList);


        //班级相册

        $f_mod = M('uploaded_file');
        $pList = $f_mod->where("belong in (".$user['class_id1'].','.$user['class_id2'].") and item_id = 1")->select();
        $this->assign('pList',$pList);

        //班级作业图片

        $f_mod = M('uploaded_file');
        $pList2 = $f_mod->where("belong in (".$hList[0]['id'].','.$hList[1]['id'].") and item_id = 2")->select();
        $this->assign('pList2',$pList2);

        $this->display('index');










    }

    /**
     * 作业详情
     */
    public function homework(){
        $id = intval($_GET['id']);
        $obj = M('uploaded_file');
        $list = $obj->where("belong = ".$id)->select();
        $this->assign('list',$list);
        $obj2 = M('homework');
        $this->assign('homework',$obj2->where("id = ".$id)->find());
        $this->display('homework');
    }


}