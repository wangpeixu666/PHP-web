<?php
namespace Admin\Controller;
use Think\Controller;
/**
*	@author wangpeixu
*/
class BaseController extends Controller {
    public function _initialize(){
        $sid = session('adminId');
        //判断用户是否登陆
        if(!isset($sid ) ) {
            redirect(U('Login/index'));
        }

    }

}