<?php
namespace app\levy\validate;
  
use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'         => 'require',
        'password'         => 'confirm:confirm_password',
        'confirm_password' => 'confirm:password',
        'mobile'           => 'number|length:11|unique:user',
        'email'            => 'email|unique:user',
        'status'           => 'require'
    ];

    protected $message = [
        'username.require'         => '请输入用户名',
        'username.unique'          => '用户名已存在',
        'password.confirm'         => '两次输入密码不一致',
        'confirm_password.confirm' => '两次输入密码不一致',
        'mobile.number'            => '手机号格式错误',
        'mobile.length'            => '手机号长度错误',
        'mobile.unique'            => '手机号码已经存在',
        'email.email'              => '邮箱格式错误',
        'email.unique'              => '邮箱已经存在',
        'status.require'           => '请选择状态',
    ];
}







