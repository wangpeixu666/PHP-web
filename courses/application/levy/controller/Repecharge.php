<?php
namespace app\levy\controller;
use think\Db;
use think\Session;
use think\Controller;
use think\Request;
use app\common\controller\LevyApiBase;
/**
 * @calss 复赛API  
**/
header("Access-Control-Allow-Origin:*");
// 响应类型
header("Access-Control-Allow-Methods:*");
header("Access-Control-Allow-Credentials: true");
// 响应头设置
header("Access-Control-Allow-Headers:Authorization,DNT,User-Agent,Keep-Alive,Content-Type,accept,origin,X-Requested-With");
header("Access-Control-Request-Method: *");
header("Access-Control-Request-Headers: X-Custom-Header");
class Repecharge extends Controller
{
    //初始化验证token
    public function _initialize()
    {
        parent::_initialize();
        $requestData = getallheaders();
        $tokendata = $requestData['Accept'];
        $res = self::checkToken($tokendata);

        if ($res == 90002) {
            $data['status'] = 0;
            $data['code'] = 90002;
            $data['msg'] = 'token验证失败';
            echo json_encode($data);
            die();
        }
        if ($res == 90003) {
            $data['status'] = 0;
            $data['code'] = 90003;
            $data['msg'] = '请重新登陆';
            echo json_encode($data);
            die();
        }

    }

    /**
     * @function 复赛用户课件提交
     *
     */
    public function recourse(Request $request)
    {
        //$courses = file_get_contents('php://input');
        $applydata = $request->param();
        $user_id = $applydata['id'];//获取用户id
        $usermach = Db::table('os_user')
            ->query("select id,actualname,mobile,school from os_user where id='{$user_id}'");
        $school = $usermach[0]['school'];
        $actualname = $usermach[0]['actualname'];
        $mobile = $usermach[0]['mobile'];
        if (!empty($applydata['videoURL'])) {
            $resubmitid = [
                'resubmit' => 1,
            ];
            $userRes = Db::table('os_user')->where('id', $user_id)->update($resubmitid);
            if ($userRes) {
                $recsdata = array(
                    'userid' => $user_id,
                    'recsname' => '[复赛视频]' . $school . '-' . $actualname . '-' . substr($mobile, -4),//复赛课件名称
                    'videoURL' => $applydata['videoURL'],//复赛课件视频地址
                    'vipwd' => $applydata['vipwd'],//复赛课件视频地址
                );
                //$courseRes = Db::table('os_usercontent')->update($recsdata);
                $courseRes = Db::table('os_usercontent')->where('userid', $user_id)->update($recsdata);
                if ($courseRes) {
                    $user = Db::table('os_usercontent')->where('userid', $user_id)->find();
                    //print_r($user);die();
                    $data['status'] = 1;
                    $data['code'] = 2000;
                    $data['msg'] = '复赛提交成功';
                    $data['data'] = array(
                        'userid' => $user['userid'],//用户id
                        'recsname' => $user['recsname'],
                        'videoURL' => $user['videoURL'],
                        'vipwd' => $user['vipwd'],
                        'resubmit' => 1,
                    );
                } else {
                    $data['status'] = 0;
                    $data['code'] = 1004;
                    $data['msg'] = '复赛提交失败，请重新提交！';

                }
            }

        } else {
            $data['status'] = 0;
            $data['code'] = 1006;
            $data['msg'] = '复赛视频地址不能为空！';

        }
        return json($data);
        //echo  json_encode($data);
    }

