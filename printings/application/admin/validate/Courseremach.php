<?php
namespace app\admin\validate;

use think\Validate;

class Courseremach extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'username' => 'require',
        'advance_status' => 'require'
    ];

    protected $message = [
        'id.require'  => 'ID不能为空',
        'username.require' => '请输入用户姓名',
        'advance_status.require' => '课件状态描述0-未晋级;1-晋级',
    ];
}