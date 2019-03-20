<?php
namespace app\admin\validate;

use think\Validate;

class Printgroup extends Validate
{
    protected $rule = [
        'cid'       => 'require',
        'author'    => 'require|max:16',
        'title'     => 'require',
        'sort'      => 'require|number'
    ];

    protected $message = [
        'cid.require'       => '请选择所属栏目',
        'author.require'    => '请输入作者名称',
        'author.max'        => '作者名称超出限制范围',
        'title.require'     => '请输入标题',
        'title.max'         => '输入的标题超出了限制长度',
        'sort.require'      => '请输入排序',
        'sort.number'       => '排序只能填写数字'
    ];
}