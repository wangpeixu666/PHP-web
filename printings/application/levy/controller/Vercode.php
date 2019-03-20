<?php
namespace app\levy\controller;
use think\Controller;
use think\Loader;
use think\Session;
use think\Request;
use think\Db;


header("Access-Control-Allow-Origin:*");
// 响应类型
header("Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE");
// 响应头设置
header("Access-Control-Allow-Headers:Authorization,DNT,User-Agent,Keep-Alive,Content-Type,accept,origin,X-Requested-With");
header("Access-Control-Request-Method: *");
header("Access-Control-Request-Headers: X-Custom-Header");
class Vercode extends Controller
{
    /**
     * @param $to 短信接收号码
     */
    public function index(Request $request)
    {
        $todata = $request->param();
        $mobile = $todata['mobile'];
        $randStr = $todata['randStr'];
        if(!empty($todata['mobile'])){
            $mobileRes = Db::table('os_session')->query("select mobile from os_session where mobile='".$mobile."'");
            if(!$mobileRes){
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
                    $result = $rest->sendTemplateSMS($mobile,$datas,$tempId);
                    if($result->statusCode == 000000 ){
                        //存进session里面，给一个过期时间（60s）
                        Session::set('msgcode',$datas);
                        //$getsession = Session::get('msgcode');
                        $getsession = $request->session('msgcode');
                        $userdata = array(
                            'mobile'=>$mobile,
                            'msgcode'=>$getsession,
                        );
                        $usersession = Db::table('os_session')->insertGetId($userdata);
                        if($usersession){
                            return json(array('code' => 2000,'status' => 1,'msg' => '验证码发送成功','data' => array()));
                        }
                    }else{
                        return json(array('code' => 4001,'status' => 0,'msg' => '验证码发送失败','data' => array()));
                    }

                }else{
                    return json(array('code' => 4002,'status' => 0,'msg' => '请求错误','data' => array()));
                }

            }else{
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
                    $result = $rest->sendTemplateSMS($mobile,$datas,$tempId);
                    if($result->statusCode == 000000 ){
                        //存进session里面，给一个过期时间（60s）
                        Session::set('msgcode',$datas);
                        $getsession = Session::get('msgcode');
                        //$getsession = $request->session('msgcode');
                        $userdata = array(
                            'mobile'=>$mobile,
                            'msgcode'=>$getsession,
                        );

                        $usersession = Db::table('os_session')
                            ->where('mobile',$mobile)
                            ->update($userdata);
                        if($usersession){
                            return json(array('code' => 2000,'status' => 1,'msg' => '验证码发送成功','data' => array()));
                        }
                    }else{
                        return json(array('code' => 4001,'status' => 0,'msg' => '验证码发送失败','data' => array()));
                    }

                }else{
                    return json(array('code' => 4002,'status' => 0,'msg' => '请求错误','data' => array()));
                }
            }
        }else{
            $data['status'] = 0;
            $data['code'] = 4003;
            $data['msg'] = '所填手机号码不能为空';
            $data['data'] = '';

        }



    }
}