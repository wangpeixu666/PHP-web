<?php
namespace app\levy\controller;
use app\common\controller\LevyApiBase;
use think\Db;
use think\Controller;
use think\Request;

/**
 * @calss accesstoken API
**/

class Accesstoken extends Controller
{
    //初始化
    public function _initialize()
    {
        $requestData = input('post.');
        //校验数据
        $tokenRes = LevyApiBase::getAccessToken($requestData);
        if($tokenRes['code'] != 2000){
            echo json_encode($tokenRes);
            exit();
        }else{
            echo json_encode($tokenRes);
        }
    }
    public function index(){

    }
}
