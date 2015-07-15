<?php
/**
 * Created by PhpStorm.
 * User: chuanbin
 * Date: 15/7/15
 * Time: 22:51
 */

class LoginAction extends Action{

    //Login
    public function login(){
        //username password check
        $where['user_name'] = $_POST['user_name'];
        $where['password'] = $_POST['password'];

        $where['user_name'] = '小王';
        $where['password'] = '123456';
        $obj = M('users');
        $info = $obj->where($where)->find();
        if(!empty($info)){
            $this->_doLogin($info['uid'],$info);
            $this->success('登录成功！');
        } else {
            $this->error('登录失败');
        }
    }

    /**
     * Log out
     */
    public function logOut(){
        session_destroy();
        unset($_SESSION['uid']);
        $_SESSION['in_sys'] = false;
        unset($_SESSION['userInfo']);
        header('Location:/');
    }

    /**
     * use uid to login
     * @param $uid
     */
    public function _doLogin($uid,$userInfo){
        //
        $_SESSION['uid'] = $uid;
        $_SESSION['in_sys'] = true;
        $_SESSION['userInfo'] = $userInfo;
    }
}