<?php
namespace app\levy\controller;
//use app\common\controller\LevyApiBase;
use app\common\model\User as UserModel;
use think\Loader;
use think\Session;
use think\Request;
use think\Db;
use think\Controller;

//use app\common\controller\LevyApiBase;


/**
 * @calss 登录注册API
**/
header("Access-Control-Allow-Origin:*");
// 响应类型
header("Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE");
// 响应头设置
header("Access-Control-Allow-Headers:Authorization,DNT,User-Agent,Keep-Alive,Content-Type,accept,origin,X-Requested-With");
header("Access-Control-Request-Method: *");
header("Access-Control-Request-Headers: X-Custom-Header");

class Login extends Controller
{
    //初始化验证token自动登录
    public function index(Request $request)
    {
        $urldata    = $request -> param();
        $tokendata  = $urldata['token'];
        if(!empty($tokendata)){
            $res = self::checkToken($tokendata);//token验证
            if($res == 90001){
                $usernameRes = Db::table('os_user')
                    ->query("select id,status from os_user where token='{$tokendata}'");
				$user_id = $usernameRes[0]['id'];
					 //print_r($user_id);die();
                if ($usernameRes[0]['status'] != 1) {
					//$this->error('当前用户已禁用');
					$data['status'] = 0;
					$data['code'] = 5000;
					$data['msg'] = '当前用户已禁用';
					$data['data'] = '';
                }else{					 
					if($usernameRes){
						$user = Db::table('os_user')
							->query("select id,username,actualname,mobile,school,avatarimg,advance_status,grade,submitid,resubmit from os_user where id='{$user_id}'");
						$school = $user[0]['school'];
						$actualname = $user[0]['actualname'];
						$mobile = $user[0]['mobile'];
						$grade 		= $user[0]['grade'];
                        $submitid 	        = $user[0]['submitid'];
                        $advance_status     = $user[0]['advance_status'];
							if($user){
                                $userdata =Db::field("a.*,b.*")
                                    ->table(["os_user"=>"a","os_usercontent"=>"b"])
                                    ->where("a.id=b.userid")//查询条件语句
                                    ->where("a.id=$user_id")//查询条件语句
                                    ->find();
									if($userdata['cstype']==1){
										$cstype = "个人";
									}else{
										$cstype = $userdata['groupname'];
									}
                                //$csname_name = substr(strrchr($userdata['csname'], ']'), 1);//文件名称
                                if($submitid == 1){
                                    if($advance_status == 1){
                                        if($grade == 0){
                                            $data['status'] = 1;
                                            $data['code']   = 2000;
                                            $data['msg']    = '登录成功';
                                            $data['data']   = array(
                                                'id'                =>$user[0]['id'],
                                                'username'          => $user[0]['username'],
                                                'mdbile'            => $user[0]['mobile'],
                                                'avatarimg'         => $user[0]['avatarimg'],
                                                'advance_status'    => $user[0]['advance_status'],
                                                'submitid'    		=> $user[0]['submitid'],
                                                'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                                'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                                'last_login_time'   => time(),
                                            );
                                            $data['predata'] =array(
                                                'userid'        => $userdata['userid'],//与用户表中的id是相同
                                                'actualname'    => $userdata['actualname'],//用户真实姓名
                                                'sex'           => $userdata['sex'],       //性别
                                                'birthdate'     => $userdata['birthdate'],//生日
                                                'mdbile'        => $userdata['mobile'], //手机
                                                'email'         => $userdata['email'],//邮箱
                                                'jobtitle'      => $userdata['jobtitle'],//教师职称
                                                'teachgrade'    => $userdata['teachgrade'],//年级
                                                'school'        => $userdata['school'],//学校
                                                'address'       => $userdata['address'],//居住地址
                                                'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                                'groupname'     => $userdata['groupname'],//团体名称
                                                'csname'        => $userdata['csname'],//课件名称
                                                'designname'    => $userdata['designname'],//教学设计
                                                'demoname'      => $userdata['demoname'],//演示课件
                                                'evaluatename'  => $userdata['evaluatename'],//评测练习
                                                'update_time'   => $userdata['update_time'],//更新时间

                                            );
                                            $data['repredata'] =array(
                                                'recsname'      => $userdata['recsname'],//复赛名称
                                                'videoURL'      => $userdata['videoURL'],//复赛URL
                                                'vipwd'         => $userdata['vipwd'],//复赛密码
                                            );
                                        }else{
                                            //晋级获奖判断
                                            if($grade == 1){
                                                $grade ='一等奖';
                                            }
                                            if($grade == 2){
                                                $grade ='二等奖';
                                            }
                                            if($grade == 3){
                                                $grade ='三等奖';
                                            }
                                            $data['status'] = 1;
                                            $data['code'] = 2000;
                                            $data['msg'] = '登录成功';
                                            $data['data'] = array(
                                                'id'                =>$user[0]['id'],
                                                'username'          => $user[0]['username'],
                                                'mdbile'            => $user[0]['mobile'],
                                                'avatarimg'         => $user[0]['avatarimg'],
                                                'advance_status'    => $user[0]['advance_status'],
                                                'submitid'    		=> $user[0]['submitid'],
                                                'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                                'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                                'grade'             => '恭喜您，荣获2018赛事'.$grade,
                                                'last_login_time'   => time(),
                                            );
                                            $data['predata'] =array(
                                                'userid'        => $userdata['userid'],//与用户表中的id是相同
                                                'actualname'    => $userdata['actualname'],//用户真实姓名
                                                'sex'           => $userdata['sex'],       //性别
                                                'birthdate'     => $userdata['birthdate'],//生日
                                                'mdbile'        => $userdata['mobile'], //手机
                                                'email'         => $userdata['email'],//邮箱
                                                'jobtitle'      => $userdata['jobtitle'],//教师职称
                                                'teachgrade'    => $userdata['teachgrade'],//年级
                                                'school'        => $userdata['school'],//学校
                                                'address'       => $userdata['address'],//居住地址
                                                'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                                'groupname'     => $userdata['groupname'],//团体名称
                                                'csname'        => $userdata['csname'],//课件名称
                                                'designname'    => $userdata['designname'],//教学设计
                                                'demoname'      => $userdata['demoname'],//演示课件
                                                'evaluatename'  => $userdata['evaluatename'],//评测练习
                                                'update_time'   => $userdata['update_time'],//更新时间

                                            );
                                            //复赛获奖后的信息
                                            $data['repredata']  =array(
                                                'recsname'      => $userdata['recsname'],//复赛名称
                                                'videoURL'      => $userdata['videoURL'],//复赛URL
                                                'vipwd'         => $userdata['vipwd'],//复赛密码
                                            );

                                        }

                                    }else{
                                        $data['status'] = 1;
                                        $data['code']   = 2000;
                                        $data['msg']    = '登录成功';
                                        $data['data']   = array(
                                            'id'                =>$user[0]['id'],
                                            'username'          => $user[0]['username'],
                                            'mdbile'            => $user[0]['mobile'],
                                            'avatarimg'         => $user[0]['avatarimg'],
                                            'advance_status'    => $user[0]['advance_status'],
                                            'submitid'    		=> $user[0]['submitid'],
                                            'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                            'last_login_time'   => time(),
                                        );
                                        $data['predata'] =array(
                                            'userid'        => $userdata['userid'],//与用户表中的id是相同
                                            'actualname'    => $userdata['actualname'],//用户真实姓名
                                            'sex'           => $userdata['sex'],       //性别
                                            'birthdate'     => $userdata['birthdate'],//生日
                                            'mdbile'        => $userdata['mobile'], //手机
                                            'email'         => $userdata['email'],//邮箱
                                            'jobtitle'      => $userdata['jobtitle'],//教师职称
                                            'teachgrade'    => $userdata['teachgrade'],//年级
                                            'school'        => $userdata['school'],//学校
                                            'address'       => $userdata['address'],//居住地址
                                            'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                            'groupname'     => $userdata['groupname'],//团体名称
                                            'csname'        => $userdata['csname'],//课件名称
                                            'designname'    => $userdata['designname'],//教学设计
                                            'demoname'      => $userdata['demoname'],//演示课件
                                            'evaluatename'  => $userdata['evaluatename'],//评测练习
                                            'update_time'   => $userdata['update_time'],//更新时间

                                        );


                                    }

                                }else{

                                    $data['status'] = 1;
                                    $data['code']   = 2000;
                                    $data['msg']    = '登录成功';
                                    $data['data']   = array(
                                        'id'                =>$user[0]['id'],
                                        'username'          => $user[0]['username'],
                                        'mdbile'            => $user[0]['mobile'],
                                        'avatarimg'         => $user[0]['avatarimg'],
                                        'advance_status'    => $user[0]['advance_status'],
                                        'submitid'    		=> $user[0]['submitid'],
                                        'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                        'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                        'last_login_time'   => time(),
                                    );
                                    $data['predata']    =array(
                                        'userid'        => $userdata['userid'],//与用户表中的id是相同
                                        'actualname'    => $userdata['actualname'],//用户真实姓名
                                        'sex'           => $userdata['sex'],       //性别
                                        'birthdate'     => $userdata['birthdate'],//生日
                                        'mdbile'        => $userdata['mobile'], //手机
                                        'email'         => $userdata['email'],//邮箱
                                        'jobtitle'      => $userdata['jobtitle'],//教师职称
                                        'teachgrade'    => $userdata['teachgrade'],//年级
                                        'school'        => $userdata['school'],//学校
                                        'address'       => $userdata['address'],//居住地址
                                        'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                        'groupname'     => $userdata['groupname'],//团体名称
                                        'csname'        => $userdata['csname'],//课件名称
                                        'designname'    => $userdata['designname'],//教学设计
                                        'demoname'      => $userdata['demoname'],//演示课件
                                        'evaluatename'  => $userdata['evaluatename'],//评测练习
                                        'update_time'   => $userdata['update_time'],//更新时间
                                    );
                                    $data['repredata'] =array(
                                        'recsname'      => $userdata['recsname'],//复赛名称
                                        'videoURL'      => $userdata['videoURL'],//复赛URL
                                        'vipwd'         => $userdata['vipwd'],//复赛密码
                                    );

                                }
							}else{
								$data['status'] = 0;
								$data['code'] = 1001;
								$data['msg'] = '登录失败，请您重新登陆';
							}

					}else{
						$data['status'] = 0;
						$data['code'] = 90002;
						$data['msg'] = 'token验证失败';
		
					}
				}
            }else{
                    $data['status'] = 0;
                    $data['code'] = 90003;
                    $data['msg'] = 'token失效，请重新登陆';

                }

        }else{
            $data['status'] = 0;
            $data['code'] = 1001;
            $data['msg'] = 'token不存在，请重新登陆';
            $data['data'] = '';
        }
        return json($data);
		//echo  json_encode($data);

    }
    /**
     * @function 登录API
     * @param [string][username][password][accesstoken]
     * */
    public function login(Request $request)
    {

        $urldata = $request -> param();
        if (!empty($urldata)) {
            //进行验证会员用户的账号和密码
            if ($urldata['username'] && $urldata['password']) {
                $username = $urldata['username'];
                $password = md5($urldata['password']);
				//$where['username'] = $urldata['username'];
                //$where['password'] = md5($urldata['password']);
                $usernameRes =  Db::table('os_user')
				->field('id,status')
				->where('username',$username)
				->where('password',$password)
				->find();
               if (!empty($usernameRes)) {
                    if ($usernameRes['status'] != 1) {
                        //$this->error('当前用户已禁用');
						$data['status'] = 0;
						$data['code'] = 5000;
						$data['msg'] = '当前用户已禁用';
						$data['data'] = '';
                    }else{
					$user = Db::table('os_user')
                        ->query("select id,username,actualname,mobile,school,avatarimg,advance_status,grade,submitid,resubmit from os_user where username='{$username}'");
					$user_id            = $user[0]['id'];//用户id
                    $school             = $user[0]['school'];
                    $actualname         = $user[0]['actualname'];
                    $mobile             = $user[0]['mobile'];
					$grade 		        = $user[0]['grade'];
					$submitid 	        = $user[0]['submitid'];
					//$resubmit           = $user[0]['resubmit'];
					$advance_status     = $user[0]['advance_status'];

                    if ($user) {
                        //生成token存数据库
                        $token = self::makeToken();
                        //print_r($token);die();
                        $time_out = strtotime("+7 days");
//                        $time_out = time()+7200;
                        $UserModel = new UserModel();
                        $userinfo = [
                            'time_out' => $time_out,
                            'token' => $token,
                            'last_login_time'=>date('Y-m-d H:i:s',time()),
                        ];
                        $res = $UserModel -> isUpdate(true)
                            ->where('id', $user[0]['id'])
                            ->update($userinfo);             
                        //存成功返回
                        if($res){
                            $userdata =Db::field("a.*,b.*")
                                ->table(["os_user"=>"a","os_usercontent"=>"b"])
                                ->where("a.id=b.userid")//查询条件语句
                                ->where("a.id=$user_id")//查询条件语句
                                ->find();
								if($userdata['cstype']==1){
										$cstype = "个人";
									}else{
										$cstype = $userdata['groupname'];
									}

                            //$csname_name = substr(strrchr($userdata['csname'], ']'), 1);//文件名称
                            //dump($userdata);die();
                                if($submitid == 1){
                                    if($advance_status == 1){
                                        if($grade == 0){
                                            $data['status'] = 1;
                                            $data['code']   = 2000;
                                            $data['msg']    = '登录成功';
                                            $data['data']   = array(
                                                'id'                =>$user[0]['id'],
                                                'username'          => $user[0]['username'],
                                                'mdbile'            => $user[0]['mobile'],
                                                'token'             => $token,
                                                'avatarimg'         => $user[0]['avatarimg'],
                                                'advance_status'    => $user[0]['advance_status'],
                                                'submitid'    		=> $user[0]['submitid'],
                                                'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                                'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                                'last_login_time'   => time(),
                                            );

                                            $data['predata'] =array(
                                                'userid'        => $userdata['userid'],//与用户表中的id是相同
                                                'actualname'    => $userdata['actualname'],//用户真实姓名
                                                'sex'           => $userdata['sex'],       //性别
                                                'birthdate'     => $userdata['birthdate'],//生日
                                                'mdbile'        => $userdata['mobile'], //手机
                                                'email'         => $userdata['email'],//邮箱
                                                'jobtitle'      => $userdata['jobtitle'],//教师职称
                                                'teachgrade'    => $userdata['teachgrade'],//年级
                                                'school'        => $userdata['school'],//学校
                                                'address'       => $userdata['address'],//居住地址
                                                'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                                'groupname'     => $userdata['groupname'],//团体名称
                                                'csname'        => $userdata['csname'],//课件名称
                                                'designname'    => $userdata['designname'],//教学设计
                                                'demoname'      => $userdata['demoname'],//演示课件
                                                'evaluatename'  => $userdata['evaluatename'],//评测练习
                                                'update_time'   => $userdata['update_time'],//更新时间

                                            );
                                            $data['repredata'] =array(
                                                'recsname'      => $userdata['recsname'],//复赛名称
                                                'videoURL'      => $userdata['videoURL'],//复赛URL
                                                'vipwd'         => $userdata['vipwd'],//复赛密码
                                            );
                                        }else{
                                            //晋级获奖判断
                                            if($grade == 1){
                                                $grade ='一等奖';
                                            }
                                            if($grade == 2){
                                                $grade ='二等奖';
                                            }
                                            if($grade == 3){
                                                $grade ='三等奖';
                                            }
                                            $data['status'] = 1;
                                            $data['code'] = 2000;
                                            $data['msg'] = '登录成功';
                                            $data['data'] = array(
                                                'id'                =>$user[0]['id'],
                                                'username'          => $user[0]['username'],
                                                'mdbile'            => $user[0]['mobile'],
                                                'token'             => $token,
                                                'avatarimg'         => $user[0]['avatarimg'],
                                                'advance_status'    => $user[0]['advance_status'],
                                                'submitid'    		=> $user[0]['submitid'],
                                                'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                                'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                                'grade'             => '恭喜您，荣获2018赛事'.$grade,
                                                'last_login_time'   => time(),
                                            );

                                                $data['predata'] =array(
                                                    'userid'        => $userdata['userid'],//与用户表中的id是相同
                                                    'actualname'    => $userdata['actualname'],//用户真实姓名
                                                    'sex'           => $userdata['sex'],       //性别
                                                    'birthdate'     => $userdata['birthdate'],//生日
                                                    'mdbile'        => $userdata['mobile'], //手机
                                                    'email'         => $userdata['email'],//邮箱
                                                    'jobtitle'      => $userdata['jobtitle'],//教师职称
                                                    'teachgrade'    => $userdata['teachgrade'],//年级
                                                    'school'        => $userdata['school'],//学校
                                                    'address'       => $userdata['address'],//居住地址
                                                    'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                                    'groupname'     => $userdata['groupname'],//团体名称
                                                    'csname'        => $userdata['csname'],//课件名称
                                                    'designname'    => $userdata['designname'],//教学设计
                                                    'demoname'      => $userdata['demoname'],//演示课件
                                                    'evaluatename'  => $userdata['evaluatename'],//评测练习
                                                    'update_time'   => $userdata['update_time'],//更新时间

                                                );

                                            //获奖后的信息
                                            $data['repredata'] =array(
                                                'recsname'      => $userdata['recsname'],//复赛名称
                                                'videoURL'      => $userdata['videoURL'],//复赛URL
                                                'vipwd'         => $userdata['vipwd'],//复赛密码
                                            );

                                        }

                                    }else{
                                        //$csname_name = substr(strrchr($userdata['csname'], ']'), 1);//文件名称
                                        $data['status'] = 1;
                                        $data['code']   = 2000;
                                        $data['msg']    = '登录成功';
                                        $data['data']   = array(
                                            'id'                =>$user[0]['id'],
                                            'username'          => $user[0]['username'],
                                            'mdbile'            => $user[0]['mobile'],
                                            'token'             => $token,
                                            'avatarimg'         => $user[0]['avatarimg'],
                                            'advance_status'    => $user[0]['advance_status'],
                                            'submitid'    		=> $user[0]['submitid'],
                                            'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                            'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                            'last_login_time'   => time(),
                                        );
                                        $data['predata'] =array(
                                            'userid'        => $userdata['userid'],//与用户表中的id是相同
                                            'actualname'    => $userdata['actualname'],//用户真实姓名
                                            'sex'           => $userdata['sex'],       //性别
                                            'birthdate'     => $userdata['birthdate'],//生日
                                            'mdbile'        => $userdata['mobile'], //手机
                                            'email'         => $userdata['email'],//邮箱
                                            'jobtitle'      => $userdata['jobtitle'],//教师职称
                                            'teachgrade'    => $userdata['teachgrade'],//年级
                                            'school'        => $userdata['school'],//学校
                                            'address'       => $userdata['address'],//居住地址
                                            'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                            'groupname'     => $userdata['groupname'],//团体名称
                                            'csname'        => $userdata['csname'],//课件名称
                                            'designname'    => $userdata['designname'],//教学设计
                                            'demoname'      => $userdata['demoname'],//演示课件
                                            'evaluatename'  => $userdata['evaluatename'],//评测练习
                                            'update_time'   => $userdata['update_time'],//更新时间

                                        );

                                    }

                                }else{

                                    $data['status'] = 1;
                                    $data['code']   = 2000;
                                    $data['msg']    = '登录成功';
                                    $data['data']   = array(
                                        'id'                =>$user[0]['id'],
                                        'username'          => $user[0]['username'],
                                        'mdbile'            => $user[0]['mobile'],
                                        'token'             => $token,
                                        'avatarimg'         => $user[0]['avatarimg'],
                                        'advance_status'    => $user[0]['advance_status'],
                                        'submitid'    		=> $user[0]['submitid'],
                                        'resubmit'    		=> $user[0]['resubmit'],//复赛提交状态
                                        'recsname'          => '[复赛视频]'.$school.'-'.$actualname.'-'.substr($mobile,-4),
                                        'last_login_time'   => time(),
                                    );
                                    $data['predata']    =array(
                                        'userid'        => $userdata['userid'],//与用户表中的id是相同
                                        'actualname'    => $userdata['actualname'],//用户真实姓名
                                        'sex'           => $userdata['sex'],       //性别
                                        'birthdate'     => $userdata['birthdate'],//生日
                                        'mdbile'        => $userdata['mobile'], //手机
                                        'email'         => $userdata['email'],//邮箱
                                        'jobtitle'      => $userdata['jobtitle'],//教师职称
                                        'teachgrade'    => $userdata['teachgrade'],//年级
                                        'school'        => $userdata['school'],//学校
                                        'address'       => $userdata['address'],//居住地址
                                        'cstype'        => $cstype,//课件性质 2-团体;1-个人
                                        'groupname'     => $userdata['groupname'],//团体名称
                                        'csname'        => $userdata['csname'],//课件名称
                                        'designname'    => $userdata['designname'],//教学设计
                                        'demoname'      => $userdata['demoname'],//演示课件
                                        'evaluatename'  => $userdata['evaluatename'],//评测练习
                                        'update_time'   => $userdata['update_time'],//更新时间
                                    );
                                    $data['repredata'] =array(
                                        'recsname'      => $userdata['recsname'],//复赛名称
                                        'videoURL'      => $userdata['videoURL'],//复赛URL
                                        'vipwd'         => $userdata['vipwd'],//复赛密码
                                    );

                                }

							}else{
								$data['status'] = 0;
								$data['code'] = 1005;
								$data['msg'] = '登录失败';
							}

						} else {
							$data['status'] = 0;
							$data['code'] = 1004;
							$data['msg'] = '此用户存在异常，请注册或重新填写';
						}
					}			
                } else {
                    $data['status'] = 0;
                    $data['code'] = 1003;
                    $data['msg'] = '用户名或者密码不正确，请注册或重新填写';
                    $data['data'] = '';
                }
            } else {
                $data['status'] = 0;
                $data['code'] = 1002;
                $data['msg'] = '参数不符合要求';
                $data['data'] = '';
            }
        } else {
            $data['status'] = 0;
            $data['code'] = 1001;
            $data['msg'] = '用户名或者密码不能为空';
            $data['data'] = '';
        }
        return json($data);
        //echo  json_encode($data);
    }

