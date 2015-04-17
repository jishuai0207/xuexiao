<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Teacher extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('teacher_model');
        $this->load->model('user_model');
        $this->load->model('grade_model');
        $this->load->model('teacher_subject_model');
        $this->load->model('subject_model');
        $this->config->load('public');
        $this->sm->assign('menu_hover',$this->left_menu_config['teacher']);
        $this->config->load('public');
        loadLib('Operation_data');
    }

	/**
	 * Description : 教师列表
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:28
	*/
    public function index(){
        $this->checklogin();
        safeFilter();
        $row = 30;
        $p = (isset($_REQUEST['p']) and $_REQUEST['p'] != '')?$_REQUEST['p']:'1';
        $keywords= (isset($_REQUEST['keywords'])&&$_REQUEST['keywords']!='')?$_REQUEST['keywords']:"";
		(isset($_REQUEST['keywords']) and $keywords != '')?$injob= '2':$injob='1';
        $injob = (isset($_REQUEST['injob']) and $_REQUEST['injob'] != '')?$_REQUEST['injob']:$injob;
        $search = trim($keywords);
        $teachers = $this->teacher_model->getList($_SESSION['institution'],$search,$injob,$p,$row);
		//var_dump($teachers);exit;
        $total = $this->teacher_model->getListNum($_SESSION['institution'],$search,$injob)->num;
		$teacher = array();
        if($total){
            foreach($teachers as $v){
                $teacher[$v->id]['truthName'] = $v->truthName;
                $teacher[$v->id]['teacherId'] = $v->id;
                $teacher[$v->id]['infoUrl'] = '/'.$this->url_config['teacherInfo'].'?teacherId='.$v->id;
                $teacher[$v->id]['modifyUrl'] = '/'.$this->url_config['teacherModify'].'?teacherId='.$v->id;
				$teacher[$v->id]['nickName'] = $v->nickname != ''?'('.$v->nickname.')':'';
                $teacher[$v->id]['status'] = $v->status;
                $teacher[$v->id]['path'] = $v->path == ''?$this->common_public['default_avatar']['120']:$v->path;
                $teacher[$v->id]['createTime'] = substr($v->createTime,0,10);
                $teacher[$v->id]['inJob'] = $v->inJob == 1?'在职':'离职';
                $teacher[$v->id]['inJobNum'] = $v->inJob;
                $teacher[$v->id]['infoUrl'] = '/'.$this->url_config['teacherInfo'].'?teacherId='.$v->id;
                $v->inJob ==1 ? $teacher[$v->id]['action'] = '离职登记' : $teacher[$v->id]['action'] = '入职登记';
                $v->inJob ==1 ? $teacher[$v->id]['actionUrl'] = '/'.$this->url_config['teacherLeaveJob']:$teacher[$v->id]['actionUrl'] = '/'.$this->url_config['teacherOnJob'];
                $teacher[$v->id]['class'] = $v->classNum?$v->classNum:'0';
                $teacher[$v->id]['teacherCode'] = $v->teacherCode;
                if(! isset($teacher[$v->id]['subject'])){
                    $teacher[$v->id]['subject'] = '';
                }
                $teacher[$v->id]['subject'] = ltrim($teacher[$v->id]['subject'] .'、'.$v->sname,'、');
            }
        }
        $data['teacherList'] = $teacher;
        $data['keywords'] = $keywords;
        $data['teacherAdd'] = $this->url_config['teacherAdd'];
        $data['upload'] = '/index.php/teacher/upload';
        $data['download'] = '/index.php/teacher/download';
        $data['total'] = $total;
        $data['upload'] = DOMAIN.$this->url_config['teacherUpload'];
        $data['add'] = DOMAIN.$this->url_config['teacherAdd'];

        $data['keywords'] = $keywords;
        $data['injob'] = $injob;

        $data['postUrl'] = '/'.$this->url_config['teacherList'].'?injob=2&keywords='.$keywords;
        $data['inJobUrl'] = '/'.$this->url_config['teacherList'].'?injob=1&keywords='.$keywords;
        $data['outJobUrl'] = '/'.$this->url_config['teacherList'].'?injob=0&keywords='.$keywords;
        $data['allJobUrl'] = '/'.$this->url_config['teacherList'].'?injob=2&keywords='.$keywords;

        $operation_data =new Operation_data(); 
        $operation_data->base_url = '/'.$this->url_config['teacherList'].'?injob='.$injob.'&keywords='.$keywords;
        $operation_data->total_rows = $total;
        $operation_data->per_page = $row;
        $operation_data->cur_page= $p;
        $data['page'] = $operation_data->show_page();
        //var_dump($teacher);
        $this->sm->view('teacher/index',$data);
    }

    /**
     *description:录入老师
     *author:yanyalong
     *date:2014/12/05
     */
    public function add(){
        $this->checklogin();
        //获取机构学科列表
        $subjectlist = $this->subject_model->getlist();
        foreach ($subjectlist as $key => $val) {
            $subject[$key]['subjectId']  = $val->id;
            $subject[$key]['subjectName']  = $val->name;
        }
        $data['subject'] = $subject;
        $data['inJob'] = array(1=>'在职',0=>'离职');
        $data['sex'] = array(1=>'男',0=>'女');
        $data['position'] = array(1=>'全职',0=>'兼职');
        //出生年
        $birthday_year = array();
        $currentYear = date('Y');
        $maxYear = $currentYear - 85;
        $minYear = $currentYear - 15;
        for ($i=$minYear;$i>=$maxYear; $i--) {
            $birthday_year[] = $i;
        }
        $data['birthday_year'] = $birthday_year;
        //出生月
        $birthday_month = array();
        for ($i=1; $i<=12; $i++) {
            $birthday_month[] = $i;
        }
        $data['birthday_month'] = $birthday_month;
        $this->sm->view('teacher/add',$data);
    } 

    /**
     *description:老师录入成功
     *author:yanyalong
     *date:2014/12/05
     */
    public function success(){
        $this->checklogin();
        $data['title'] = "录入成功";
        $data['continue'] = '/'.$this->url_config['teacherAdd'];
        $data['list'] = '/'.$this->url_config['teacherList'];
        $public_config = $this->config->item('common_public');
        $data['pass'] = $public_config['teacherInfo']['initPass'];
        $this->sm->view('teacher/success',$data);
    } 

    /**
     *description:闫亚龙
     *author:yanyalong
     *date:2014/12/05
     */
    public function modify(){
        $this->checklogin();
        $teacherId = (isset($_REQUEST['teacherId'])&&trim($_REQUEST['teacherId'])!="")?$_REQUEST['teacherId']:echojson(0,'','操作异常');
        $res = $this->teacher_model->getById($_SESSION['institution'],$teacherId);
        if($res==false){
		   show_404('找不到此老师信息');
        }
        $data['truthName'] = $res->truthName;
        $data['nickname'] = $res->nickname;
        $data['telphone'] = $res->telphone;
        $data['email'] = $res->email;
        $data['idCard'] = $res->idCard;
        //获取机构学科列表
        $subjectlist = $this->subject_model->getlist();
        $subjectArr = array();
        $teaSubList = $this->teacher_model->getSubject($teacherId);
        foreach ($teaSubList as $key => $val) {
            $subjectArr[] = $val->subjectId; 
        }
        foreach ($subjectlist as $key => $val) {
                $subject[$key]['subjectId']  = $val->id;
                $subject[$key]['subjectName']  = $val->name;
                $subject[$key]['isselect']= 0;
                if(in_array($val->id,$subjectArr)){
                    $subject[$key]['isselect']= 1;
                } 
        }
        $data['subject'] = $subject;
        $inJob = array(1=>'在职',0=>'离职');
        $data['inJob'] = array();
        foreach ($inJob as $key => $val) {
            $data['inJob'][$key]['desc'] = $val;
            $data['inJob'][$key]['isselect'] = 0;
            $data['inJob'][$key]['type'] = $key;
            if($res->inJob==$key) {
                $data['inJob'][$key]['isselect'] = 1;
            }
        }
        $sex = array(1=>'男',0=>'女');
        $data['sex'] = array();
        foreach ($sex as $key => $val) {
            $data['sex'][$key]['desc'] = $val;
            $data['sex'][$key]['isselect'] = 0;
            $data['sex'][$key]['type'] = $key;
            if($res->sex!=""&&($res->sex==$key)) {
                $data['sex'][$key]['isselect'] = 1;
            }
        }
        $position = array(1=>'全职',0=>'兼职');
        $data['position'] = array();
        foreach ($position as $key => $val) {
            $data['position'][$key]['desc'] = $val;
            $data['position'][$key]['isselect'] = 0;
            $data['position'][$key]['type'] = $key;
            if($res->position==$key) {
                $data['position'][$key]['isselect'] = 1;
            }
        }
        //出生年
        $birthday_year = array();
        $currentYear = date('Y');
        $maxYear = $currentYear - 85;
        $minYear = $currentYear - 15;
        for ($i=$minYear;$i>=$maxYear; $i--) {
            $birthday_year[] = $i;
        }
        //出生月
        $birthday_month = array();
        for ($i=1; $i<=12; $i++) {
            $birthday_month[] = $i;
        }
        $data['birthday_year'] = "";
        $data['birthday_month'] = "";
        if($res->birthday!=""){
            $data['birthday_year'] = array();
            $data['birthday_month'] = array();
            $birthdayArr = explode('-',$res->birthday);
            foreach ($birthday_year as $key => $val) {
                $data['birthday_year'][$key]['year'] = $val; 
                $data['birthday_year'][$key]['isselect'] = 0; 
                if($birthdayArr['0']==$val) {
                    $data['birthday_year'][$key]['isselect'] = 1; 
                }
            }
            foreach ($birthday_month as $key => $val) {
                $data['birthday_month'][$key]['month'] = $val; 
                $data['birthday_month'][$key]['isselect'] = 0; 
                if($birthdayArr['1']==$val) {
                    $data['birthday_month'][$key]['isselect'] = 1; 
                }
            }
        }else{
            foreach ($birthday_year as $key => $val) {
                $data['birthday_year'][$key]['year'] = $val; 
                $data['birthday_year'][$key]['isselect'] = 0; 
            }
            foreach ($birthday_month as $key => $val) {
                $data['birthday_month'][$key]['month'] = $val; 
                $data['birthday_month'][$key]['isselect'] = 0; 
            }
        }
        $data['teacherId'] = $res->id;
        $this->sm->view('teacher/modify',$data);
    }

	/**
	 * Description : 教师离职登记
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:30
	*/
    public function leavejob(){
        $this->ajaxChecklogin();
        safeFilter();
        $userid =(int) isset($_GET['teacherId'])?$this->input->get('teacherId',true):0;
        $Replace = $this->teacher_model->hasReplaceClass($userid,$_SESSION['institution']);
        $Current = $this->teacher_model->getCurrentClass($userid,$_SESSION['institution']);
        if($Replace || $Current){
            $msg = "<p>老师仍有任课/代课的班级</p><p class='grey'>登记离职前需确保老师已无任课或者代课班级</p>";
            $data['title'] = '登记离职';
            echojson(0,$data,$msg);
        }else{
            if($this->teacher_model->leaveJob($userid)){
                echojson(1,'','登记离职成功');
            }else{
                echojson(0,'','登记离职失败');
            }
        }
    }

	/**
	 * Description : 添加教师成功页
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:31
	*/
    public function addsucc(){
        $this->ajaxChecklogin();
        safeFilter();
        $userid =(int) isset($_GET['teacherId'])?$this->input->get('teacherId',true):0;
        $data['continue'] = '/'.$this->url_config['teacherAdd'];
        $data['allStudent'] = '/'.$this->url_config['teacherList'];
        echojson(1,$data,'添加成功');
    }

	/**
	 * Description : 教师入职登记
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:31
	*/
    public function onjob(){
        $this->ajaxChecklogin();
        safeFilter();
        $userid =(int) isset($_GET['teacherId'])?$this->input->get('teacherId',true):0;
        $data['title'] = '入职登记';
        if($this->teacher_model->onJob($userid,$_SESSION['institution'])){
            echojson(1,$data,'入职成功');
        }else{
            echojson(0,$data,'入职失败');
        }
    }

	/**
	 * Description : 教师基本信息展示
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:31
	*/
    public function info(){
        $this->checklogin();
        safeFilter();
        $userid =(int) isset($_GET['teacherId'])?$this->input->get('teacherId',true):0;
		$info = array();
        $info = $this->teacher_model->getInfoById($userid,$_SESSION['institution']);
		if(!$info) show_404('找不到此老师信息');
		$subjects = $this->teacher_model->getSubject($userid);
		$subjectArr = array();
		foreach($subjects as $v){
			$subjectArr[] = $v->name;	
		}
		$info->subjects = implode($subjectArr,'、');
		if($info->status ==0 or $info->inJob==0){
			$info->ifmodify = 0;
		}else{
			$info->ifmodify = 1;
		}
		$info->sex = $info->sex == '1'?'男':($info->sex == '0'?'女':'-');
		$info->status==0?$info->status='【已禁用】':$info->status='';
		$info->inJob==1?$info->inJob='':$info->inJob='离职';
		$info->position = $info->position == '1'?'全职':($info->position == '0'?'兼职':'-');
		$info->birthday = substr($info->birthday,0,10);
		$info->birthday = $info->birthday ==''?'-':$info->birthday;
		$info->createTime = substr($info->createTime,0,10);
		$info->email = $info->email == ''?'-':$info->email;
		$info->subemail= strlen($info->email) > 16?substr($info->email,0,14).'...':$info->email;
		$info->idCard = $info->idCard == ''?'-':$info->idCard;
		$info->teacherCode = $info->teacherCode;
		$info->path = $info->path == ''?$this->common_public['default_avatar']['120']:$info->path;
		if($info->nickname == '') $info->nickname = '-';
		$info->email = $info->email == ''?'-':$info->email;
		$info->userName = $info->userName?$info->userName:'-';
		$info->subuserName= strlen($info->userName) > 16?substr($info->userName,0,14).'...':$info->userName;

        //班级信息
        $part = isset($_REQUEST['part'])?$_REQUEST['part']:'c';
        $p = (isset($_REQUEST['p']) and $_REQUEST['p'] != '')?$_REQUEST['p']:'1';
        $row = 30;
        $classSource = $this->teacher_model->getAllClass($userid,$part,$p,$row);
        $classAll = $this->teacher_model->getAllClass($userid,$part);
        $total = count($classAll);
        //var_dump($classSource);

        $class = array();
        $data['total'] = $total;
        if($total){
            $class = array();
            foreach($classSource as $k => $v){
                $classTmp = array();
                $classTmp['name'] = $v->className;
                $classTmp['cid'] = $v->cid;
                $classTmp['stuNum'] = $v->studentNumber;
                if($v->beginTime){
                    $classTmp['beginTime'] = substr($v->beginTime,0,10);
                }else{
                    $classTmp['beginTime'] = '未知';
                }
                if($v->endTime){
                    $classTmp['endTime'] = substr($v->endTime,0,10);
                }else{
                    $classTmp['endTime'] = '未知';
                }
                $classTmp['joinTime'] = substr($v->joinTime,0,10);
                $classTmp['classUrl'] = '/'.$this->url_config['classInfo'].'?classId='.$v->cid;
                $class[]  = $classTmp;
            }
        }
        $data['classList'] = $class;
		$data['part'] = $part;
		//var_dump($data);exit;
        $operation_data =new Operation_data(); 
        $operation_data->base_url = '/'.$this->url_config['teacherInfo'].'?teacherId='.$userid.'&part='.$part;
        $operation_data->total_rows = $total;
        $operation_data->per_page = $row;
        $operation_data->cur_page= $p;
        $data['page'] = $operation_data->show_page();

        $data['teacherList'] = DOMAIN.$this->url_config['teacherList'];
        $data['modify'] = DOMAIN.$this->url_config['teacherModify'].'?teacherId='.$userid;
        $data['upload'] = DOMAIN.$this->url_config['teacherUpload'];
        $data['on'] = DOMAIN.'index.php/teacher/onjob';
        $data['off'] = DOMAIN.'index.php/teacher/leavejob';
        $data['teacherId'] = $userid;
        $data['current'] = DOMAIN.'index.php/teacher/info?teacherId='.$userid.'&part=c';
        $data['history'] = DOMAIN.'index.php/teacher/info?teacherId='.$userid.'&part=h';
        $data['all'] = DOMAIN.'index.php/teacher/info?teacherId='.$userid.'&part=a';
        $data['info'] = $info;
        $this->sm->view('teacher/info',$data);
    }

	/**
	 * Description : 上传excel页面
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:33
	*/
	public function upload(){
        $this->checklogin();
        $data['step'] = (isset($_REQUEST['step'])&&(in_array($_REQUEST['step'],array('1','2'))))?$_REQUEST['step']:"1";
        $data['fileMd5'] = (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:"";
        $data['status'] = (isset($_REQUEST['status'])&&(in_array($_REQUEST['status'],array('1','0'))))?$_REQUEST['status']:"0";
        $data['isup'] = (isset($_REQUEST['isup'])&&(in_array($_REQUEST['isup'],array('1'))))?$_REQUEST['isup']:"0";
        if($data['step']=='1')
            $data['status'] = '0';
        if($data['status']=='0')
            $data['step'] = '1';
		$data['upUrl'] = DOMAIN.'index.php/teacher/doupload';
		//$data['nextUrl'] = DOMAIN.'index.php/student/uploadstatus?step='.$data['step'];
		$this->sm->view('teacher/upload',$data);
	}

	/**
	 * Description : 对上传进行简单处理及鉴别
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:33
	*/
    public function doupload(){
        $this->ajaxChecklogin();
        $this->config->load('uploads');		
        $config = $this->config->item("teacher");
        $this->load->library('upload');
        $_FILES['userfile'] = $_FILES['UpLoadFile'];
        $is_upload = $this->upload->upload_file($config);
		//echo $this->upload->display_errors();
        if(empty($is_upload)){
            $status = '0';
            $step = 1;
            $fileMd5Para = "";
        }else{
            $status = '1';
            $step = 2;
            $fileMd5 = trim($is_upload['upload_data']['file_name'],'.xlsx');
            $fileMd5Para = "&fileMd5=".$fileMd5;
        }
		$url = '/'.$this->url_config['teacherUpload'].'?&step='.$step.'&status='.$status.$fileMd5Para.'&isup=1';
        header("Location:".$url);exit; 
    }

	/**
	 * Description : 获取文件上传反馈错误信息
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:34
	*/
    public function uploadstatus(){
        $this->ajaxChecklogin();
        $status = (isset($_REQUEST['status'])&&$_REQUEST['status']!="")?$_REQUEST['status']:'0';
        $fileMd5= (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:'';
        if($status=='0'){
            echojson(0,"",'上传失败,文件格式与模版文件不符');
        }

        $this->config->load('uploads');     
        $config = $this->config->item("teacher");      
        $sourcefile = $config['upload_path'].$fileMd5.".xlsx";
        //var_dump($sourcefile);exit;
        if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
        //开始处理excel文件，最终生成数组
		$type="Excel2007";
        loadLib("excel/PHPExcel");
        loadLib("excel/PHPExcel/IOFactory");
		$xlsReader = PHPExcel_IOFactory::createReader($type);
		$objPHPExcel = PHPExcel_IOFactory::load($sourcefile);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$xlsReader->setReadDataOnly(true);
		$xlsReader->setLoadSheetsOnly(true);
		$Sheets = $xlsReader->load($sourcefile);
        $objSheets = $Sheets->getSheet(0);
        $highestRow = $objSheets->getHighestRow(); //行数
        $highestColumn = $objSheets->getHighestColumn(); //取得总列 返回的是字母Q
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        //判断列数是否与要求相同
		if($highestColumn != 'L') echojson(0,'','模板格式不对，请下载标准模板');
		$excelDate = array();
		for($row = 2;$row <= $highestRow;$row++){
			for($col = 0;$col < $highestColumnIndex;$col++){
				$excelDate[$row][$col] = trim(strval($objWorksheet->getCellByColumnAndRow($col,$row)->getValue()));
			}
		}
		foreach($excelDate as $k => $v){
			$tempRow = array_filter($v);
			if(!$tempRow) unset($excelDate[$k]);
		}
        $totalNum = count($excelDate);
		if(!$totalNum) echojson(0,'','所上传的文件老师信息为空');

		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        $titles = array();//记录标题
		//判断标题及顺序
		for($i=0;$i<$highestColumnIndex;$i++){
			$titles[] = strval($objWorksheet->getcellbycolumnandrow($i,1)->getvalue());
		}
        $teacher_config = $this->config->item("titlet");		
        $schedulecolumn_config = $this->config->item("scheduleFileColumn");		
		//var_dump($titles);
		//var_dump($teacher_config);
        if($teacher_config != $titles){
            echojson(0,"",'首行标题与模版文件不符,请下载标准模板');
        }
		$url = '/index.php/teacher/uploadstep1?fileMd5='.$fileMd5;
        $data['url'] = $url;
        echojson(1,$data,'上传成功');
    }

	/**
	 * Description : 上传信息是否通过判断
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:35
	*/
	public function uploadstep1(){
        $this->checklogin();
		$data['title'] = "上传教师信息表";
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
		if($fileMd5==""){
			$data['fileMd5'] = "";
		}else{
			$data['fileMd5'] = $fileMd5;
		}
		$data['url']['enter'] = '/'.$this->url_config['teacherUploadEnter'].'?fileMd5='.$fileMd5;
		$data['url']['back'] = '/'.$this->url_config['teacherUpload'];
		$this->sm->view('teacher/check',$data); 
	}

	/**
	 * Description : 上传第二步数据检测并反馈
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:35
	*/
	public function  checkStep2(){
        $this->ajaxChecklogin();
		$this->config->load('uploads');     
		$config = $this->config->item("teacher");      
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:echojson(0,'','异常操作');
		$_SESSION['fileMd5'] = $fileMd5;
		$this->config->load('uploads');     
		$config = $this->config->item("teacher");      
		$sourcefile = $config['upload_path'].$fileMd5.".xlsx";
		//var_dump($sourcefile);exit;
		if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
		$data = $this->checkdata();
		$tmpData['err'] = $data['err'];
		$tmpData['total'] = $data['total'];
		$tmpData['errNum'] = $data['excelErr'];
		$tmpData['isAllowInsert'] = $data['continue'];
		$tmpData['normal'] = $tmpData['total']-$tmpData['errNum'];
		$tmpData['url'] = '/'.$this->url_config['teacherErrorAjax'].'?fileMd5='.$fileMd5;
		$tmpData['page'] = $data['page'];
		if($data['continue']==false){
			echojson(0,$tmpData,'有错误信息不能上传');
		}else{
			echojson(1,$tmpData);
		}
	}

	/**
	 * Description : 上传数据检测并反馈(返回TYPE：1、信息无效2、与数据库的重复3、与文件本身行的重复)
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:35
	*/
	public function checkdata(){
        $this->ajaxChecklogin();
        $fileMd5= $_SESSION['fileMd5'];
        $this->config->load('uploads');     
        $config = $this->config->item("teacher");      
        $sourcefile = $config['upload_path'].$fileMd5.".xlsx";
        if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
		$type = 'Excel2007';
        loadLib("excel/PHPExcel");
        loadLib("excel/PHPExcel/IOFactory");
		$xlsReader = PHPExcel_IOFactory::createReader($type);
		$objPHPExcel = PHPExcel_IOFactory::load($sourcefile);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$xlsReader->setReadDataOnly(true);
		$xlsReader->setLoadSheetsOnly(true);
		$Sheets = $xlsReader->load($sourcefile);
        //开始读取
        $objSheets = $Sheets->getSheet(0);
        $highestRow = $objSheets->getHighestRow(); //行数
        $highestColumn = $objSheets->getHighestColumn(); //取得总列 返回的是字母Q
        if($highestColumn != 'L') echojson(0,'','请使用标准模板');
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
		for($row = 2;$row <= $highestRow;$row++){
			for($col = 0;$col < $highestColumnIndex;$col++){
				$excelDate[$row][$col] = trim(strval($objWorksheet->getCellByColumnAndRow($col,$row)->getValue()));
			}
		}
		foreach($excelDate as $k => $v){
			$tempRow = array_filter($v);
			if(!$tempRow) unset($excelDate[$k]);
		}
        $data['total'] = count($excelDate);
        $err = array();
        $tel = array();
		$email = array();
        for($row = 2;$row<= $highestRow;$row++){
            for($i=0;$i<$highestColumnIndex;$i++ ){
                $rowData = isset($excelDate[$row])?$excelDate[$row]:'';
				if($rowData){
					$value = $rowData[$i];	
					switch ($i) {
					case '0':
						$column_name = "truthName";
						if(!checkName($value)) $err[$row] = array('name'=>$value,'type'=>1,'item'=>$column_name); 
						break;
					case '1':
						$column_name = "nickName";
						if((!checkName($value)) && ($value)) $err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						break;
					case '2':
						$column_name = "telphone";
						if(! checkTel($value)){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1,'item'=>$column_name);
						}else{
							if($this->teacher_model->exist($value)){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>2,'item'=>$column_name);
							}
							if(in_array($value,$tel)){
								$same_row = array_search($value,$tel);
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>3,'same_row'=>$same_row,'item'=>$column_name);
							}else{
								$tel[$row] = $value;
							}
						}
						break;
					case '3':
						$column_name = "subject1";
						if($value){
							$subject = $this->subject_model->getSubjectByName($value);
							if(!$subject){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
							}else{
								$value = $subject->id;
							}
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						}
						break;
					case '4':
						$column_name = "subject2";
						if($value){
							$subject = $this->subject_model->getSubjectByName($value);
							if(!$subject){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
							}else{
								$value = $subject->id;
							}
						}
						break;
					case '5':
						$column_name = "subject3";
						if($value){
							$subject = $this->subject_model->getSubjectByName($value);
							if(!$subject){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
							}else{
								$value = $subject->id;
							}
						}
						break;
					case '6':
						$column_name = "sex";
						if($value == '男'){
							$value='1';
						}elseif($value=='女'){
							$value='0';
						}elseif($value ==''){
							$value=null;
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						}
						break;
					case '7':
						$column_name = "email";
						if(!$value){ $value = $res[$row-1]['telphone'].'@gaosiedu.com';$email[] = $value; break; }
						if(preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/',$value)){
							$userInfoEmail = $this->user_model->getInfoByEmail($value);
							if($value !=""&&($userInfoEmail!=false || in_array($value,$email))){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
							}else{
								$email[] = $value; 
							}
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name); 
						}
						break;
					case '8':
						$column_name = "idCard";
						if(!$value) break;
						if(! preg_match('/^\d{17,18}[A-Za-z0-9]$/',$value)){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						}
						break;
					case '9':
						$column_name = "birthday";
						if(!$value) break;
						if(preg_match('/^\d{6}$/',$value)){
							$currentYear = date('Y',time());
							$year = substr($value,0,4);
							$month = substr($value,4,2);
							if(($year > $currentYear - 15 or $year < $currentYear - 85) or ($month > 12 or $month < 1)){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
							}else{
								$value = substr($value,0,4).'-'.substr($value,4,2);
							}
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						}
						break;
					case '10':
						$column_name = "position";
						if($value == '全职' or $value == ''){
							$value='1';
						}elseif($value=='兼职'){
							$value='0';
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						}
						break;
					case '11':
						$column_name = "inJob";
						if($value == '在职' or $value == ''){
							$value='1';
						}elseif($value=='离职'){
							$value='0';
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'type'=>1,'item'=>$column_name);
						}
						break;
					default :
						break;
					}
					$res[$row-1][$column_name] = $value;
				}
            }	
        }
		$totalErr = count($err);
		$length = $row = "10";
		$page =(int) isset($_REQUEST['p'])?$_REQUEST['p']:"1";
		if($page == 'undefined') $page = '1';
		$errPageArr = array();
		$data['continue'] = true;
        if(isset($err)){
            foreach($err as $k=>$v){
                if($v['type'] == 1 or $v['type'] == 2 or $v['type'] == 3){
                    $data['continue'] = false;
                    break;
                }
            }
			if($page*$row > $totalErr) $length = $totalErr%$row;
			$errPageArr = array_slice($err,($page-1)*$row,$length,true);	
            foreach($errPageArr as $k=>$v){
				if($v['type'] == '1'){
                    $errPageArr[$k]['checkinfo'] = '信息不完整或者无效';
				}elseif($v['type'] == '2'){
                    $errPageArr[$k]['checkinfo'] = '与已有账号重复，请确认手机号正确且该老师之前没有注册过';
				}elseif($v['type'] == '3'){
                    $errPageArr[$k]['checkinfo'] = '与第'.$v['same_row'].'行手机号重复';
				}
				$data['continue'] = false;
            }
		}
		//var_dump($errPageArr);exit;

		$operation_data =new Operation_data(); 
		$operation_data->base_url = "/index.php/teacher/checkStep2?fileMd5=".$fileMd5;
		$operation_data->total_rows = $totalErr;
		$operation_data->per_page = $row;
		$operation_data->cur_page= $page;
		$data['page'] = $operation_data->show_page_ajax();

        $data['excelErr']=count($err);
		$data['teacherList'] = $res;
		$data['err'] = $errPageArr;

		return $data;
	}
	
	/**
	 * Description : 执行插入
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:42
	*/
	public function doinsert(){
        $this->ajaxChecklogin();
        $this->config->load('uploads');     
        $config = $this->config->item("teacher");      
        $fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:echojson(0,'','异常操作');
        $this->config->load('uploads');     
        $config = $this->config->item("teacher");      
        $sourcefile = $config['upload_path'].$fileMd5.".xlsx";
        if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
        $data = $this->checkdata($fileMd5);
		$data['normal'] = $data['total'] - $data['excelErr'];
		if($data['continue'] == false){
			echojson(0,$data,'有错误信息不能上传');
		}
		$res = $data['teacherList'];
		//var_dump($res);exit;
        foreach($res as $k=>$v){
            $tableTeacher[$k]['truthName'] = $v['truthName'];
            $tableTeacher[$k]['nickName'] = $v['nickName'];
            $tableTeacher[$k]['telphone'] = $v['telphone'];
            $tableTeacher[$k]['sex'] = $v['sex'];
            $tableTeacher[$k]['email'] = $v['email'];
            $tableTeacher[$k]['idCard'] = $v['idCard'];
            $tableTeacher[$k]['birthday'] = $v['birthday'];
            $tableTeacher[$k]['position'] = $v['position'];
            $tableTeacher[$k]['institution'] = $_SESSION['institution'];
            $tableTeacher[$k]['isadmin'] = 0;
            $tableTeacher[$k]['capacity'] = 1;
            $tableTeacher[$k]['status'] = 1;
            $tableTeacher[$k]['inJob'] = 1;
        }
        $public_config = $this->config->item('common_public');
        foreach($res as $k=>$v){
            $tableUser[$k]['realName'] = $v['truthName'];
            $tableUser[$k]['userName'] = $v['telphone'];
            $tableUser[$k]['password'] = md5($public_config['teacherInfo']['initPass']);
            $tableUser[$k]['telephone'] = $v['telphone'];
            $tableUser[$k]['createTime'] = date('Y-m-d H:i:s',time());
            $tableUser[$k]['sex'] = $v['sex'];
        }
		$succ1 = $this->teacher_model->uploadInsert($tableTeacher);
		$succ2 = $this->user_model->uploadInsert($tableUser);
        if($succ1 && $succ2){
            foreach($res as $k=>$v){
                $id = $this->teacher_model->getIdByTelphone($v['telphone'])->id;
				$this->teacher_model->updateTeacherCode($id,$_SESSION['institution']);
                $tableSubject = array();
                if($v['subject1']){
                    $tableSubject[$v['subject1']] = array(
                        'teacherId' => $id,
                        'subjectId' =>$v['subject1'],
                    );
                }
                if($v['subject2']){
                    $tableSubject[$v['subject2']] = array(
                        'teacherId' => $id,
                        'subjectId' =>$v['subject2']
                    );
                }
                if($v['subject3']){
                    $tableSubject[$v['subject3']] = array(
                        'teacherId' => $id,
                        'subjectId' =>$v['subject3']
                    );
                }
				$succ3 = $this->teacher_subject_model->uploadInsert($tableSubject);
            }
			
			$succNum = min($succ1,$succ2);
			$_SESSION['succNum'] = $succNum;
			$tmpData['url'] = '/'.$this->url_config['teacherEnterSucc'];
			$tmpData['succNum'] = $succNum;
            echojson(1,$tmpData,'录入成功');

        }else{
            echojson(0,'','录入失败');
        }
	}

	/**
	 * Description : 录入成功页
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:42
	*/
	public function enterSucc(){
        $this->checklogin();
		$data['succNum'] = $_SESSION['succNum'];
		$data['title'] = '录入成功';
		$this->sm->view('teacher/entersucc',$data);
	}

	/**
	 * Description : 下载模板页
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:43
	*/
	public function download(){
		ob_clean();
		$fileName = "教师信息表模板".date('Ymd',time()).'.xlsx';
		$file = $_SERVER['DOCUMENT_ROOT'].'/uploads/default/teacherInfo.xlsx';
        sendFile($fileName,'',array('filepath'=>$file));
	}

     /**
     *description:老师重置密码页
     *author:yanyalong
     *date:2014/11/04
     */
    public function modifyPass(){
        $this->checklogin();
        $data['title'] = "修改密码";
        $this->sm->view('ucenter/modifyPass',$data);
    }
}
