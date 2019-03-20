<?php
namespace app\common\model;

use think\Model;

header("Access-Control-Allow-Origin: *");
// 响应类型
header('Access-Control-Allow-Methods:*');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class LevyapiUser extends Model
{
    protected $insert = ['create_time'];

    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return date('Y-m-d H:i:s');
    }
    public function selectAppKy($appid){
        if(!empty($appid)){
            $sql = "select app_key from os_levyapi_user where app_id='$appid'";
            $appkey = $this->query($sql);
            return $appkey[0]['app_key'];
        }else{
            return false;
        }
    }
    public function selectAccessTken($appid){
        if(!empty($appid)){
            $sql = "select token from os_levyapi_user where app_id='$appid'";
            $appkey = $this->query($sql);
            return $appkey[0]['token'];
        }else{
            return false;
        }
    }
}