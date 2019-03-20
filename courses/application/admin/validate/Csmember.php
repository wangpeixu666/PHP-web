<?php
namespace app\admin\validate;

use think\Validate;

class Coursenew extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'username' => 'require',
        'status' => 'require'
    ];

    protected $message = [
        'id.require'  => 'ID不能为空',
        'username.require' => '请输入用户姓名',
        'status.require' => '课件状态描述0-未晋级;1-晋级',
    ];
}