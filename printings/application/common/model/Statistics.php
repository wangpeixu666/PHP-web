<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Statistics extends Model
{
    protected $insert = ['create_time'];

    protected static function init()
    {
        parent::init();

    }
}