    /**
     * @function 复赛作品展示
     **/
    public function courselist(Request $request)
    {
        $applydata = $request->param();
        $user_id = $applydata['id'];//用户id//$applydata['id']
        $sqldata = Db::table('os_usercontent')
            ->query("select userid,recsname,videoURL,vipwd from os_usercontent where userid='{$user_id}'");
        if ($sqldata) {
            $data['code'] = 2000;
            $data['msg'] = '返回用户信息成功';
            $data['data'] = array(
                'userid' => $sqldata[0]['userid'],//与用户表中的id是相同
                'recsname' => $sqldata[0]['recsname'],//复赛课件名称
                'videoURL' => $sqldata[0]['videoURL'],//视频地址
                'vipwd' => $sqldata[0]['vipwd'],//视频地址
            );
        } else {
            $data['status'] = 0;
            $data['code'] = 4001;
            $data['msg'] = '获取信息失败';
            $data['data'] = '';
        }
        return json($data);
        //return json($data);
    }


    /*
     * @function checkToken 令牌验证
     *
     */

    public static function checkToken($token)
    {
        $res = Db::table('os_user')->field('time_out')->where('token', $token)->select();
        //print_r($res);die();
        if (!empty($res)) {
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

    public function userlist(Request $request)
    {
        $urldata = $request->param();
        $user_id = $urldata['userid'];
        $user = Db::table('os_user')
            ->query("select id,username,actualname,mobile,school,avatarimg,advance_status,grade,submitid,resubmit from os_user where id='{$user_id}'");
        $user_id = $user[0]['id'];//用户id
        $school = $user[0]['school'];
        $actualname = $user[0]['actualname'];
        $mobile = $user[0]['mobile'];
        $grade = $user[0]['grade'];
        $submitid = $user[0]['submitid'];
        //$resubmit           = $user[0]['resubmit'];
        $advance_status = $user[0]['advance_status'];


            if ($user) {
                $userdata = Db::field("a.*,b.*")
                    ->table(["os_user" => "a", "os_usercontent" => "b"])
                    ->where("a.id=b.userid")//查询条件语句
                    ->where("a.id=$user_id")//查询条件语句
                    ->find();
                if ($userdata['cstype'] == 1) {
                    $cstype = "个人";
                } else {
                    $cstype = $userdata['groupname'];
                }

                $csname_name = substr(strrchr($userdata['csname'], ']'), 1);//文件名称
                if ($submitid == 1) {
                    if ($advance_status == 1) {
                        if ($grade == 0) {
                            $data['status'] = 1;
                            $data['code'] = 2000;
                            $data['msg'] = '获取成功';
                            $data['data'] = array(
                                'id' => $user[0]['id'],
                                'username' => $user[0]['username'],
                                'mdbile' => $user[0]['mobile'],
                                'avatarimg' => $user[0]['avatarimg'],
                                'advance_status' => $user[0]['advance_status'],
                                'submitid' => $user[0]['submitid'],
                                'resubmit' => $user[0]['resubmit'],//复赛提交状态
                                'recsname' => '[复赛视频]' . $school . '-' . $actualname . '-' . substr($mobile, -4),
                                'last_login_time' => time(),
                            );

                            if (isset($userdata['evaluatename'])) {
                                $data['predata'] = array(
                                    'userid' => $userdata['userid'],//与用户表中的id是相同
                                    'actualname' => $userdata['actualname'],//用户真实姓名
                                    'sex' => $userdata['sex'],       //性别
                                    'birthdate' => $userdata['birthdate'],//生日
                                    'mdbile' => $userdata['mobile'], //手机
                                    'email' => $userdata['email'],//邮箱
                                    'jobtitle' => $userdata['jobtitle'],//教师职称
                                    'teachgrade' => $userdata['teachgrade'],//年级
                                    'school' => $userdata['school'],//学校
                                    'address' => $userdata['address'],//居住地址
                                    'cstype' => $cstype,//课件性质 2-团体;1-个人
                                    'groupname' => $userdata['groupname'],//团体名称
                                    'csname' => $userdata['csname'],//课件名称
                                    'designname' => '[教学设计]' . str_replace(strstr(basename($userdata['designname']), '.', TRUE), $csname_name, basename($userdata['designname'])),//教学设计
                                    'demoname' => '[演示课件]' . str_replace(strstr(basename($userdata['demoname']), '.', TRUE), $csname_name, basename($userdata['demoname'])),//演示课件
                                    'evaluatename' => '[评测练习]' . str_replace(strstr(basename($userdata['evaluatename']), '.', TRUE), $csname_name, basename($userdata['evaluatename'])),//评测练习
                                    'update_time' => $userdata['update_time'],//更新时间

                                );
                            } else {
                                $data['predata'] = array(
                                    'userid' => $userdata['userid'],//与用户表中的id是相同
                                    'actualname' => $userdata['actualname'],//用户真实姓名
                                    'sex' => $userdata['sex'],       //性别
                                    'birthdate' => $userdata['birthdate'],//生日
                                    'mdbile' => $userdata['mobile'], //手机
                                    'email' => $userdata['email'],//邮箱
                                    'jobtitle' => $userdata['jobtitle'],//教师职称
                                    'teachgrade' => $userdata['teachgrade'],//年级
                                    'school' => $userdata['school'],//学校
                                    'address' => $userdata['address'],//居住地址
                                    'cstype' => $cstype,//课件性质 2-团体;1-个人
                                    'groupname' => $userdata['groupname'],//团体名称
                                    'csname' => $userdata['csname'],//课件名称
                                    'designname' => $userdata['designname'],//教学设计
                                    'designname' => '[教学设计]' . str_replace(strstr(basename($userdata['designname']), '.', TRUE), $csname_name, basename($userdata['designname'])),//教学设计
                                    'demoname' => '[演示课件]' . str_replace(strstr(basename($userdata['demoname']), '.', TRUE), $csname_name, basename($userdata['demoname'])),//演示课件
                                    'update_time' => $userdata['update_time'],//更新时间

                                );

                            }
                            $data['repredata'] = array(
                                'recsname' => $userdata['recsname'],//复赛名称
                                'videoURL' => $userdata['videoURL'],//复赛URL
                                'vipwd' => $userdata['vipwd'],//复赛密码
                            );
                        } else {
                            //晋级获奖判断
                            if ($grade == 1) {
                                $grade = '一等奖';
                            }
                            if ($grade == 2) {
                                $grade = '二等奖';
                            }
                            if ($grade == 3) {
                                $grade = '三等奖';
                            }
                            $data['status'] = 1;
                            $data['code'] = 2000;
                            $data['msg'] = '登录成功';
                            $data['data'] = array(
                                'id' => $user[0]['id'],
                                'username' => $user[0]['username'],
                                'mdbile' => $user[0]['mobile'],
                                'avatarimg' => $user[0]['avatarimg'],
                                'advance_status' => $user[0]['advance_status'],
                                'submitid' => $user[0]['submitid'],
                                'resubmit' => $user[0]['resubmit'],//复赛提交状态
                                'recsname' => '[复赛视频]' . $school . '-' . $actualname . '-' . substr($mobile, -4),
                                'grade' => '恭喜您，荣获2018赛事' . $grade,
                                'last_login_time' => time(),
                            );
                            if (isset($userdata['evaluatename'])) {
                                $data['predata'] = array(
                                    'userid' => $userdata['userid'],//与用户表中的id是相同
                                    'actualname' => $userdata['actualname'],//用户真实姓名
                                    'sex' => $userdata['sex'],       //性别
                                    'birthdate' => $userdata['birthdate'],//生日
                                    'mdbile' => $userdata['mobile'], //手机
                                    'email' => $userdata['email'],//邮箱
                                    'jobtitle' => $userdata['jobtitle'],//教师职称
                                    'teachgrade' => $userdata['teachgrade'],//年级
                                    'school' => $userdata['school'],//学校
                                    'address' => $userdata['address'],//居住地址
                                    'cstype' => $cstype,//课件性质 2-团体;1-个人
                                    'groupname' => $userdata['groupname'],//团体名称
                                    'csname' => $userdata['csname'],//课件名称
                                    'designname' => '[教学设计]' . str_replace(strstr(basename($userdata['designname']), '.', TRUE), $csname_name, basename($userdata['designname'])),//教学设计
                                    'demoname' => '[演示课件]' . str_replace(strstr(basename($userdata['demoname']), '.', TRUE), $csname_name, basename($userdata['demoname'])),//演示课件
                                    'evaluatename' => '[评测练习]' . str_replace(strstr(basename($userdata['evaluatename']), '.', TRUE), $csname_name, basename($userdata['evaluatename'])),//评测练习
                                    'update_time' => $userdata['update_time'],//更新时间

                                );
                            } else {
                                $data['predata'] = array(
                                    'userid' => $userdata['userid'],//与用户表中的id是相同
                                    'actualname' => $userdata['actualname'],//用户真实姓名
                                    'sex' => $userdata['sex'],       //性别
                                    'birthdate' => $userdata['birthdate'],//生日
                                    'mdbile' => $userdata['mobile'], //手机
                                    'email' => $userdata['email'],//邮箱
                                    'jobtitle' => $userdata['jobtitle'],//教师职称
                                    'teachgrade' => $userdata['teachgrade'],//年级
                                    'school' => $userdata['school'],//学校
                                    'address' => $userdata['address'],//居住地址
                                    'cstype' => $cstype,//课件性质 2-团体;1-个人
                                    'groupname' => $userdata['groupname'],//团体名称
                                    'csname' => $userdata['csname'],//课件名称
                                    'designname' => $userdata['designname'],//教学设计
                                    'designname' => '[教学设计]' . str_replace(strstr(basename($userdata['designname']), '.', TRUE), $csname_name, basename($userdata['designname'])),//教学设计
                                    'demoname' => '[演示课件]' . str_replace(strstr(basename($userdata['demoname']), '.', TRUE), $csname_name, basename($userdata['demoname'])),//演示课件
                                    'update_time' => $userdata['update_time'],//更新时间

                                );

                            }
                            //获奖后的信息
                            $data['repredata'] = array(
                                'recsname' => $userdata['recsname'],//复赛名称
                                'videoURL' => $userdata['videoURL'],//复赛URL
                                'vipwd' => $userdata['vipwd'],//复赛密码
                            );

                        }

                    } else {
                        //$csname_name = substr(strrchr($userdata['csname'], ']'), 1);//文件名称
                        $data['status'] = 1;
                        $data['code'] = 2000;
                        $data['msg'] = '登录成功';
                        $data['data'] = array(
                            'id' => $user[0]['id'],
                            'username' => $user[0]['username'],
                            'mdbile' => $user[0]['mobile'],
                            'avatarimg' => $user[0]['avatarimg'],
                            'advance_status' => $user[0]['advance_status'],
                            'submitid' => $user[0]['submitid'],
                            'resubmit' => $user[0]['resubmit'],//复赛提交状态
                            'recsname' => '[复赛视频]' . $school . '-' . $actualname . '-' . substr($mobile, -4),
                            'last_login_time' => time(),
                        );
                        if (isset($userdata['evaluatename'])) {
                            $data['predata'] = array(
                                'userid' => $userdata['userid'],//与用户表中的id是相同
                                'actualname' => $userdata['actualname'],//用户真实姓名
                                'sex' => $userdata['sex'],       //性别
                                'birthdate' => $userdata['birthdate'],//生日
                                'mdbile' => $userdata['mobile'], //手机
                                'email' => $userdata['email'],//邮箱
                                'jobtitle' => $userdata['jobtitle'],//教师职称
                                'teachgrade' => $userdata['teachgrade'],//年级
                                'school' => $userdata['school'],//学校
                                'address' => $userdata['address'],//居住地址
                                'cstype' => $cstype,//课件性质 2-团体;1-个人
                                'groupname' => $userdata['groupname'],//团体名称
                                'csname' => $userdata['csname'],//课件名称
                                'designname' => '[教学设计]' . str_replace(strstr(basename($userdata['designname']), '.', TRUE), $csname_name, basename($userdata['designname'])),//教学设计
                                'demoname' => '[演示课件]' . str_replace(strstr(basename($userdata['demoname']), '.', TRUE), $csname_name, basename($userdata['demoname'])),//演示课件
                                'evaluatename' => '[评测练习]' . str_replace(strstr(basename($userdata['evaluatename']), '.', TRUE), $csname_name, basename($userdata['evaluatename'])),//评测练习
                                'update_time' => $userdata['update_time'],//更新时间

                            );
                        } else {
                            $data['predata'] = array(
                                'userid' => $userdata['userid'],//与用户表中的id是相同
                                'actualname' => $userdata['actualname'],//用户真实姓名
                                'sex' => $userdata['sex'],       //性别
                                'birthdate' => $userdata['birthdate'],//生日
                                'mdbile' => $userdata['mobile'], //手机
                                'email' => $userdata['email'],//邮箱
                                'jobtitle' => $userdata['jobtitle'],//教师职称
                                'teachgrade' => $userdata['teachgrade'],//年级
                                'school' => $userdata['school'],//学校
                                'address' => $userdata['address'],//居住地址
                                'cstype' => $cstype,//课件性质 2-团体;1-个人
                                'groupname' => $userdata['groupname'],//团体名称
                                'csname' => $userdata['csname'],//课件名称
                                'designname' => $userdata['designname'],//教学设计
                                'designname' => '[教学设计]' . str_replace(strstr(basename($userdata['designname']), '.', TRUE), $csname_name, basename($userdata['designname'])),//教学设计
                                'demoname' => '[演示课件]' . str_replace(strstr(basename($userdata['demoname']), '.', TRUE), $csname_name, basename($userdata['demoname'])),//演示课件
                                'update_time' => $userdata['update_time'],//更新时间

                            );

                        }

                    }

                } else {

                    $data['status'] = 1;
                    $data['code'] = 2000;
                    $data['msg'] = '登录成功';
                    $data['data'] = array(
                        'id' => $user[0]['id'],
                        'username' => $user[0]['username'],
                        'mdbile' => $user[0]['mobile'],
                        'avatarimg' => $user[0]['avatarimg'],
                        'advance_status' => $user[0]['advance_status'],
                        'submitid' => $user[0]['submitid'],
                        'resubmit' => $user[0]['resubmit'],//复赛提交状态
                        'recsname' => '[复赛视频]' . $school . '-' . $actualname . '-' . substr($mobile, -4),
                        'last_login_time' => time(),
                    );
                    $data['predata'] = array(
                        'userid' => $userdata['userid'],//与用户表中的id是相同
                        'actualname' => $userdata['actualname'],//用户真实姓名
                        'sex' => $userdata['sex'],       //性别
                        'birthdate' => $userdata['birthdate'],//生日
                        'mdbile' => $userdata['mobile'], //手机
                        'email' => $userdata['email'],//邮箱
                        'jobtitle' => $userdata['jobtitle'],//教师职称
                        'teachgrade' => $userdata['teachgrade'],//年级
                        'school' => $userdata['school'],//学校
                        'address' => $userdata['address'],//居住地址
                        'cstype' => $cstype,//课件性质 2-团体;1-个人
                        'groupname' => $userdata['groupname'],//团体名称
                        'csname' => $userdata['csname'],//课件名称
                        'designname' => $userdata['designname'],//教学设计
                        'demoname' => $userdata['demoname'],//演示课件
                        'evaluatename' => $userdata['evaluatename'],//评测练习
                        'update_time' => $userdata['update_time'],//更新时间
                    );
                    $data['repredata'] = array(
                        'recsname' => $userdata['recsname'],//复赛名称
                        'videoURL' => $userdata['videoURL'],//复赛URL
                        'vipwd' => $userdata['vipwd'],//复赛密码
                    );

                }

            } else {
                $data['status'] = 0;
                $data['code'] = 1005;
                $data['msg'] = '获取失败';
            }

        return json($data);
    }



}
