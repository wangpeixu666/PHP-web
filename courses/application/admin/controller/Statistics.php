<?php
namespace app\admin\controller;

use app\common\model\User as UserModel;;
use app\common\controller\AdminBase;
use think\Db;
use think\Request;

/**
 * 统计分析
 * Class Statistics
 * @package app\admin\controller
 */
class Statistics extends AdminBase
{

    protected $statistics_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->statistics_model = new UserModel();
    }

    /**
     * 统计分析
     * @return mixed
     */
    public function index(Request $request)
    {
        $serdata = $request -> param();
        $mapone = [];//查询1
        //按时间区间进行查询
        if(isset($serdata['onetime'])){
            $onetime   =  $serdata['onetime'];
            $this ->assign('onetime',$onetime);
        }
        if(isset($serdata['twotime'])){
            $twotime   =  $serdata['twotime'];
            $this ->assign('twotime',$twotime);
        }
        //按固定时间段进行查询
        if (isset($serdata['createday'])) {
            $createday  = $serdata['createday'];
            if($createday == 24){
                $mapone['create_time'] = array('egt',date('Y-m-d H:i:s', strtotime('-1 day')));//24小时
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
            }
            if($createday == '3d'){
                $mapone['create_time'] = array('egt',date('Y-m-d H:i:s', strtotime('-3 day')));//三天
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
            }
            if($createday == '7d'){
                $mapone['create_time'] = array('egt',date('Y-m-d H:i:s', strtotime('-7 day')));//七天
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
            }
            if($createday == '30d'){
                $mapone['create_time'] = array('egt',date('Y-m-d H:i:s', strtotime('-1 month')));//一个月
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
            }
            if($createday == '90d'){
                $mapone['create_time'] = array('egt',date('Y-m-d H:i:s', strtotime('-3 month')));//三个月
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
            }
            if($createday == '180d'){
                $mapone['create_time'] = array('egt',date('Y-m-d H:i:s', strtotime('-6 month')));//半年
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
                //dump(date("Y-m-d H:i:s", strtotime("-6 month")));die();
            }
            if($createday == 'timeall'){
                $mapone['create_time'] = array('gt','1970-00-00 00:00:00');//全部
                $createday   =  $serdata['createday'];
                $this ->assign('createday',$createday);
                if(isset($serdata['onetime']) && isset($serdata['twotime'])){
                    $mapone['create_time'] = array('between',[$onetime,$twotime]);
                }


            }

        }

        $mapdata    =   array_filter($mapone);//过滤空字符NULL和0值
        /*$sql = "SELECT COUNT(id),COUNT(submitid),DATE_FORMAT(doc.create_time, '%Y-%m-%d') AS t FROM os_user doc WHERE DATE_FORMAT(doc.create_time, '%Y') >= '1970' GROUP BY t ORDER BY NULL";
        $sqldata = Db::table('os_user')->where($mapdata)->query($sql);
        dump($sqldata);die();*/
        //进行数据统计
//        $a = 1;//提交了课件(参赛)
//        $b = 0;//刚注册了(还未提交课件)
        $statistics_list    = Db::table("os_user doc")
            ->field("COUNT(id),COUNT(submitid),DATE_FORMAT(doc.create_time,'%Y-%m-%d') AS t")
            ->where($mapdata)
            ->where("DATE_FORMAT(doc.create_time, '%Y')",'>=','1970')
            ->group("DATE_FORMAT(doc.create_time,'%Y-%m-%d')")
            ->order("id DESC")
            ->paginate(5, false,['query'=>request()->param()]);
		return $this->fetch('index', ['statistics_list' => $statistics_list]);

    }

    /**
     * 统计分析详情
     * @param $id
     * @return mixed
     */
    public function details()
    {
        //$statistics = $this->statistics_model->find($id);
        //print_r($statistics_list);die();

        return $this->fetch('details');
    }
    /**
     * 数据统计
     * @param $id
     * @return mixed
     */
    public function statistics($id)
    {
        $statistics_list = $this->statistics_model->find($id);
        /*$registcount    = Db::table('os_user')
                    ->field('id,create_time ,COUNT(id) as id')
                    ->where($mapdata)
                    ->where('status','=',1)
                    ->select();//注册的总人数
                $newregist      = Db::table('os_user')
                    ->field('id,create_time,COUNT(id) as id')
                    ->where($mapdata)
                    //->where('submitid','=',1)
                    ->where('submitid','=',0)
                    ->where('advance_status','=',0)
                    ->select();//新增注册人数
                $allenter       = Db::table('os_user')
                    ->field('id,create_time,COUNT(id) as id')
                    ->where($mapdata)
                    ->where('submitid','=',1)
                    ->select();//参赛总人数
                $newaddenter    = Db::table('os_user')
                    ->field('id,create_time,COUNT(id) as id')
                    ->where($mapdata)
                    ->where('submitid','=',1)
                    ->where('advance_status','=',0)
                    ->select();//新增参赛人数

                //->query("select count('id') from os_user where status = 1");//注册的总人数
                //dump($registcount);die();
                $this->assign('newregist',$newregist[0]['id']);//新增注册总人数
                $this->assign('allenter',$allenter[0]['id']);//参赛总人数
                $this->assign('newaddenter',$newaddenter[0]['id']);//新增参赛人数
                $this->assign('allcount',$registcount[0]['id']);//注册总人数*/
        /*        $newregist      = Db::table('os_user')
                    ->query("select count('id') from os_user where status = 1 and submitid = 0");//新增注册人数
                $allenter       = Db::table('os_user')
                    ->query("select count('id') from os_user where status = 1 and submitid = 1");//参赛总人数
                $newaddenter    = Db::table('os_user')
                    ->query("select count('id') from os_user where submitid = 1 and resubmit=0");//新增参赛人数
                $registcount    = Db::table('os_user')
                    ->query("select count('id') from os_user where status = 1");//注册的总人数
                $this->assign('newregist',$newregist[0]["count('id')"]);//新增注册总人数
                $this->assign('allenter',$allenter[0]["count('id')"]);//参赛总人数
                $this->assign('newaddenter',$newaddenter[0]["count('id')"]);//新增参赛人数
                $this->assign('allcount',$registcount[0]["count('id')"]);//注册总人数*/
        return $this->fetch('edit', ['statistics_edit' => $statistics_list]);
    }

}