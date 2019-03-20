<?php
namespace app\admin\validate;

use think\Validate;

class Statistics extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'username' => 'require',
        'state' => 'require'
    ];

    protected $message = [
        'id.require'  => 'ID不能为空',
        'username.require' => '请输入用户姓名',
        'state.require' => '课件状态描述0-未晋级;1-晋级',
    ];
}