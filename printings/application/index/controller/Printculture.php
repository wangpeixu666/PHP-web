<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use app\common\model\Printculture as ArticleModel;
use app\common\model\Category as CategoryModel;
use think\Controller;
use think\Db;

/**
 * @公司文化
 * Class Paperhow
 * Author: wangpeixu
 * @package app\index\controller
 */
class Printculture extends HomeBase
{

    /**
     * @公司文化新闻列表页
     * @Class culturelist
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function printculturelist()
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
        //文化新闻列表
        $printpaper_list = Db::table('os_printculture')
            ->order('id DESC')
            ->limit('20')
            ->select();
        return $this->fetch('printculturelist',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
                'printculture_list' => $printpaper_list,
            ]);
        //return $this->fetch();
    }
    /**
     * @公司文化新闻详情页
     * @Class printculture
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function printculture($id)
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
        //文化新闻详情
        $printpaper = Db::table('os_printculture')
            ->field('*')
            ->where('id',$id)
            ->find();
        $printpaper_content   = htmlspecialchars_decode($printpaper['content']);
        return $this->fetch('printculture',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
                'printculture' => $printpaper,'printculture_content' => $printpaper_content,
                ]);
    }






}