<?php
namespace app\admin\validate;

use think\Validate;

class LevyapiUser extends Validate
{
    protected $rule = [
        'user_name'       => 'require|unique:levyapi_user',
        'user_pwd'        => 'require|confirm:confirm_user_pwd',
        'confirm_user_pwd' => 'confirm:user_pwd',
        'app_key'         => 'length:40',
        'create_time'     => 'length:20',
        'app_id'          => 'length:25',
        'access_token'    => 'length:30',
        'status'          => 'require',
    ];

    protected $message = [
        'user_name.require'         => '请输入用户名',
        'user_name.unique'          => '用户名已存在',
        'confirm_user_pwd.confirm'  => '两次输入密码不一致',
        'user_pwd.require'          => '请输入密码',
        'app_key.length'            => 'app_key长度错误',
        'app_id.length'            => 'app_id长度错误',
        'access_token.length'            => 'access_token长度错误',
        'status.require'           => '请选择状态'
    ];
}