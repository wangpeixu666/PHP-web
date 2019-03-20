<?php

namespace Home\Controller;

use Think\Controller;
/**
 * 发布文章必须登录
 */
class PostController extends BaseController{

    public function index($name){
        $this->display();
    }

    public function view($id){
        $post = M('postbook')->find($id);
        $this->assign('postbook', $post);
        $this->display();
    }
}
