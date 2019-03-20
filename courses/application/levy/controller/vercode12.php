<?php
namespace app\levy\controller;
use think\Controller;
use think\Loader;
use think\Session;
use think\Request;
use think\Db;

class Vercode extends Controller
{
    /**
     * @param $to 短信接收号码
     */
    public function index(Request $request)
    {
        $todata = $request->param();
        $to = $todata['mobile'];
        $randStr = $todata['randStr'];
        //判断长度
        if(strlen($randStr) == 9){
            // 初始化REST SDK
            $smsConfig = config('vercode');
            $serverIP = $smsConfig['serverIP'];
            $serverPort = $smsConfig['serverPort'];
            $softVersion = $smsConfig['softVersion'];
            $accountSid = $smsConfig['accountSid'];
            $accountToken = $smsConfig['accountToken'];
            $appId = $smsConfig['appId'];
            $tempId = $smsConfig['tempId'];
            Loader::import('mobile_api.REST',EXTEND_PATH);//对应extend目录，路径，
            $rest = new \REST($serverIP,$serverPort,$softVersion);
            $rest->setAccount($accountSid,$accountToken);
            $rest->setAppId($appId);
//            // 发送模板短信
            $datas = rand(100000,999999);
            $result = $rest->sendTemplateSMS($to,$datas,$tempId);
            if($result->statusCode == 000000 ){
                //存进session里面，给一个过期时间（60s）
                Session::set('msgCode',$datas);
                $a = Session::get('msgCode');
                print_r($a);die();
                echo json_encode(array('code' => 2000,'status' => 1,'msg' => '验证码发送成功','data' => array()));
            }else{
                echo json_encode(array('code' => 4001,'status' => 0,'msg' => '验证码发送失败','data' => array()));
            }

        }else{
            echo json_encode(array('code' => 4002,'status' => 0,'msg' => '请求错误','data' => array()));
        }
        //$to = $_REQUEST['tel'];

    }
    //生成所发送的验证码并返回
    public function random()
    {
        $length = 6;
        $char = '0123456789';
        $code = '';
        while(strlen($code) < $length){
            //截取字符串长度
            $code .= substr($char,(mt_rand()%strlen($char)),1);
        }
        return $code;
    }
}