<?php
namespace app\levy\validate;

use think\Validate;

class Preliminary extends Validate
{
    protected $rule = [
        'actualname'         => 'require|max:20',
        'mobile'           => 'number|length:11',
        'email'            => 'email',
        'status'           => 'require',
    ];

    protected $message = [
        'actualname.max'             =>  '姓名不能超过20个字符',
        'actualname.require'         => '请输入姓名',
        'mobile.number'            => '手机号格式错误',
        'mobile.length'            => '手机号长度错误',
        'email.email'              => '邮箱格式错误',
        'status.require'           => '请选择状态'
    ];
}