    /**
     * @function 注册API
     * @param [string][username][password][accesstoken]
     * */
    public function signin(Request $request)
    {
        //接收前端表单提交的数据
        $urldata = $request -> param();
		if(!empty($urldata['username'])){
			if(!empty($urldata['email'])){
				if(!empty($urldata['mobile'])){
				    if(!empty($urldata['msgcode'])){
                        //$session = Session::get('msgCode');
                        //$session = $request->session('msgCode');
                        //$session = Db::table("os_session")
                        //->query("select msgcode from os_session where mobile='".$urldata['mobile']."'");
                        //print_r($session);
				        if(1==1){//$session[0]['msgcode'] == $urldata['msgcode']
                            $usersRes = Db::table('os_user')->query("select username from os_user where username='".$urldata['username']."'");
                            $mobileRes = Db::table('os_user')->query("select mobile from os_user where mobile='".$urldata['mobile']."'");
                            $emailRes = Db::table('os_user')->query("select email from os_user where email='".$urldata['email']."'");
                            //判断用户信息是否存在
                            if(!$usersRes){
                                if(!$mobileRes){
                                    if(!$emailRes){
                                        $userdata = array(
                                            'username'		 => $urldata['username'],
                                            'password'		 => md5($urldata['password']),
                                            'email'   		 => $urldata['email'],
                                            'mobile'  		 => $urldata['mobile'],//手机
                                            //'vercode' 	 => $urldata['vercode'],//短信验证码
                                            'advance_status' => 0,//晋级状态默认为0
                                            'status'  	=> 1,
                                            'create_time'	=> date('Y-m-d H:i:s',time()),
                                        );
                                        //插入一条数据数据并且获取到userid
                                        $userId = Db::table('os_user')->insertGetId($userdata);
                                        if ($userId) {
                                            $user = Db::table('os_user')
                                                ->query("select id,username,email,mobile,create_time from os_user where id='$userId'");
                                            $data['status'] = 1;
                                            $data['code'] = 2000;
                                            $data['msg'] = '注册成功';
                                            $data['data'] = array(
                                                'id' 			=> $userId,
                                                'username' 		=> $user[0]['username'],
                                                'email' 		=> $user[0]['email'],
                                                'mdbile' 		=> $user[0]['mobile'],
                                                //'vercode' => $user[0]['vercode'],
                                                'create_time' 	=> $user[0]['create_time'],
                                            );
                                        }else{
                                            $data['status'] = 0;
                                            $data['code'] = 3004;
                                            $data['msg'] = '注册失败，请重新注册';
                                            $data['data'] = '';
                                        }

                                    }else{
                                        $data['status'] = 0;
                                        $data['code'] = 3003;
                                        $data['msg'] = '邮箱已存在';
                                        $data['data'] = '';
                                    }
                                }else{
                                    $data['status'] = 0;
                                    $data['code'] = 3002;
                                    $data['msg'] = '手机号已存在';
                                    $data['data'] = '';
                                }
                            }else{
                                $data['status'] = 0;
                                $data['code'] = 3001;
                                $data['msg'] = '此用户名已存在';
                                $data['data'] = '';

                            }
                        }else{
                            $data['status'] = 0;
                            $data['code'] = 3009;
                            $data['msg'] = '手机验证码错误，请重新获取';
                            $data['data'] = '';
                        }
                    }else{

                        $data['status'] = 0;
                        $data['code'] = 3008;
                        $data['msg'] = '手机验证码不能为空';
                        $data['data'] = '';
                    }

				}else{
				$data['status'] = 0;
				$data['code'] = 3005;
				$data['msg'] = '所填手机号码不能为空';
				$data['data'] = '';
				}
			}else{
				$data['status'] = 0;
				$data['code'] = 3006;
				$data['msg'] = '所填邮箱不能为空';
				$data['data'] = '';			
			}			
		}else{
				$data['status'] = 0;
				$data['code'] = 3007;
				$data['msg'] = '所填用户名不能为空';
				$data['data'] = '';			
		}
        
        return json($data);
        //echo  json_encode($data);
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
            $resnew = Db::table('os_user')
                ->where('token', $token)
                ->update(['time_out' => $new_time_out]);
            if ($resnew) {
                return 90001; //token验证成功，time_out刷新成功，可以获取接口信息
            }
        }

        return 90002; //token错误验证失败
    }


/*  @创建函数: makeToekn()
*   @创建 token
 *
 */
    public static function makeToken()
    {

        $str = md5(uniqid(md5(microtime(true)), true)); //生成一个不会重复的字符串
        $str = sha1($str); //加密
        return $str;
    }







}