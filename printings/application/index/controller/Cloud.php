<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Config;
use think\Controller;
use think\Db;
use think\Session;
/**
 * @云端存储
 * Class Cloud
 * Author: wangpeixu
 * @package app\index\controller
 */
class Cloud extends HomeBase
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
        //云端存储注意事项
        $printcloud = Db::table('os_printcloud')
            ->field('*')
            ->where('id',1)
            ->select();
//        print_r($printcloud);die();
        $cloud_content   = htmlspecialchars_decode($printcloud[0]['content']);
        return $this->fetch('index', [
            'banner01'    => $banner01,//banner01
            'banner02'    => $banner02,//banner02
            'banner03'    => $banner03,//banner03
            'banner04'    => $banner04,//banner04
            'banner05'    => $banner05,//banner05
            'cloud' => $printcloud,'cloudcontent' => $cloud_content,
        ]);
    }
    public function file()
    {
        $printcloud = Db::table('os_printcloud')
            ->field('*')
            ->where('id',1)
            ->select();
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
        $cloud_content   = htmlspecialchars_decode($printcloud[0]['content']);
        return $this->fetch('file', [
            'banner01'    => $banner01,//banner01
            'banner02'    => $banner02,//banner02
            'banner03'    => $banner03,//banner03
            'banner04'    => $banner04,//banner04
            'banner05'    => $banner05,//banner05
            'cloud' => $printcloud,'cloudcontent' => $cloud_content,
        ]);
    }
    /**
     * 登录验证
     * @return string
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->only(['username', 'password']);
            $validate_result = $this->validate($data, 'Login');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $where['username'] = $data['username'];
                $where['password'] = md5($data['password']);
                $user = Db::name('user')->field('id,username,status')->where($where)->find();

                if (!empty($user)) {
                    if ($user['status'] != 1) {
                        $this->error('当前用户已禁用');
                    } else {
                        Session::set('user_id', $user['id']);
                        Session::set('user_name', $user['username']);
                        Db::name('user')->update(
                            [
                                'last_login_time' => date('Y-m-d H:i:s', time()),
                                'last_login_ip'   => $this->request->ip(),
                                'id'              => $user['id']
                            ]
                        );
                        $this->success('登录成功', 'index/cloud/file');
                    }
                } else {
                    $this->error('用户名或密码错误');
                }
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('user_id');
        Session::delete('user_name');
        $this->success('退出成功', 'admin/login/index');
    }


}
