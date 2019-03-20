<?php
namespace app\admin\controller;

use app\common\model\Coursepre as UserModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Request;

/**
 * 复赛管理
 * Class Csmember
 * @package app\admin\controller
 */
class Coursepre extends AdminBase
{

    protected $coursepre_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->coursepre_model = new UserModel();
    }

    /**
     * 初赛管理
     * @return mixed
     */
    public function index(Request $request,$keyword = '')
    {
        $serdata = $request -> param();
        $map = [];//查询
        if(isset($serdata['cstype'])){//类型
            $map['cstype']              = $serdata['cstype'];
            $cstype   =  $serdata['cstype'];
            $this ->assign('cstype',$cstype);
        }
        if(isset($serdata['advance_status'])){//晋级状态
            $map['advance_status']       = $serdata['advance_status'];
            $advance_status   =  $serdata['advance_status'];
            $this ->assign('advance_status',$advance_status);
        }

        if ($keyword) {
            $map['username|actualname|mobile'] = ['like', "{$keyword}%"];
        }
        $mapdata    =   array_filter($map);
        if(isset($mapdata['advance_status'])){
            if($mapdata['advance_status'] == 2){
                $mapdata['advance_status'] = 0;
            }
        }
        //dump($map);die();
        $coursenew_list = Db::table('os_user')
            ->where($mapdata)
            ->where('submitid',1)
            ->order('id DESC')
            ->paginate(10, false,['query'=>request()->param()]);
        return $this->fetch('index', ['coursepre_list' => $coursenew_list,'keyword' => $keyword]);

    }

    /**
     * 初赛详情
     * @param $id
     * @return mixed
     */
    public function details($id)
    {
        //$coursenew = Db::table('os_user')->find($id);
        $coursenew = Db::field("a.*,b.userid,b.csname,b.designname,b.demoname,b.evaluatename")
            ->table(["os_user"=>"a","os_usercontent"=>"b"])
            ->where("a.id=b.userid")//查询条件语句
            ->where("a.id=$id")//查询条件语句
            ->find();
        $designname     = $coursenew['school'].'-'.$coursenew['actualname'].'-'.substr($coursenew['mobile'],-4).'.'.substr(strrchr($coursenew['designname'], '.'), 1);
        //dump($designname);die();
        $demoname       = $coursenew['school'].'-'.$coursenew['actualname'].'-'.substr($coursenew['mobile'],-4).'.'.substr(strrchr($coursenew['demoname'], '.'), 1);
        $evaluatename   = $coursenew['school'].'-'.$coursenew['actualname'].'-'.substr($coursenew['mobile'],-4).'.'.substr(strrchr($coursenew['evaluatename'], '.'), 1);
        //获取文件大小
        //$bytes = filesize('/home/www/courses'.$coursenew['designname']);
        //$kilobytes = round($bytes/1024,2);
        $designsize     =filesize('/home/www/courses'.$coursenew['designname']);//获取大小
        $designbig      =self::ReadFilesize($designsize);//单位转化
        $demosize       =filesize('/home/www/courses'.$coursenew['demoname']);//获取大小
        $demonbig       =self::ReadFilesize($demosize);//单位转化
        $evaluatesize   =filesize('/home/www/courses'.$coursenew['evaluatename']);//获取大小
        $evaluatenbig   =self::ReadFilesize($evaluatesize);//单位转化
        //$designbig      =self::ReadFilesize($coursenew['designname']);
        //$demonbig       =self::ReadFilesize($coursenew['demoname']);
        //$evaluatenbig   =self::ReadFilesize($coursenew['evaluatename']);
        //dump($evaluatenbig);die();
		$birthday = $coursenew['birthdate'];
		$age = self::birthday($birthday);
		$this->view->assign('age',$age);
		$this->view->assign('designname',$designname);
		$this->view->assign('demoname',$demoname);
		$this->view->assign('evaluatename',$evaluatename);
		$this->view->assign('designbig',$designbig);
		$this->view->assign('demonbig',$demonbig);
		$this->view->assign('evaluatenbig',$evaluatenbig);
        return $this->fetch('details', ['coursepre_details' => $coursenew]);
    }
    /**
     * 初赛晋级
     * @param $id
     * @return mixed
     */
    public function advanced($id)
    {
        $coursedata = Db::table('os_user')->find($id);
        $advance_status = $coursedata['advance_status'];
        if($advance_status == 0){
            $userdata = array(
                'id'                =>$id,
                'advance_status'    =>1
            );
            $updateuser = Db::table('os_user')->update($userdata);
            if ($updateuser) {
                $this->success('晋级成功');
            } else {
                $this->error('晋级失败');
            }

        }
        return $this->fetch('index');
    }
    /**
     * 初赛批量晋级
     * @param $id
     * @return mixed
     */
    public function alladvanced(Request $request){
        $requestData = $request -> param();
        $arrdata = [
            'id'    => $requestData['ids'],
        ];
        $is_success = 0;
        foreach ($arrdata['id'] as $val){
                //$arr = [];
                $updateuser = Db::table('os_user')
                    ->where('id',$val)
                    ->update(array('advance_status'=>1));
                    if($updateuser){
                        $is_success = 1;
                    }else{
                        $is_success = 0;
                    }
            }
        if ($is_success == 1) {
            $data = [
                'code'=>2000,
            ];
            echo json_encode($data);
        } else {
            $data = [
                'code'=>1000,
            ];
            echo json_encode($data);
        }
    }

    /**
     * 编辑
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $coursenew = $this->coursepre_model->find($id);
        return $this->fetch('edit', ['coursepre_edit' => $coursenew]);
    }

    /**
    * @初赛批量文件下载
    * @return mixed
    *
     */
	public function alldownload(Request $request){
        $requestData = $request -> param();
        $arrdata = [
            'userid'    => $requestData['ids'],
        ];
        $is_success = 0;
        foreach ($arrdata['userid'] as $val){
            //$arr = [];
            $downallfiles = Db::table('os_usercontent')
                ->field(array('csname,designname,demoname,evaluatename'))
                ->where('userid',$val)
                ->select();
            dump($downallfiles);die();
            if($updateuser){
                $is_success = 1;
            }else{
                $is_success = 0;
            }
        }
        if ($is_success == 1) {
            $data = [
                'code'=>2000,
            ];
            echo json_encode($data);
        } else {
            $data = [
                'code'=>1000,
            ];
            echo json_encode($data);
        }

    }
    /**
     * @初赛文件下载I 教学设计
     * @return mixed
     *
     */
    public  function download($id){
        $usercontent = Db::table('os_usercontent')->where('userid',$id)->find();
        $csname_name = '[教学设计]'.substr(strrchr($usercontent['csname'], ']'), 1);//文件名称
        $file_url   = '.'.$usercontent['designname'];//文件路径I-教学课件
        if(!isset($file_url)||trim($file_url)==''){
            echo "系统发生错误";
            return false;
        }
        if(!file_exists($file_url)){ //检查文件是否存在
            echo "找不到文件";
            return false;
        }
        $new_name       ='';
        $file_name      = basename($file_url);
        $file_name      = trim($new_name=='')?$file_name:urlencode($new_name);
        $fie_newname    = str_replace(strstr($file_name, '.', TRUE),$csname_name,$file_name);
        $file_type      = explode('.',$file_url);
        $file_type      = $file_type[count($file_type)-1];
        $file_type      = fopen($file_url,'r+'); //打开文件
        $fie_newname = iconv("utf-8","gb2312",$fie_newname);
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($file_url));
        header("Content-Disposition: attachment; filename=".$fie_newname);
        ob_clean();
        flush();
        //输出文件内容
        echo fread($file_type,filesize($file_url));
        fclose($file_type);
    }
    /**
     * @演示课件下载
     * @return demoname
     *
     */
    public  function downdemoname($id){
        $usercontent = Db::table('os_usercontent')->where('userid',$id)->find();
        $csname_name = '[演示课件]'.substr(strrchr($usercontent['csname'], ']'), 1);//文件名称
        $file_url  = '.'.$usercontent['demoname'];//文件路径II
        if(!isset($file_url)||trim($file_url)==''){
            echo "系统发生错误";
            //$this->error('系统发生错误');
            return false;
        }
        if(!file_exists($file_url)){ //检查文件是否存在
            echo "找不到文件";
            //$this->error('找不到文件');
            return false;
            //exit();
        }
        $new_name       ='';
        $file_name      = basename($file_url);
        $file_name      = trim($new_name=='')?$file_name:urlencode($new_name);
        $fie_newname    = str_replace(strstr($file_name, '.', TRUE),$csname_name,$file_name);
        $file_type=explode('.',$file_url);
        $file_type=fopen($file_url,'r+'); //打开文件
        $fie_newname = iconv("utf-8","gb2312",$fie_newname);//文件名称编码转化
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($file_url));
        header("Content-Disposition: attachment; filename=".$fie_newname);
        ob_clean();
        flush();
        //输出文件内容
        echo fread($file_type,filesize($file_url));
        fclose($file_type);
    }
    /**
     * @评测课件下载
     * @return evaluatename
     *
     */
    public  function downevaluatename($id){
        $usercontent = Db::table('os_usercontent')->where('userid',$id)->find();
        $csname_name = '[评测练习]'.substr(strrchr($usercontent['csname'], ']'), 1);//文件名称
        $file_url  = '.'.$usercontent['evaluatename'];//evaluatename文件路径
        if(!isset($file_url)||trim($file_url)==''){
            echo "系统发生错误";
            return false;
        }
        if(!file_exists($file_url)){ //检查文件是否存在
            echo "找不到文件";
            return false;
        }
        $new_name       ='';
        $file_name      = basename($file_url);
        $file_name      = trim($new_name=='')?$file_name:urlencode($new_name);
        $fie_newname    = str_replace(strstr($file_name, '.', TRUE),$csname_name,$file_name);
        $file_type=explode('.',$file_url);
        $file_type=$file_type[count($file_type)-1];
        $file_type=fopen($file_url,'r+'); //打开文件
        $fie_newname = iconv("utf-8","gb2312",$fie_newname);//文件名称编码转化
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($file_url));
        header("Content-Disposition: attachment; filename=".$fie_newname);
        ob_clean();
        flush();
        //输出文件内容
        echo fread($file_type,filesize($file_url));
        fclose($file_type);
    }
    /**
     * @初赛文件下载III(打包下载)
     * @return mixed
     *
     */
    public function zipdown($id){
        $usercontent = Db::table('os_usercontent')->where('userid',$id)->find();
        $csname = $usercontent['csname'];//文件名称
        $files['designname']  = '.'.$usercontent['designname'];//文件路径I
        $files['demoname']  = '.'.$usercontent['demoname'];//文件路径II
        if($usercontent['evaluatename']){
            $files['evaluatename']  = '.'.$usercontent['evaluatename'];
        }
        $zipName = '/home/www/courses/public/uploads/download/downcourses.zip';
        $zip = new \ZipArchive;//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
        if ($zip->open($zipName, \ZIPARCHIVE::OVERWRITE | \ZIPARCHIVE::CREATE)!==TRUE) {

            exit('无法打开文件，或者文件创建失败');
        }
        foreach($files as $key => $val){
            //$attachfile = $attachmentDir . $val['filepath']; //获取原始文件路径
            if(file_exists($val)){
                $file_name    =   basename($val);
                if($key == 'designname'){
                    $csname_name = '[教学设计]'.substr(strrchr($usercontent['csname'], ']'), 1);//教学设计
                    $val_newname    =   str_replace(strstr($file_name, '.', TRUE),$csname_name,$file_name);
                }
                if($key == 'demoname'){
                    $csname_name = '[演示课件]'.substr(strrchr($usercontent['csname'], ']'), 1);//演示课件
                    $val_newname    =   str_replace(strstr($file_name, '.', TRUE),$csname_name,$file_name);
                }
                if($key == 'evaluatename'){
                    $csname_name = '[评测练习]'.substr(strrchr($usercontent['csname'], ']'), 1);//评测练习
                    $val_newname    =   str_replace(strstr($file_name, '.', TRUE),$csname_name,$file_name);
                }
                $zip->addFile($val, $val_newname);//第二个参数是放在压缩包中的文件名称
            }
        }
        @$zip->close();//关闭
        if(!file_exists($zipName)){
            exit("无法找到文件"); //即使创建，仍有可能失败
        }
        $new_name       ='';
        $file_name      = basename($zipName);
        $file_name      = trim($new_name=='')?$file_name:urlencode($new_name);
        $fie_newname    = str_replace(strstr($file_name, '.', TRUE),$csname,$file_name);

        $fie_newname = iconv("utf-8","gb2312",$fie_newname);//文件名称编码转化
        //如果不要下载，下面这段删掉即可，如需返回压缩包下载链接，只需 return $zipName;
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename='.basename($fie_newname)); //文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: '. filesize($zipName)); //告诉浏览器，文件大小
        @readfile($zipName);
        exit();

    }


    /**
     * 根据生日进行计算年龄
     * @param $id
     * @return mixed
     */	
	static function birthday($birthday){
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
	/**
	*  获取文件大小I
     * @param
     * @return//echo getRealSize(getDirSize('需要获取大小的目录'));
     */
    // 获取文件夹大小I
    static function getDirSize($dir)
    {
        $size = 0;
        $dirs = [$dir];

        while(@$dir=array_shift($dirs)){
            @$fd = opendir($dir);
            while(@$file=readdir($fd)){
                if($file=='.' && $file=='..'){
                    continue;
                }
                $file = $dir.DIRECTORY_SEPARATOR.$file;
                if(is_dir($file)){
                    array_push($dirs, $file);
                }else{
                    @$size += filesize($file);
                }
            }
            @closedir($fd);
        }
        return $size;
    }
    // 单位自动转换函数
    static function getRealSize($size)
    {
        $kb = 1024;   // Kilobyte
        $mb = 1024 * $kb; // Megabyte
        $gb = 1024 * $mb; // Gigabyte
        $tb = 1024 * $gb; // Terabyte
        if($size < $kb)
        {
            return $size." B";
        }
        else if($size < $mb)
        {
            return round($size/$kb,2)." KB";
        }
        else if($size < $gb)
        {
            return round($size/$mb,2)." MB";
        }
        else if($size < $tb)
        {
            return round($size/$gb,2)." GB";
        }
        else
        {
            return round($size/$tb,2)." TB";
        }
    }

    /**
     *  获取文件大小II
     * @param
     * @return
     */
    static  function ReadFilesize($size) {
        $mod = 1024;
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        return round($size, 2) . ' ' . $units[$i];
    }




}