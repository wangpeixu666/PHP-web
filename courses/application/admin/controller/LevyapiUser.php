<?php
namespace app\admin\controller;

use app\common\model\LevyapiUser as LevyapiUserModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;

/**
 * 用户管理
 * Class AdminUser
 * @package app\admin\controller
 */
header("Access-Control-Allow-Origin: *");
// 响应类型
header('Access-Control-Allow-Methods:*');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class LevyapiUser extends AdminBase
{
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new LevyapiUserModel();
    }

    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
        $map = [];
        if ($keyword) {
            $map['user_name|token|app_key|app_id|email'] = ['like', "%{$keyword}%"];
        }
        $user_list = $this->user_model->where($map)->order('id DESC')->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['user_list' => $user_list, 'keyword' => $keyword]);
    }

    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存用户
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //设置accesstoken 30位
            $data['token'] = getRandomString(30);
            //设置appid 25位
            $data['app_id'] = getRandomString(25);
            //设置APPkey 40位
            $data['app_key'] = getRandomString(40);
            $validate_result = $this->validate($data, 'LevyapiUser');
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data['user_pwd'] = md5($data['user_pwd'] . Config::get('salt'));
                if ($this->user_model->allowField(true)->save($data)) {
                    //定时去更新token
                    $success = self::timingEditAccessToken($data['app_id'],$data['app_key']);
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }

        }
    }
    /**
     * @function 修改token
     **/
    public static function timingEditAccessToken($appid,$appky){
        if($appid && $appky){
            ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
            set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
            $interval = 259200;// 每隔半小时运行
            do{
                //执行修改
                self::timingEdit($appid,$appky);
                //定时任务终止
                $run = include ROOT_PATH.'process_abort/process_abort.php';
                if(!$run) die('process abort');
                sleep($interval);
            }
            while(true);
        }
    }

    /**
     * @function 修改token
    **/
    public static function timingEdit($appid,$appky){
        if($appid && $appky){
            $accessToken = getRandomString(30);
            $editSql = "UPDATE os_levyapi_user SET token = '$accessToken' WHERE app_id = '$appid' AND app_key='$appky'";
            Db::execute($editSql);
        }
    }

    /**
     * 编辑用户
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->user_model->find($id);

        return $this->fetch('edit', ['user' => $user]);
    }

    /**
     * 更新用户
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $user           = $this->user_model->find($id);
                $user->id       = $id;
                $user->username = $data['username'];
                $user->mobile   = $data['mobile'];
                $user->email    = $data['email'];
                $user->status   = $data['status'];
                if (!empty($data['password']) && !empty($data['confirm_password'])) {
                    $user->password = md5($data['password'] . Config::get('salt'));
                }
                if ($user->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除用户
     * @param $id
     */
    public function delete($id)
    {
        if ($this->user_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}