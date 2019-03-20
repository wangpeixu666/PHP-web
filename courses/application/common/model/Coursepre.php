<?php
namespace app\common\model;

use app\common\model\User as UserModel;
use think\Db;
use think\Model;

class Coursepre extends Model
{
    protected $insert = ['create_time'];

    protected static function init()
    {
        parent::init();

    }
}