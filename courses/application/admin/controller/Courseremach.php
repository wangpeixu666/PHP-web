<?php
namespace app\admin\controller;

use app\common\model\Courseremach as UserModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Request;

/**
 * 复赛管理
 * Class Coursenew
 * @package app\admin\controller
 */
class Courseremach extends AdminBase
{

    protected $courseremach_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->courseremach_model = new UserModel();
    }

    /**
     * 复赛管理
     * @return mixed
     */
    public function index(Request $request,$keyword = '')
    {
        $serdata = $request -> param();
        $map = [];//查询
        if(isset($serdata['cstype'])){
            $map['cstype']  = $serdata['cstype'];
            $cstype   =  $serdata['cstype'];
            $this ->assign('cstype',$cstype);
        }
        if(isset($serdata['grade'])){
            $map['grade']   = $serdata['grade'];
            $grade   =  $serdata['grade'];
            $this ->assign('grade',$grade);
        }
        if ($keyword) {
            $map['username|actualname|mobile'] = ['like', "{$keyword}%"];
        }
        //dump($map);die();
        $mapdata    =   array_filter($map);
        if(isset($mapdata['grade'])){
            if($mapdata['grade'] == 4){
                $mapdata['grade'] = 0;
            }
        }
        $courseremach_list = Db::table('os_usercontent')
		    ->alias('a')
		    ->join('os_user w','a.userid = w.id')
		    ->where($mapdata)->where('resubmit', 1)
            ->order('w.id DESC')
            ->paginate(10, false,['query'=>request()->param()]);
        //dump($courseremach_list );die();
        return $this->fetch('index', ['courseremach_list' => $courseremach_list,'keyword' => $keyword]);
    }


    /**
     * 复赛详情
     * @param $id
     * @return mixed
     */
    public function details($id)
    {
		$courseremach_details = Db::table('os_usercontent')
		->query("SELECT os_usercontent.*,os_user.*
		FROM os_usercontent INNER JOIN os_user ON 
		os_user.id=os_usercontent.userid 
		WHERE os_user.id='{$id}'");
		$birthday = $courseremach_details[0]['birthdate'];
		$age = self::birthday($birthday);
		$this->view->assign('age',$age);
        return $this->fetch('details', ['courseremach_details' => $courseremach_details[0]]);
    }


    /**
     * 复赛编辑
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $category = $this->courseremach_model->find($id);
        return $this->fetch('edit', ['courserem' => $courserem]);
    }

	
    /**
     * @复赛评奖
     * @return mixed
     *
     */
    public  function gradepost(Request $request){
        $requestData = $request -> param();
        $arrdata = [
            'id'    => $requestData['uid'],
            'grade' => $requestData['gradebt'],
        ];
        $updateuser = Db::table('os_user')->update($arrdata);
        if($updateuser){
            echo json_encode(array('code' => 2000));
        }else{
            echo json_encode(array('code' => 1000));
        }
    }
	
	
    /**
     * 根据生日进行计算年龄
     * @param $id
     * @return mixed
     */	
	static public function birthday($birthday){ 
	 $age = strtotime($birthday); 
	 if($age === false){ 
	  return false; 
	 } 
	 list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age)); 
	 $now = strtotime("now"); 
	 list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now)); 
	 $age = $y2 - $y1; 
	 if((int)($m2.$d2) < (int)($m1.$d1)) 
	  $age -= 1; 
	 return $age; 
	} 	
	
	
}