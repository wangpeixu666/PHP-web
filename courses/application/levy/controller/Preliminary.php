<?php
namespace app\levy\controller;

use app\common\controller\LevyApiBase;
use app\common\model\User as UserModel;
use think\Db;
use think\Controller;
use think\Request;
/**
 * @calss 初赛API
**/
header("Access-Control-Allow-Origin:*");
// 响应类型
header("Access-Control-Allow-Methods:*");
header("Access-Control-Allow-Credentials: true");
// 响应头设置
header("Access-Control-Allow-Headers:Authorization,DNT,User-Agent,Keep-Alive,Content-Type,accept,origin,X-Requested-With");
header("Access-Control-Request-Method: *");
header("Access-Control-Request-Headers: X-Custom-Header");
class Preliminary extends Controller
{
    //初始化验证token
    public function _initialize()
    {
        parent::_initialize();
        $requestData = getallheaders();
        $token = $requestData['Accept'];
        $res = self::checkToken($token);
        //print_r($res);die();
  /*      if($res ==90001){
            return true;
        }*/
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
     * @function 初赛报名信息更新（下一步）
     * @ param
     * */
    public function plyupdate(Request $request)
    {
        $applydata = $request -> param();
        $applydata['status'] = 1;
        $result = $this->validate($applydata,'Preliminary');
        if(true !== $result){
            $data['status'] = 0;
            $data['code'] = 1001;
            $data['msg'] = '参数不能为空';
            $data['data'] = '';
            echo  json_encode($data);
        }
        if(isset($applydata['groupname'])){
            $updatedata = array(
                'id'          =>  $applydata['id'],//username的id
                'actualname'  =>  $applydata['actualname'],//username真实姓名
                'sex'         =>  $applydata['sex'],
                'birthdate'   =>  $applydata['birthdate'],
                'mobile'      =>  $applydata['mobile'],//注册时用户手机号码
                'jobtitle'    =>  $applydata['jobtitle'],
                'teachgrade'  =>  $applydata['teachgrade'],
                'school'      =>  $applydata['school'],
                'address'     =>  $applydata['address'],
                'update_time' =>  date('Y-m-d H:i:s',time()),
                'cstype'      =>  $applydata['flag'],//2-团体;1-个人
                'groupname'   => $applydata['groupname'],//团体名称
                'advance_status' =>0,//初赛默认为0-未晋级
            );
        }else{
            $updatedata = array(
                'id'          =>  $applydata['id'],//username的id
                'actualname'  =>  $applydata['actualname'],//username真实姓名
                'sex'         =>  $applydata['sex'],
                'birthdate'   =>  $applydata['birthdate'],
                'mobile'      =>  $applydata['mobile'],//注册时用户手机号码
                'jobtitle'    =>  $applydata['jobtitle'],
                'teachgrade'  =>  $applydata['teachgrade'],
                'school'      =>  $applydata['school'],
                'address'     =>  $applydata['address'],
                'update_time' =>  date('Y-m-d H:i:s',time()),
                'cstype'      =>  $applydata['flag'],//2-团体;1-个人
                'groupname'   => 0,//团体名称
                'advance_status' =>0,//初赛默认为0-未晋级

            );
        }
        if(true == $result){
                //更新一条数据
                $userId = Db::table('os_user')->update($updatedata);
                if ($userId) {
                    $user = Db::table('os_user')
                        ->query("select id,actualname,sex,birthdate,mobile,jobtitle,teachgrade,school,address,cstype,groupname,update_time from os_user where mobile='{$applydata['mobile']}'");
                    if($user[0]['cstype']==1){
                        $cstype = "个人";
                    }else{
                        $cstype = $user[0]['groupname'];
                    }
                    $data['status'] = 1;
                    $data['code'] = 2000;
                    $data['msg'] = '数据已更新成功';
                    $data['data'] = array(
                        'id'            => $user[0]['id'],
                        'actualname'    => $user[0]['actualname'],
                        'sex'           => $user[0]['sex'],
                        'birthdate'     => $user[0]['birthdate'],
                        'mobile'        => $user[0]['mobile'],
                        'jobtitle'      => $user[0]['jobtitle'],
                        'teachgrade'    => $user[0]['teachgrade'],
                        'school'        => $user[0]['school'],
                        'address'       => $user[0]['address'],
                        'cstype'        => $cstype,
                        //'groupname'     => $user[0]['groupname'],
                        'update_time'   => $user[0]['update_time'],
                    );
                }else{
                    $data['status'] = 0;
                    $data['code'] = 3001;
                    $data['msg'] = '数据未更新，请重新填写';
                    $data['data'] = '';
                }

            }
			return json($data);
        //echo  json_encode($data);
    }

    /**
     *
     * @function 初赛报名信息更新（上一步）
     * */
    public function plydetail(Request $request)
    {
        $applydata = $request -> param();
        $user_id = $applydata['id'];//$applydata['id']
            //获取到userid去查询这条信息
        $user = Db::table('os_user')->where('id',$user_id)->find();
        //print_r($user);die();
                $data['status'] = 1;
                $data['code'] = 2000;
                $data['msg'] = '数据再次返回成功';
                $data['data'] = array(
                    'actualname'    => $user[0]['actualname'],
                    'sex'           => $user[0]['sex'],
                    'birthdate'     => $user[0]['birthdate'],
                    'mdbile'        => $user[0]['mobile'],
                    'email'         => $user[0]['email'],
                    'jobtitle'      => $user[0]['jobtitle'],
                    'teachgrade'    => $user[0]['teachgrade'],
                    'school'        => $user[0]['school'],
                    'address'       => $user[0]['address'],
                    'cstype'        => $user[0]['cstype'],
                    'update_time'   => $user[0]['update_time'],
                );
            echo  json_encode($data);
    }
    /**
     *
     * @function 初赛课件提交（初次提交）
     *
     */
    public function apply(Request $request)
    {

        $applydata 		= $request->param();
        $user_id 		=	$applydata['id'];//用户id
        $user = Db::table('os_user')
            ->query("select id,actualname,mobile,school from os_user where id='{$user_id}'");
        $school = $user[0]['school'];
        $actualname = $user[0]['actualname'];
        $mobile = $user[0]['mobile'];
        if($user_id){

            if(isset($applydata['evaluatename']) && !empty($applydata['evaluatename'])){
                $newcsdata = array(
                    'userid'        =>  $user_id,//用户id
                    'csname'        =>  '[初赛课件]'.$school.'-'.$actualname.'-'.substr($mobile,-4),//课件名称
                    'designname'    =>  $applydata['designname'],//教学设计
                    'demoname'      =>  $applydata['demoname'],//演示课件
                    'evaluatename'  =>  $applydata['evaluatename'],//评测练习
                );
            }else{
                $newcsdata = array(
                    'userid'        =>  $user_id,//用户id
                    'csname'        =>  '[初赛课件]'.$school.'-'.$actualname.'-'.substr($mobile,-4),//课件名称
                    'designname'    =>  $applydata['designname'],//教学设计
                    'demoname'      =>  $applydata['demoname'],//演示课件
                        //'evaluatename'  =>  'NULL',//评测练习
                );
            }
                //更新一条数据
            $newone = Db::table('os_usercontent')->where('userid',$user_id)->insertGetId($newcsdata);
                //print_r($userId);die();
            if ($newone) {

                $submitid = array(
                    'id'       =>  $applydata['id'],
                    'submitid' =>1,//初赛更新数据1-初赛已提交
                );
                $userId = Db::table('os_user')->update($submitid);
                if($userId){
                    $user = Db::field("a.*,b.userid,b.csname,b.designname,b.demoname,b.evaluatename")
                        ->table(["os_user"=>"a","os_usercontent"=>"b"])
                        ->where("b.userid=$user_id")//查询条件语句
                        ->find();
                    //print_r($user);die();
                    $data['code'] = 2000;
                    $data['msg'] = '初赛课件提交成功';
                    $data['data'] = array(
                        'userid'        => $user['userid'],//与用户表中的id是相同
                        'actualname'    => $user['actualname'],//用户真实姓名
                        'sex'           => $user['sex'],       //性别
                        'birthdate'     => $user['birthdate'],//生日
                        'mdbile'        => $user['mobile'], //手机
                        'email'         => $user['email'],//邮箱
                        'jobtitle'      => $user['jobtitle'],//教师职称
                        'teachgrade'    => $user['teachgrade'],//年级
                        'school'        => $user['school'],//学校
                        'address'       => $user['address'],//居住地址
                        'cstype'        => $user['cstype'],//课件性质 0-团体 1-个人
                        'csname'        => $user['csname'],//课件名称
                        'designname'    => $user['designname'],//教学设计
                        'demoname'      => $user['demoname'],//演示课件
                        'evaluatename'  => $user['evaluatename'],//评测练习
                        'update_time'   => $user['update_time'],//更新时间
                    );
                }else{
                    $data['status'] = 0;
                    $data['code'] = 4001;
                    $data['msg'] = '初赛课件提交失败，请重新提交';
                    $data['data'] = '';
                }
            }else{
                $data['status'] = 0;
                $data['code'] = 4002;
                $data['msg'] = '提交发生错误，请刷新后重新上传提交';
                $data['data'] = '';
            }

        }else{
            $data['status'] = 0;
            $data['code'] = 4003;
            $data['msg'] = '没有获取到用户ID，请重新登录';
            $data['data'] = '';
        }
		return json($data);
        //echo  json_encode($data);

    }

    
    /**
     * @function 初赛课件信息展示API
     *
     */
    public function newcslist(Request $request)
    {
        //$courses = file_get_contents('php://input');
        $applydata = $request->param();
        $user_id = $applydata['id'];
        $sqldata    = Db::field("a.*,b.userid,b.csname,b.designname,b.demoname,b.evaluatename")
            ->table(["os_user"=>"a","os_usercontent"=>"b"])
            ->where("b.userid=$user_id")//查询条件语句
            ->find();
        if($sqldata){
            $data['code'] = 2000;
            $data['msg'] = '返回用户信息成功';
            $data['data'] = array(
                'userid'        => $sqldata[0]['id'],//与用户表中的id是相同
                'actualname'    => $sqldata[0]['actualname'],//用户真实姓名
                'sex'           => $sqldata[0]['sex'],       //性别
                'birthdate'     => $sqldata[0]['birthdate'],//生日
                'mdbile'        => $sqldata[0]['mobile'], //手机
                'email'         => $sqldata[0]['email'],//邮箱
                'jobtitle'      => $sqldata[0]['jobtitle'],//教师职称
                'teachgrade'    => $sqldata[0]['teachgrade'],//年级
                'school'        => $sqldata[0]['school'],//学校
                'address'       => $sqldata[0]['address'],//居住地址
                'cstype'        => $sqldata[0]['cstype'],//课件性质 0-团体 1-个人
                'csname'        => $sqldata[0]['csname'],//课件名称
                'designname'    => $sqldata[0]['designname'],//教学设计
                'demoname'      => $sqldata[0]['demoname'],//演示课件
                'evaluatename'  => $sqldata[0]['evaluatename'],//评测练习
                'update_time'   => $sqldata[0]['update_time'],//更新时间
            );

        }else{
            $data['status'] = 0;
            $data['code'] = 4001;
            $data['msg'] = '获取信息失败';
            $data['data'] = '';
        }
        echo  json_encode($data);

        //echo "初赛课件信息展示";
    }


    /*
     * @function checkToken 令牌验证
     *
     */

    public static function checkToken($token)
    {
        //$user = Db::table('os_user');
        //print_r($user);die();
        $res = Db::table('os_user')->field('time_out')->where('token', $token)->select();
        //print_r($res);die();
        if (!empty($res)) {
            //dump(time() - $res[0]['time_out']);
            if (time() - $res[0]['time_out'] > 0) {
                return 90003; //token长时间未使用而过期，需重新登陆
            }
            $new_time_out = time() + 604800; //604800是七天
            //$res = Db::table('os_user')->isUpdate(true)->where('token', $token)->update(['time_out' => $new_time_out]);
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
