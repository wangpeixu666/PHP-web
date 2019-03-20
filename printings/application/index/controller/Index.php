<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Db;
use think\Request;

/**
 * @官网首页
 * @Class Index
 * @Author: wangpeixu
 * @package app\index\controller
 */
class Index extends HomeBase
{
    public function index()
    {
        /*$ban  = $this->request->param('ban');*/
//       $ban = array('ban'=>01);//给banner图传值
        //首页banner图更换
      /*  $bannerimg = Db::table('os_slide')
            ->select();*/
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
//        print_r($print_banner02);die();
        //首页实时新闻展示
        $printnews_list = Db::table('os_printnews')
            ->order('id DESC')
            ->limit('5')
            ->select();
        //首页集团动态展示
        $printgroup_list = Db::table('os_printgroup')
            ->order('id DESC')
            ->limit('5')
            ->select();
        //首页实时新闻三张图片数据
        $printnews_left = Db::table('os_printnews')
            ->order('id DESC')
            ->limit('3')
            ->select();
        //首页集团三张动态图数据
/*        $printgroup_right = Db::table('os_printgroup')
            ->order('id DESC')
            ->limit('3')
            ->select();*/
        //首页公司文化三张图数据
        $printgroup_right = Db::table('os_printculture')
            ->order('id DESC')
            ->limit('3')
            ->select();
        //首页公司简介展示
        $printcompany_list = Db::table('os_printcompany')
            ->field('introduction')
            ->where('id',1)
            ->find();
        //首页公司文化介绍（纸质文化）
/*        $printpaper_list = Db::table('os_printpaper')
            ->order('id DESC')
            ->limit('5')
            ->select();*/
        //首页公司文化新闻
        $printculture_list = Db::table('os_printculture')
            ->order('id DESC')
            ->limit('5')
            ->select();
        $printcompany   = htmlspecialchars_decode($printcompany_list['introduction']);
//        $printpaper     = htmlspecialchars_decode($printpaper_list['content']);
        $banner01 = $print_banner01[0]['image'];//首页banner
        $banner02 = $print_banner02[0]['image'];//关于我们banner
        $banner03 = $print_banner03[0]['image'];//纸张知识banner
        $banner04 = $print_banner04[0]['image'];//联系我们banner
        $banner05 = $print_banner05[0]['image'];//云端存储banner
        return $this->fetch('index',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
//                'ban'    => $ban,//banne图
                'printnews_list'    => $printnews_list,//时事新闻
                'printgroup_list'   => $printgroup_list,//公司动态
                'printnews_left'    => $printnews_left,//时事新闻三张图片
//                'printgroup_right'  => $printgroup_right,//公司动态三张图片
                'printgroup_right'  => $printgroup_right,//公司动态三张图片
                'printcompany'      => $printcompany,//公司简介
//                'printpaper_list'   => $printpaper_list,//纸张知识
                'printculture_list'   => $printculture_list,//纸张知识
            ]
        );
        //return $this->fetch();
    }

    /**
     * @时事新闻列表页
     * @Class newslist
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function newslist()
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
        //首页实时新闻
        $news_list = Db::table('os_printnews')
            ->order('id DESC')
            ->limit('20')
            ->select();
        $banner01 = $print_banner01[0]['image'];//首页banner
        $banner02 = $print_banner02[0]['image'];//关于我们banner
        $banner03 = $print_banner03[0]['image'];//纸张知识banner
        $banner04 = $print_banner04[0]['image'];//联系我们banner
        $banner05 = $print_banner05[0]['image'];//云端存储banner
        return $this->fetch('newslist',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
                'printnews_list' => $news_list,
                ]);
        //return $this->fetch();
    }
    /**
     * @首页时事新闻详情页
     * @Class news
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function news($id)
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
        //首页实时新闻展示
        $news = Db::table('os_printnews')
            ->field('*')
            ->where('id',$id)
            ->find();
        $news_content   = htmlspecialchars_decode($news['content']);
        return $this->fetch('news', [
            'banner01'    => $banner01,//banner01
            'banner02'    => $banner02,//banner02
            'banner03'    => $banner03,//banner03
            'banner04'    => $banner04,//banner04
            'banner05'    => $banner05,//banner05
            'printnews_list' => $news,'printnews' => $news_content,
            ]);
    }


    /**
     * @动态列表页
     * @Class group_list
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function grouplist()
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
        //动态
        $group_list = Db::table('os_printgroup')
            ->order('id DESC')
            ->limit('20')
            ->select();
        return $this->fetch('grouplist',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
                'group_list' => $group_list,
                ]);
        //return $this->fetch();
    }
    /**
     * @动态详情页
     * @Class group
     * @Author: wangpeixu
     * @package app\index\controller
     */
    public function group($id)
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
        //首页公司动态
        $printgroup = Db::table('os_printgroup')
            ->field('*')
            ->where('id',$id)
            ->find();
        $printgroup_content   = htmlspecialchars_decode($printgroup['content']);
        return $this->fetch('group',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05
                'printgroup_list' => $printgroup,'printgroup' => $printgroup_content,]);
        //return $this->fetch();
    }








}
