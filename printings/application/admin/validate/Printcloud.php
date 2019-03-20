<?php
namespace app\admin\validate;

use think\Validate;

class Printcloud extends Validate
{
    protected $rule = [
        'username'      => 'require|max:80',
        'title' => 'require|max:100',
    ];

    protected $message = [
        'username.require'      => '请输入名称',
        'username.max'          => '输入名称超出了限制长度',
        'title.require' => '请输入标题',
        'title.max' => '输入的标题超出了限制长度',
    ];
}