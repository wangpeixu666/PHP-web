<?php
namespace app\common\controller;
use think\Controller;
use think\Request;
use app\common\model\LevyapiUser as LevyapiUser;

/**
 * @class 前端接口校验
 */
class LevyApiBase extends Controller
{

    /**
     * @function 解密
     * @param [json] $data
    **/
    public static function encryptData($data){
        if($data){
            //获取header
            $getHeaderData = self::getHeaderData();
            //获取X-Yobee-Signature
            $xyobeeSignature = $getHeaderData['X-Yobee-Signature'];

            if($xyobeeSignature){
                //进行base64_decode解密
                $base64DecodeData = base64_decode($xyobeeSignature);
                //截取appid
                $appid = substr($base64DecodeData,'-48','-23');
                //查询数据库取出appkey
                $levyapiUser = new LevyapiUser();
                $appkey = $levyapiUser -> selectAppKy($appid);
                //取出accesstken
                $access = $levyapiUser -> selectAccessTken($appid);
                //取出客户端传过来的APPkey
                $clientAppkey = substr($base64DecodeData,13,'13');
                //截取accesstoken
                $clientAccesstoken = substr($base64DecodeData,'-13');
                //处理并比较是否对应
                    //加密
                if($appkey){
                    $serverAppkey = strtolower(crypt(strtolower(sha1($appkey)),$appid));
                    if($access){
                        $serverAccessToken = strtolower(crypt(md5(md5($access)),$appid));
                        if($serverAppkey === $clientAppkey){
                            if($serverAccessToken === $clientAccesstoken){
                                    $retunData['code'] = 2000;//匹配成功
                                    $retunData['msg'] = '匹配成功';//匹配成功
                            }else{
                                $retunData['code'] = 6005;//accesstoken不匹配
                                $retunData['msg'] = 'accesstoken不匹配';
                            }
                        }else{
                            $retunData['code'] = 6004;//appkey不匹配
                            $retunData['msg'] = 'appkey不匹配';
                        }
                    }else{
                        $retunData['code'] = 6002;//accesstoken错误
                        $retunData['msg'] = 'accesstoken错误';
                    }
                }else{
                    $retunData['code'] = 6001;//appkey错误
                    $retunData['msg'] = 'appkey错误';
                }

            }else{
                $retunData['code'] = 2001;//签名串为空
                $retunData['msg'] = '签名串为空';
            }
        }else{
            $retunData['code'] = 2002;//数据为空
            $retunData['msg'] = '数据为空';
        }
        return $retunData;
    }
    /**
     * @function 获取accesstoken
    **/
    public static function getAccessToken($data){
        if($data){
            //获取header
            $getHeaderData = self::getHeaderData();
            //获取X-Yobee-Signature
            $xyobeeSignature = $getHeaderData['X-Yobee-Signature'];

            if($xyobeeSignature){
                //进行base64_decode解密
                $base64DecodeData = base64_decode($xyobeeSignature);
                //截取appid
                $appid = substr($base64DecodeData,'-35','-10');
                //查询数据库取出appkey
                $levyapiUser = new LevyapiUser();
                $appkey = $levyapiUser -> selectAppKy($appid);
                //取出客户端传过来的APPkey
                $clientAppkey = substr($base64DecodeData,13,'13');
                //截取accesstoken
                //处理并比较是否对应
                //加密
                if($appkey){
                    $serverAppkey = strtolower(crypt(strtolower(sha1($appkey)),$appid));
                        if($serverAppkey === $clientAppkey){
                            $retunData['code'] = 2000;//请求成功
                            $retunData['msg'] = '请求成功';
                            //$retunData['error'] = '';
                            $retunData['timestamp'] = time();
                            $retunData['data']['access_token'] = $levyapiUser -> selectAccessTken($appid);//发送access_token
                        }else{
                            $retunData['code'] = 6004;//appkey不匹配
                            $retunData['msg'] = 'appkey不匹配';
                        }

                }else{
                    $retunData['code'] = 6001;//appkey错误
                    $retunData['msg'] = 'appkey错误';
                }

            }else{
                $retunData['code'] = 2001;//签名串为空
                $retunData['msg'] = '签名串为空';
            }
        }else{
            $retunData['code'] = 2002;//数据为空
            $retunData['msg'] = '数据为空';
        }
        return $retunData;
    }
    /**
     * @function 获取header
    **/
    public static function getHeaderData(){
        if (!function_exists('getallheaders')) {
                $headers = [];
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
        }

    }
}