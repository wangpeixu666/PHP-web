<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use app\common\model\Paperhow as ArticleModel;
use app\common\model\Category as CategoryModel;
use think\Controller;
use think\Db;

/**
 * @纸质文化
 * Class Paperhow
 * Author: wangpeixu
 * @package app\index\controller
 */
class Paperhow extends HomeBase
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
        //ID=8：胶版纸内容展示
        $printpaper_08 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',8)
            ->find();
        //ID=9：铜版纸内容展示
        $printpaper_09 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',9)
            ->find();
        //ID=10：轻型纸内容展示
        $printpaper_10 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',10)
            ->find();
        //ID=11：纯质纸内容展示
        $printpaper_11 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',11)
            ->find();
        //ID=12：轻涂纸内容展示
        $printpaper_12 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',12)
            ->find();
        //ID=13：字典纸内容展示
        $printpaper_13 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',13)
            ->find();
        //ID=14：新闻纸内容展示
        $printpaper_14 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',14)
            ->find();
        //ID=15：特种纸内容展示
        $printpaper_15 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',15)
            ->find();
        //ID=16：纸浆内容展示
        $printpaper_16 = Db::table('os_printpaper')
            ->field('thumb,content')
            ->where('id',16)
            ->find();
        $printpaper08     = htmlspecialchars_decode($printpaper_08['content']);
        $printpaper09     = htmlspecialchars_decode($printpaper_09['content']);
        $printpaper10     = htmlspecialchars_decode($printpaper_10['content']);
        $printpaper11     = htmlspecialchars_decode($printpaper_11['content']);
        $printpaper12     = htmlspecialchars_decode($printpaper_12['content']);
        $printpaper13     = htmlspecialchars_decode($printpaper_13['content']);
        $printpaper14     = htmlspecialchars_decode($printpaper_14['content']);
        $printpaper15     = htmlspecialchars_decode($printpaper_15['content']);
        $printpaper16     = htmlspecialchars_decode($printpaper_16['content']);
        return $this->fetch('index',
            [
                'banner01'    => $banner01,//banner01
                'banner02'    => $banner02,//banner02
                'banner03'    => $banner03,//banner03
                'banner04'    => $banner04,//banner04
                'banner05'    => $banner05,//banner05

                'printpaper08_thum' => $printpaper_08,//胶版纸图
                'printpaper09_thum' => $printpaper_09,//铜版纸
                'printpaper10_thum' => $printpaper_10,//轻型纸
                'printpaper11_thum' => $printpaper_11,//纯质纸
                'printpaper12_thum' => $printpaper_12,//轻涂纸
                'printpaper13_thum' => $printpaper_13,//字典纸
                'printpaper14_thum' => $printpaper_14,//新闻纸
                'printpaper15_thum' => $printpaper_15,//特种纸
                'printpaper16_thum' => $printpaper_16,//纸浆

                'printpaper08' => $printpaper08,//胶版纸内容
                'printpaper09' => $printpaper09,//铜版纸
                'printpaper10' => $printpaper10,//轻型纸
                'printpaper11' => $printpaper11,//纯质纸
                'printpaper12' => $printpaper12,//轻涂纸
                'printpaper13' => $printpaper13,//字典纸
                'printpaper14' => $printpaper14,//新闻纸
                'printpaper15' => $printpaper15,//特种纸
                'printpaper16' => $printpaper16,//纸浆
            ]
        );
        return $this->fetch();
    }

    /**
     * @文化新闻列表页
     * @Class culturelist
     * @Author: wangpeixu
     * @package app\index\controller
     */
/*    public function printpaperlist()
    {
        //首页实时新闻
        $printpaper_list = Db::table('os_printpaper')
            ->order('id DESC')
            ->limit('20')
            ->select();
        return $this->fetch('printpaperlist', ['printpaper_list' => $printpaper_list]);
        //return $this->fetch();
    }*/
    /**
     * @纸张新闻详情页
     * @Class news
     * @Author: wangpeixu
     * @package app\index\controller
     */
/*    public function printpaper($id)
    {
        //纸张知识内容页展示
        $printpaper = Db::table('os_printpaper')
            ->field('*')
            ->where('id',$id)
            ->find();
        $printpaper_content   = htmlspecialchars_decode($printpaper['content']);
        return $this->fetch('printpaper', ['printpaper' => $printpaper,'printpaper_content' => $printpaper_content]);
    }*/






}