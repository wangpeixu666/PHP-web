<?php
namespace app\levy\controller;
//use app\common\model\UploadFiles;  // 上传model
use app\common\model\User as UserModel;
use think\Db;
use think\Controller;
use think\Model;       // 使用Model
use think\File;           // 使用文件上传类
use think\Validate;    // 使用文件上传验证
use think\Request;   // 接值时使用
use think\response\Json;   // 接值时使用


/**
 * @calss accesstoken API
 **/
header("Access-Control-Allow-Origin:*");
// 响应类型
header("Access-Control-Allow-Methods:*");

// 响应头设置
header("Access-Control-Allow-Headers:Authorization,DNT,User-Agent,Keep-Alive,Content-Type,Accept,origin,X-Requested-With");
header("Access-Control-Request-Method: *");
header("Access-Control-Request-Headers: X-Custom-Header");
class Csupload extends Controller
{
    //初始化验证token
    public function _initialize()
    {
        parent::_initialize();
        $requestData = getallheaders();
        $token = $requestData['Accept'];
        $res = self::checkToken($token);
        if($res == 90002){
            $data['status'] = 0;
            $data['code'] = 90002;
            $data['msg'] = 'token验证失败';
            echo  json_encode($data);die();
        }
        if($res == 90003){
            $data['status'] = 0;
            $data['code'] = 90003;
            $data['msg'] = '请重新登陆';
            echo  json_encode($data);die();
        }

    }
	/**
     * 通用图片上传接口II
     * @return \think\response\Json
     */
    public function index()
    {
        $config = [
            'size' => 10240000,
            'ext'  => 'ppt,pdf,doc,docx,pptx,xls,xlsx'//'ext'  => 'jpg,gif,png,bmp'
        ];
        $file = $this->request->file('file');//根据input的name名称获取文件
        //$file = file_get_contents('php://input');//抓取
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/preurl');
        $save_path   = '/public/uploads/preurl/';
        $info        = $file->validate($config)->move($upload_path);

        if ($info) {
            $data['status'] = 1;
            $data['code']   = 2000;
            $data['msg']    = '文件上传成功！';
            $data['data']   = [
                //'url'   => $upload_path.$file['name'],
                'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $data['status'] = 0;
            $data['code'] = 6001;
            $data['msg'] = '文件上传失败，请重新上传！';
        }
        return json($data);
    }
    /**
     * 通用上传接口I
     * @return \think\response\Json
     */
    public function upload()
    {
        $file = $_FILES['file'];//得到传输的数据
        $name = $file['name'];//得到文件名称
        $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
        $allow_type = array('ppt','pptx','pdf','doc','docx','xls','xlsx'); //定义允许上传的类型
        //判断文件类型是否被允许上传
        if(!in_array($type, $allow_type)){
            //如果不被允许，则直接停止程序运行
            return;
        }
        //判断是否是通过HTTP POST上传的
        if(!is_uploaded_file($file['tmp_name'])){
            //如果不是通过HTTP POST上传的
            return;
        }
        $upload_path = "./public/uploads/preurl/"; //初赛上传文件的存放路径
        $sql_path = "/public/uploads/preurl/"; //数据库存放路径
        //开始移动文件到相应的文件夹
        $infodata   = move_uploaded_file($file['tmp_name'],$upload_path.$file['name']);
        //判断是否上传成功并且是返回数据
        if($infodata){
            $data['status'] = 1;
            $data['code']   = 2000;
            $data['msg']    = '文件上传成功！';
            $data['data']   = [
                'url'   => $sql_path.$file['name'],
                //'url'   => str_replace('\\', '/', $upload_path.$file['name'])
            ];

        }else{
            $data['status'] = 0;
            $data['code'] = 6001;
            $data['msg'] = '文件上传失败，请重新上传！';
        }
		return json($data);
    }

    

    /**
     * 上传文件接口III
     * @return \think\response\Json
     *
     */

    public function csupload(){
        // 获取表单上传文件
        $files = Request::instance()->file("file");
        //print_r($files);die();
        foreach($files as $k => $file){
            $conf=array(
                'size'=>500000,
                'ext'=>'ppt,pdf,doc,docx,pptx,xls,xlsx',
            );
            $info = $files->validate($conf)->move(ROOT_PATH . 'public' . DS . 'uploads/remach');
            $save_path   = '/public/uploads/remach/';
            if($info){
                //$saveName = $info->getSaveName();
                $save_url =  str_replace('\\', '/', $save_path .$info->getSaveName());//保存文件的路径
                $data['status'] = 1;
                $data['code']   = 2000;
                $data['msg']    = '文件上传成功！';
                $data['data']   = [
                    'file_url'=>$save_url
                ];
            }else{
                echo $files->getError();
                $data['status'] = 0;
                $data['code'] = 6001;
                $data['msg'] = '文件上传失败，请重新上传！';
            }        
        }
         return json($data);
    }

    /*
     * @function checkToken 令牌验证
     *
     */

    public static function checkToken($token)
    {
        $res = Db::table('os_user')->field('time_out')->where('token', $token)->select();
        if (!empty($res)) {
            if (time() - $res[0]['time_out'] > 0) {
                return 90003; //token长时间未使用而过期，需重新登陆
            }
            $new_time_out = time() + 604800; //604800是七天
            $resnew = Db::table('os_user')
                ->where('token', $token)
                ->update(['time_out' => $new_time_out]);
            if ($resnew) {
                return 90001; //token验证成功，time_out刷新成功，可以获取接口信息
            }
        }
        return 90002; //token错误验证失败
    }



}