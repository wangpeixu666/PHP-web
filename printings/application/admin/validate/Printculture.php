<?php
namespace app\admin\validate;

use think\Validate;

class Printculture extends Validate
{
    protected $rule = [
        'cid'   => 'require',
        'title' => 'require|max:100',
        'introduction' => 'require',
        'sort'  => 'require|number'
    ];

    protected $message = [
        'cid.require'   => '请选择所属栏目',
        'title.require' => '请输入标题',
        'title.max' => '输入的标题超出了限制长度',
        'introduction.require' => '请输入简介',
        'sort.require'  => '请输入排序',
        'sort.number'   => '排序只能填写数字'
    ];
}