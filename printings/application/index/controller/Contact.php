<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Db;

/**
 * @联系我们
 * Class Contact
 * Author: wangpeixu
 * @package app\index\controller
 */
class Contact extends HomeBase
{
    public function index()
    {
        //首页banner图更换
        $print_banner01 = Db::table('os_slide')
            ->field('*')
            ->where('id',1)
            ->select();
        $print_banner02 = Db::table('os_slide')
            ->field('*')
            ->where('id',2)
            ->select();
        $print_banner03 = Db::table('os_slide')
            ->field('*')
            ->where('id',3)
            ->select();
        $print_banner04 = Db::table('os_slide')
            ->field('*')
            ->where('id',4)
            ->select();
        $print_banner05 = Db::table('os_slide')
            ->field('*')
            ->where('id',5)
            ->select();
        $banner01 = $print_banner01[0]['image'];//首页banner
        $banner02 = $print_banner02[0]['image'];//关于我们banner
        $banner03 = $print_banner03[0]['image'];//纸张知识banner
        $banner04 = $print_banner04[0]['image'];//联系我们banner
        $banner05 = $print_banner05[0]['image'];//云端存储banner
        //联系我们
        $aboutus = Db::table('os_printcompany')
            ->field('*')
            ->where('id',1)
            ->find();
//        print_r($aboutus);die();
        return $this->fetch('index', [
            'banner01'    => $banner01,//banner01
            'banner02'    => $banner02,//banner02
            'banner03'    => $banner03,//banner03
            'banner04'    => $banner04,//banner04
            'banner05'    => $banner05,//banner05
            'aboutus' => $aboutus,
        ]);
    }

    //百度地图引入
    public function baidumap()
    {
        return $this->fetch();
    }

}