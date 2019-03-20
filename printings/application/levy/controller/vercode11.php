<?php
namespace app\levy\controller;
use think\Controller;
use think\Loader;
use think\Session;
use think\Request;

class Vercode extends Controller
{
    public function index(Request $request)
    {
        $urldata    = $request -> param();
        if(isset($urldata['mobile'])){
            //提交request()->isPost()
            $mobile = $urldata['mobile'];//可以用input助手函获取输入数据
            Loader::import('alimsg.api_demo.SmsDemo',EXTEND_PATH);//对应extend目录，路径，
            $code = $this->random();
            //得到信息文件并执行.实例化阿里短信类
            $msg = new \SmsDemo('23273820','a018b756a6b6b95f8091b98cd4ed6ebb');//此处是Access key id和Access key secret
            //此配置在sdk包中有相关例子
            $res = $msg->sendSms(
                "漫像",//短信签名名称
                "SMS_139243109",//短信模板code
                "$mobile",//短信接收者的手机号码$mobile
                //模板信息
                Array(
                    'code' => $code,//随机变化的
                    //'mobile' => $mobile,//随机变化的
                )
            );
            //dump($res);die;
            $response = array($res);
            $data['status'] = 1;
            $data['code'] 	= 2000;
            $data['msg'] 	= '短信发送成功';
            $data['data'] 	= [
                'code'	=>	$response[0]['code'],
                //'mobile'	=>	$response[1]['mobile'],
            ];

        }else{
            $data['status'] = 0;
            $data['code'] 	= 7001;
            $data['msg'] 	= '手机号码不能为空';
            $data['data'] 	= '';
        }
        return json($data);
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

    /**
     * @param $to 短信接收号码
     */
    function getMobileVerifyCode()
    {
        $to = $_REQUEST['tel'];
        console($_REQUEST);
        // 初始化REST SDK
        $smsConfig = config('sms');
        extract($smsConfig);

        import('helper.CCPRestSmsSDK');
        $rest = new REST($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        import("helper.seccode");
        $seccode = new seccode();

        $seccode->_phone_string();

        $_SESSION['time']=date("Y-m-d H:i:s");

        console($_SESSION);
        $re = array();
        if(empty($_SESSION['phone_seccode']))
        {
            $re = array(
                'flag'=>0,
                'msg'=>'验证码生成失败'
            );
            exit($this->json->encode($re));
        }

        $datas = array($_SESSION['phone_seccode'],15);
        // 发送模板短信
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        console($result);
        $result = json_decode(json_encode($result),true);
        console($result);
        if(empty($result)) {
            $result = array(
                'flag'=>0,
                'msg'=>'短信发送失败'
            );
        }
        if($result['statusCode']!=0) {
            $re = array(
                'flag'=>0,
                'msg'=>$result['statusMsg']
            );
        }else{
            $re = array(
                'flag'=>1,
                'msg'=>'短信发送成功'
            );
        }
        console($this->json->encode($re));
        exit($this->json->encode($re));
    }

}