<?php
/**
 * Manager Controller
 */
class ManagerAction extends Action {
    public function index(){
        $this->display();
    }


    /**
     * UserList
     */

    function UserList(){
        //$obj = M('user');
        //$list = $obj->select();
        //$this->assign('list',$list);
        $this->display();
    }


}