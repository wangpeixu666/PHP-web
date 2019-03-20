<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Db;

/**
 * @时事新闻
 * Class   Printnews
 * Author: wangpeixu
 * @package app\index\controller
 */
class Printnews extends HomeBase
{
    public function index()
    {
        return $this->fetch();
    }
}