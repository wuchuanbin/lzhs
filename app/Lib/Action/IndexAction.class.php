<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){

        
	//$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <p>欢迎使用 <b>txlz.cc</b>！</p></div>','utf-8');
    //获取画室相册和作品展示
        $url = $_SERVER['DOCUMENT_ROOT'].'/app/Uploads/indexPic/';
        $info = glob($url.'*');
        $r = array();
        foreach($info as $v){
            $tmp = pathinfo($v);
            $r[] = '/app/Uploads/indexPic/'.$tmp['basename'];
        }
        $this->assign('zuopin',$r);

        $url = $_SERVER['DOCUMENT_ROOT'].'/app/Uploads/indexRoom/';
        $info = glob($url.'*');
        $r = array();
        foreach($info as $v){
            $tmp = pathinfo($v);
            $r[] = '/app/Uploads/indexRoom/'.$tmp['basename'];
        }
        $this->assign('room',$r);

        $this->display();

    }
}