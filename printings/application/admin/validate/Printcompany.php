<?php
namespace app\admin\validate;

use think\Validate;

class Printcompany extends Validate
{
    protected $rule = [
        'name'      => 'require|max:80',
        'address'   => 'require',
        'email'     => 'email',
        //'phone'     => 'number',
        'introduction' => 'require',
        'content'   => 'require',
    ];

    protected $message = [
        'name.require'      => '请输入名称',
        'name.max'          => '输入名称超出了限制长度',
        'introduction.require' => '请输入简介',
        'address.require'   => '请输入地址',
        'email.require'     => '邮箱格式错误',
        //'phone.number'      => '手机号格式错误',
        'content.require'   => '请输入简介内容',
    ];
}