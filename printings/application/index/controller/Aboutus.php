<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Db;

/**
 * @关于我们
 * Author: wangpeixu
 * Class Aboutus
 * @package app\index\controller
 */
class Aboutus extends HomeBase
{
    public function index()
    {
        //首页banner图更换
        /*  $bannerimg = Db::table('os_slide')
              ->select();*/
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
        //关于我们的公司简介
        $aboutus = Db::table('os_printcompany')
            ->field('*')
            ->where('id',1)
            ->find();
//        print_r($aboutus);die();
        //友情链接展示
        $aboutlink_a = Db::table('os_link')
            ->order('id asc')
            ->limit(0,17)
            ->select();
        $aboutlink_b = Db::table('os_link')
            ->order('id asc')
            ->limit(18,17)
            ->select();
        $aboutlink_c = Db::table('os_link')
            ->order('id asc')
            ->limit(35,17)
            ->select();
        $aboutuscontent  = htmlspecialchars_decode($aboutus['content']);
        $banner01 = $print_banner01[0]['image'];//首页banner
        $banner02 = $print_banner02[0]['image'];//关于我们banner
        $banner03 = $print_banner03[0]['image'];//纸张知识banner
        $banner04 = $print_banner04[0]['image'];//联系我们banner
        $banner05 = $print_banner05[0]['image'];//云端存储banner
        //var_dump($printnews_list);die();
        return $this->fetch('index', [
            'banner01'    => $banner01,//banner01
            'banner02'    => $banner02,//banner02
            'banner03'    => $banner03,//banner03
            'banner04'    => $banner04,//banner04
            'banner05'    => $banner05,//banner05
            'aboutus' => $aboutus,
            'aboutuscontent' => $aboutuscontent,
            'aboutlink_a' => $aboutlink_a,
            'aboutlink_b' => $aboutlink_b,
            'aboutlink_c' => $aboutlink_c,
            ]);
        //return $this->fetch();
    }
    /**
     * @公司简介详情页
     * @Class news
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function detail($id=1)
    {
        //首页banner图更换
        /*  $bannerimg = Db::table('os_slide')
              ->select();*/
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
        //首页实时新闻展示
        $printcompany = Db::table('os_printcompany')
            ->field('*')
            ->where('id',$id)
            ->find();
        //print_r($printcompany);die();
        $banner01 = $print_banner01[0]['image'];//首页banner
        $banner02 = $print_banner02[0]['image'];//关于我们banner
        $banner03 = $print_banner03[0]['image'];//纸张知识banner
        $banner04 = $print_banner04[0]['image'];//联系我们banner
        $banner05 = $print_banner05[0]['image'];//云端存储banner
        $printcompany_content   = htmlspecialchars_decode($printcompany['content']);
        return $this->fetch('detail',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
            'printcompany_list' => $printcompany,'printcompany' => $printcompany_content,
            ]);
    }


}
