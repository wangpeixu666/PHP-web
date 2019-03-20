<?php
namespace app\index\validate;

use think\Validate;

/**
 * 前台登录验证
 * Class Login
 * @package app\index\validate
 */
class Login extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
    ];

    protected $message = [
        'username.require' => '请输入用户名',
        'password.require' => '请输入密码',
    ];
}