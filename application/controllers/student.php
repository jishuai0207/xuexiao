<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Student extends OrgCenter_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('student_model');
		$this->load->model('grade_model');
		$this->load->model('subject_model');
		$this->load->model('class_model');
		$this->sm->assign('menu_hover',$this->left_menu_config['student']);
		loadLib('Operation_data');
	}


	/**
	 * Description : 添加学员
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:44
	 */
	public function add(){
		$this->checklogin();
		$this->load->model('grade_model');
		$grades = $this->grade_model->getlist();
		$grade = array();
		foreach($grades as $v){
			$temp['id'] =  $v->id;
			$temp['name'] =  $v->name;
			$grade[] = $temp;
		}

		$currentYear = date('Y',time());
		for($i=$currentYear-5;$i>$currentYear-22;$i--){
			$year[] = $i;
		}
		$data['year'] = $year;
		$data['postUrl'] = '/'.$this->url_config['studentAddPost'];
		$data['grade'] = $grade;
		$this->sm->view('student/add',$data);
	}

	/**
	 * Description : 修改学员
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:44
	 */
	public function modify(){
		$this->checklogin();
		safeFilter();
		$userid =(int) isset($_REQUEST['studentId'])?$this->input->get('studentId',true):0;
		$student = $this->student_model->getInfoById($userid,$_SESSION['institution']);
		if(! $student) show_404();
		$data['birthday']['year'] = '';
		$data['birthday']['month'] = '';
		if($student->birthDay){
			$date = explode('-',$student->birthDay);
			$data['birthday']['year'] = $date[0];
			$data['birthday']['month'] = $date[1];
		}
		$grades = $this->grade_model->getlist();
		$grade = array();
		foreach($grades as $v){
			$temp['id'] =  $v->id;
			$temp['name'] =  $v->name;
			$grade[] = $temp;
		}

		$currentYear = date('Y',time());
		for($i=$currentYear-5;$i>$currentYear-22;$i--){
			$data['year'][] = $i;
		}
		for($i=1;$i<10;$i++){
			$data['month']['0'.$i] = '0'.$i;
		}
		$data['month'][10]=10;
		$data['month'][11]=11;
		$data['month'][12]=12;
		$data['student'] = $student;
		$data['postUrl'] = '/'.$this->url_config['studentModifyPost'];
		$data['grade'] = $grade;
		$this->sm->view('student/modify',$data);
	}


	/**
	 * Description : 学员列表
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:44
	 */
	public function index(){
		$this->checklogin();
		safeFilter();
		$row = 30;
		$p = (isset($_REQUEST['p']) and $_REQUEST['p'] != '')?$_REQUEST['p']:'1';
		$search =isset($_REQUEST['keywords'])?$_REQUEST['keywords']:'';
		$grade =isset($_REQUEST['grade'])?$_REQUEST['grade']:'';
		$order =(isset($_REQUEST['order']) and $_REQUEST['order'] != '')?$_REQUEST['order']:'cd';
		$hasClass =(isset($_REQUEST['hasclass']) and $_REQUEST['hasclass'] != '')?$this->input->get('hasclass',true):2;
		$data['url']['post']= '/'.$this->url_config['studentList'];
		$studentIdArr['allgrade'] = array();
		$student = array();
		if($hasClass == '1' or $hasClass == '2'){
			$studentIdArr['all'] = $this->student_model->getAllID($_SESSION['institution'],$hasClass,'',$grade,$search);
			$studentIdArr['login'] = $this->student_model->getAllID($_SESSION['institution'],$hasClass,'login',$grade,$search);
			$studentIdArr['allgrade'] = $this->student_model->getAllID($_SESSION['institution'],$hasClass,'allgrade','',$search);
			$idList = $this->student_model->getIdList($_SESSION['institution'],$hasClass,$grade,$p,$row,$order,$search);
			$idStr = '';
			if($idList){
				foreach($idList as $v){
					$idStr .= $v->id.',';
				}
				$idStr = rtrim($idStr,',');
				if($idStr) $student = $this->student_model->getInfoByIdList($idStr,$order,$hasClass);
			}
		}else{
			$studentIdArr['allClass'] = $this->student_model->getAllID($_SESSION['institution'],'2','',$grade,$search);
			$studentIdArr['hasClass'] = $this->student_model->getAllID($_SESSION['institution'],'1','',$grade,$search);
			$studentIdArr['allgrade'] = $this->student_model->getAllID($_SESSION['institution'],'2','allgrade','',$search);
			$allClass = array();
			$classHas = array();
			$studentIdArr['all'] = array();
			$studentIdArr['login'] = array();
			foreach($studentIdArr['allClass'] as $v){
				$allClass[] = $v->id;
			}
			foreach($studentIdArr['hasClass'] as $v){
				$classHas[] = $v->id;
			}
			$noClass = array_diff($allClass,$classHas);
			if($noClass){
				$studentIdArr['all'] = $noClass;
				$idStr = implode($noClass,',');
				$studentIdArr['login'] = $this->student_model->getInfoOfNoClass($idStr,'login',$grade);
				if($idStr){
					$limitIdArr = $this->student_model->filterIdOfNoClass($idStr,$order,$grade,$p,$row);
					$limitIdStr = '';
					foreach($limitIdArr as $v){
						$limitIdStr .= $v->id.',';
					}
					$limitIdStr = rtrim($limitIdStr,',');
					if($limitIdStr) $student = $this->student_model->getInfoByIdList($limitIdStr,$order,$hasClass);
				} 
			}
		}

		$data['studentNum'] = count($studentIdArr['all']);
		$data['loginNum'] = count($studentIdArr['login']);
		$data['search'] = $search;
		$data['grade'] = $grade;

		$data['url']['all']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass=2&order='.$order.'&grade='.$grade;
		$data['url']['has']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass=1&order='.$order.'&grade='.$grade;
		$data['url']['no']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass=0&order='.$order.'&grade='.$grade;
		$data['url']['ca']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=ca&grade='.$grade;
		$data['url']['cd']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=cd&grade='.$grade;
		$data['url']['la']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=la&grade='.$grade;
		$data['url']['ld']= '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=ld&grade='.$grade;

		$grades = array();
		if($studentIdArr['allgrade']){
			foreach($studentIdArr['allgrade'] as $v){
				$grades[$v->grade] = $v->gname;
			}
			ksort($grades);
		}
		$data['grades'] = array_filter($grades);
		$studentList = array();

		if($data['studentNum']){
			foreach($student as $v){
				$studentTmp['path'] = $v->path == ''?$this->common_public['default_avatar']['120']:$v->path;
				$studentTmp['infoUrl'] = '/'.$this->url_config['studentInfo'].'?studentId='.$v->id;
				$studentTmp['classUrl'] = '/'.$this->url_config['classInfo'].'?studentId='.$v->id;
				$studentTmp['modifyUrl'] = '/'.$this->url_config['studentModify'].'?studentId='.$v->id;
				$studentTmp['resetUrl'] = '/'.$this->url_config['studentReset'].'?studentId='.$v->id;
				$studentTmp['name'] = $v->truthName;
				$studentTmp['unicode'] = $v->code;
				//$studentTmp['path']= $this->common_public['default_avatar']['120'];
				$studentTmp['code'] = $v->studentCode;
				$studentTmp['sex'] = $v->sex == '' ?'-':($v->sex == '1'?'男':'女');
				$studentTmp['gname'] = $v->gname == '' ?'-':$v->gname;
				$studentTmp['creatTime'] = $v->creatTime ==''?'-':substr($v->creatTime,0,10);
				$studentTmp['classNum'] = property_exists($v,'cNum')?$v->cNum:'0';
				if($v->loginTime){
					$studentTmp['loginTime'] = substr($v->loginTime,0,10);
				}else{
					$studentTmp['loginTime'] = '未登录';
				}
				$studentTmp['islogin'] = $v->islogin;

				$studentList[] = $studentTmp;
			}
		}

		$data['studentList'] = $studentList;
		$data['order'] = $order;
		$data['hasclass'] = $hasClass;
		$data['url']['add'] = '/'.$this->url_config['studentAdd'];
		$data['url']['download'] = '/index.php/student/download';
		$data['url']['upload'] = '/index.php/student/upload';
		if($order == 'la'){
			$data['url']['lUrl'] = '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=ld&grade='.$grade;
		}else{
			$data['url']['lUrl'] = '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=la&grade='.$grade;
		}

		if($order == 'ca'){
			$data['url']['cUrl'] = '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=cd&grade='.$grade;
		}else{
			$data['url']['cUrl'] = '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order=ca&grade='.$grade;
		}

		$operation_data =new Operation_data(); 
		$operation_data->base_url = '/'.$this->url_config['studentList'].'?keywords='.$search.'&hasclass='.$hasClass.'&order='.$order.'&grade='.$grade;
		$operation_data->total_rows = $data['studentNum'];
		$operation_data->per_page = $row;
		$operation_data->cur_page= $p;
		$data['page'] = $operation_data->show_page();

		$this->sm->view('student/index',$data);
	}

	/**
	 * Description : 学员详情页
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:45
	 */
	public function info(){
		$this->checklogin();
		safeFilter();
		$userid =(int) isset($_REQUEST['studentId'])?$this->input->get('studentId',true):0;
		$student = $this->student_model->getInfoById($userid,$_SESSION['institution']);
		if(!$student) {
			show_404('找不到此学生信息');exit;
		}
		$data['studentId'] = $student->id;
		$info['truthName'] = $student->truthName;
		$info['code'] = $student->code;
		$info['path'] = $student->path == ''?$this->common_public['default_avatar']['120']:$student->path;
		$info['studentCode'] = $student->studentCode?$student->studentCode:"-";
		$info['school'] = $student->school?$student->school:'-';
		$info['userName'] = $student->studentName;
		$info['gradeName'] = $student->gname;
		$info['sex'] = $student->sex == '' ? '-':($student->sex == '1'?'男':'女');
		$info['parentA'] = ($student->parent1ref?$student->parent1ref.'|':'').$student->parentTel1;
		if($student->parentName2 == '' and $student->parent2ref == ''){
			$info['parentB'] = '';
		}else{
			$info['parentB'] = ($student->parent2ref?$student->parent2ref.'|':'').$student->parentTel2;
		}
		$info['birthday'] = $student->birthDay == '' ? '-':$student->birthDay;
		$info['telphone'] = $student->telphone == '' ? '-':$student->telphone;
		$info['creatTime'] = substr($student->creatTime,0,10);

		$p = (isset($_GET['p']) && $_GET['p'] !='')?$_GET['p']:1;
		$row = 30;
		//$type:all、his、其他
		$type = isset($_GET['curr'])?$this->input->get('curr',true):'1';
		$data['type'] = $type;
		$class = $this->student_model->getAllClass($userid,$type,$p,$row);
		$total = $this->student_model->getClassNum($userid,$type)->num;
		$classTmp = array();
		$classIdlist = "";
		if($class){
			foreach($class as $k => $v){
				$classTmp[$v->classId]['className'] = $v->className;
				$classTmp[$v->classId]['classId'] = $v->classId;
				$classTmp[$v->classId]['classUrl'] = '/'.$this->url_config['classInfo'].'?classId='.$v->classId;
				$classTmp[$v->classId]['beginTime'] = $v->beginTime?substr($v->beginTime,0,10):"未知";
				$classTmp[$v->classId]['endTime'] = $v->endTime?substr($v->endTime,0,10):"未知";
				$classTmp[$v->classId]['joinTime'] = $v->joinTime?substr($v->joinTime,0,10):"未知";
				$classTmp[$v->classId]['current'] = $v->current;
				$classIdlist .= $v->classId.",";
			}
			if(trim($classIdlist)){
				$teacherList = $this->class_model->getTeacherbyClassList(trim($classIdlist,','));
				if($teacherList){
					foreach ($classTmp as $key => $val) {
						$classTmp[$key]['teacher'] = "";
						$i = 0;
						foreach ($teacherList as $keys => $vals) {
							if($vals->classId==$val['classId']){
								$classTmp[$key]['teacher'][$i]['teacherUrl'] = '/'.$this->url_config['teacherInfo']."?teacherId=".$vals->teacherId;
								$classTmp[$key]['teacher'][$i]['truthName'] = $vals->truthName;
								if($vals->nickname!=''){
									$classTmp[$key]['teacher'][$i]['truthName'] .= "(".$vals->nickname.")";
								}
								$i++;
							}
						}
						$classTmp[$key]['teacherCount'] = $i;
					}
				}
			}
		}

		$data['totalNum'] = $this->student_model->getClassNum($userid,$type)->num;
		$data['classId'] = '';
		$data['class'] = $classTmp;
		$data['url']['modify'] = '/'.$this->url_config['studentModify'].'?studentId='.$student->id;
		$data['url']['reset'] = '/'.$this->url_config['studentReset'].'?studentId='.$student->id;
		$data['url']['curr'] = '/'.$this->url_config['studentInfo'].'?studentId='.$student->id.'&curr=1';
		$data['url']['teacher'] = '/'.$this->url_config['teacherInfo'].'?teacherId=';
		$data['url']['his'] = '/'.$this->url_config['studentInfo'].'?studentId='.$student->id.'&curr=0';
		$data['url']['all'] = '/'.$this->url_config['studentInfo'].'?studentId='.$student->id.'&curr=all';
		$data['url']['leave'] = '/index.php/student/leaveclass';

		$operation_data =new Operation_data(); 
		$operation_data->base_url = '/'.$this->url_config['studentInfo'].'?studentId='.$student->id.'&curr='.$type;
		$operation_data->total_rows = $total;
		$operation_data->per_page = $row;
		$operation_data->cur_page= $p;
		$data['page'] = $operation_data->show_page();

		$data['info'] = $info;

		//获取机构年级列表
		$gradelist= $this->grade_model->getlist();
		foreach ($gradelist as $key => $val) {
			$gradeList[$key]['gradeId'] = $val->id;
			$gradeList[$key]['gradeName'] = $val->name;
		}
		$data['gradelist'] = $gradeList;
		//获取机构学科列表
		$subjectlist = $this->subject_model->getlist();
		foreach ($subjectlist as $key => $val) {
			$subject[$key]['subjectId']  = $val->id;
			$subject[$key]['subjectName']  = $val->name;
		}
		$data['subjectlist'] = $subject;

		$this->sm->view('student/info',$data);
	}

	/**
	 * Description : 获取录入学员成功后跳转页
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:45
	 */
	public function addsucc(){
		$this->checklogin();
		$studentId = (int)(isset($_GET['id'])?$_GET['id']:'0'); 
		$student = $this->student_model->existById($_SESSION['institution'],$studentId);
		if(! $student) show_404();
		$this->config->load('public'); 
		$studentInfoConfig = $this->config->item('common_public');
		$pass = $studentInfoConfig['studentInfo']['initPass'];
		$data['continue'] = '/'.$this->url_config['studentAdd'];
		$data['addClass'] = '/'.$this->url_config['studentInfo'].'?studentId='.$studentId;
		$data['all'] = '/'.$this->url_config['studentList'];	
		$data['parent'] = $student->parentName1;
		$data['ref'] = $student->parent1ref;
		$data['title'] = '录入学员成功';
		$data['student'] = $student->studentName;
		$data['pass'] = $pass;
		$this->sm->view('student/success',$data);
	}

	/**
	 * Description : 重置学员密码
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:46
	 */
	public function resetpwd(){
		$this->ajaxChecklogin();
		safeFilter();
		$this->config->load('public'); 
		$studentInfoConfig = $this->config->item('common_public');
		$pass = $studentInfoConfig['studentInfo']['initPass'];
		$password = md5($studentInfoConfig['studentInfo']['initPass']);
		$userid =(int) isset($_REQUEST['studentId'])?$this->input->get('studentId',true):0;
		if($this->student_model->resetpwd($_SESSION['institution'],$userid,$password)){
			$code = $this->db->query('select code from Student where id ='.$userid)->row()->code;
			$postData = array('code'=>$code,'password'=>$password);
			$data['oldres']= $this->modifyOldPwd($postData);
			echojson(1,$data,"已将密码重置为".$pass);
		}else{
			echojson(0,'','重置失败');
		}
	}

	/**
	 * Description : 将学员加入新班级
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:46
	 */
	public function newclass(){
		$this->ajaxChecklogin();
		safeFilter();
		$userid =(int) (isset($_REQUEST['id'])?$this->input->get('id',true):0);
		$student = $this->student_model->getInfoById($userid,$_SESSION['institution']);
		if(! $student) echojson (0,'','没有此学员信息');
	}

	/**
	 * Description : 上传学员列表
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:47
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
		$data['upUrl'] = DOMAIN.'index.php/student/doupload';
		//$data['nextUrl'] = DOMAIN.'index.php/student/uploadstatus?step='.$data['step'];
		$this->sm->view('student/upload',$data);
	}

	/**
	 * Description :  对上传进行简单处理（文件类型、上传结果等）
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:47
	 */
	public function doupload(){
		$this->checklogin();
		$this->config->load('uploads');		
		$config = $this->config->item("student");
		$this->load->library('upload');
		$_FILES['userfile'] = $_FILES['UpLoadFile'];
		$is_upload = $this->upload->upload_file($config);
		//echo $this->upload->display_errors();exit;
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
		$url = '/'.$this->url_config['studentUpload'].'?&step='.$step.'&status='.$status.$fileMd5Para.'&isup=1';
		header("Location:".$url);exit; 
	}


	/**
	 * Description : 获取文件上传反馈错误信息
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:48
	 */
	public function uploadstatus(){
		$this->ajaxChecklogin();
		$status = (isset($_REQUEST['status'])&&$_REQUEST['status']!="")?$_REQUEST['status']:'0';
		$fileMd5= (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:'';

		if($status=='0'){
			echojson(0,"",'上传失败,文件格式与模版文件不符');
		}

		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$sourcefile = $config['upload_path'].$fileMd5.".xlsx";
		//var_dump($sourcefile);exit;
		if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
		loadLib("excel/PHPExcel");
		loadLib("excel/PHPExcel/IOFactory");
		$type = 'Excel2007';
		$xlsreader = phpexcel_iofactory::createReader($type);
		$objphpexcel = phpexcel_iofactory::load($sourcefile);
		$objworksheet = $objphpexcel->getactivesheet();
		$xlsreader->setreaddataonly(true);
		$xlsreader->setloadsheetsonly(true);
		$sheets = $xlsreader->load($sourcefile);
		$objsheets = $sheets->getsheet(0);
		$highestrow = $objsheets->gethighestrow(); //行数
		//根据classid获取总课节数并判断行数与模版行数是否相同
		$highestColumn = $objsheets->gethighestcolumn(); //取得总列 
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
		if($highestColumn != 'J') echojson(0,'','模板格式不对，请下载标准模板');
		$excelDate = array();
		for($row = 2;$row <= $highestrow;$row++){
			for($col = 0;$col < $highestColumnIndex;$col++){
				$excelDate[$row][$col] = trim(strval($objworksheet->getCellByColumnAndRow($col,$row)->getValue()));
			}
		}
		foreach($excelDate as $k => $v){
			$tempRow = array_filter($v);
			if(!$tempRow) unset($excelDate[$k]);
		}
		$totalNum = count($excelDate);
		if(!$totalNum) echojson(0,'','所上传的文件学生信息为空');
		$titles = array();//记录标题
		//判断标题及顺序
		for($i=0;$i<$highestColumnIndex;$i++){
			$titles[] = strval($objworksheet->getCellByColumnAndRow($i,1)->getvalue());
		}
		$student_config = $this->config->item("titles");		
		$schedulecolumn_config = $this->config->item("scheduleFileColumn");		
		if($student_config != $titles) echojson(0,"",'首行标题与模版文件不符,请下载标准模板');
		$url = '/index.php/student/uploadstep1?fileMd5='.$fileMd5;
		//header('Location:'.$url);
		$data['url'] = $url;
		echojson(1,$data,'上传成功');
	}

	/**
	 * Description : 上传信息是否通过判断
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:48
	 */
	public function uploadstep1(){
		$this->checklogin();
		$data['title'] = "上传学员信息表";
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
		if($fileMd5==""){
			$data['fileMd5'] = "";
		}else{
			$data['fileMd5'] = $fileMd5;
		}
		$data['url']['enter'] = '/'.$this->url_config['studentUploadEnter'].'?fileMd5='.$fileMd5;
		$data['url']['back'] = '/'.$this->url_config['studentUpload'];
		$data['fileMd5'] = $fileMd5;
		$this->sm->view('student/check',$data); 
	}

	/**
	 * Description : 检测错误问题，并进行问题反馈
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:48
	 */
	public function  checkStep2(){
		$this->ajaxChecklogin();
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:echojson(0,'','异常操作');
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$sourcefile = $config['upload_path'].$fileMd5.".xlsx";
		//var_dump($sourcefile);exit;
		if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
		$data = $this->checkdata($fileMd5);
		$tmpData['errNum'] = $data['excelErr'];
		$tmpData['err'] = $data['err'];
		$tmpData['total'] = $data['total'];
		$tmpData['isAllowInsert'] = $data['continue'];
		$tmpData['normal'] = $data['total']-$data['excelErr'];
		$tmpData['url']['next'] = '/'.$this->url_config['studentUploadEnter'].'?fileMd5='.$fileMd5;
		$data['url']['back'] = '/'.$this->url_config['studentUpload'];
		$tmpData['page'] = $data['page'];
		if($data['continue']==false){
			echojson(0,$tmpData,'有错误信息不能上传');
		}else{
			echojson(1,$tmpData);
		}
	}

	/**
	 * Description : 检测数据的有效性
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:24
	 */
	public function checkdata($fileName){
		$this->ajaxChecklogin();
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
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
		$stu = array();//存储已经加载的学员家长的电话和学员姓名
		$stuName = array();//存储已经加载的学员家长的电话和学员姓名
		for($row = 2;$row<= $highestRow;$row++){
			$tagthme = array();
			for($i=0;$i<$highestColumnIndex;$i++ ){
				//当前字段值
				$rowData = isset($excelDate[$row])?$excelDate[$row]:'';
				if($rowData){
					$value = $rowData[$i];
					switch ($i) {
					case '0':
						$column_name = "truthName";
						if(checkName($value)){
							if(in_array($value,$stuName)){
								$same_row = array_search($value,$stuName);
								$err[$row] = array('name'=>$value,'item'=>$column_name,'type'=>5,'row'=>$same_row);
							}
							if($this->student_model->existSameName($value,$_SESSION['institution'])){
								$err[$row] = array('name'=>$value,'item'=>$column_name,'type'=>4);
							}
							$stuName[$row] = $value;
						}else{
							$err[$row] = array('name'=>$value,'item'=>$column_name,'type'=>1);
						}
						break;
					case '1':
						$column_name = "grade";
						if(!$value){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
							break;
						}
						if($gradesInfo = $this->grade_model->getIdByName($value)){
							$value = $gradesInfo->id;
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						break;
					case '2':
						$column_name = "parentTel1";
						if(! checkTel($value)){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
							break;
						}
						$ifhas = $this->student_model->exist($res[$row-1]['truthName'],$value);
						$hasSameName = $this->student_model->existSameName($res[$row-1]['truthName']);
						if($ifhas){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>2);
							break;
						}
						foreach($stu as $v){
							if($v['tel'] == $value and $res[$row-1]['truthName'] ==$v['name'] ){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>3,'row' => $v['row']);
								break;
							}
						}
						$stu[]= array('name'=>$res[$row-1]['truthName'],'tel'=>$value,'row'=>$row);
						break;
					case '3':
						$column_name = "parent1ref";
						if(!($value == '父亲' || $value=="母亲" || $value =="其他" || $value == '')){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						break;
					case '4':
						$column_name = "parentTel2";
						if($value !='' &&  !checkTel($value)){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						break;
					case '5':
						$column_name = "parent2ref";
						if(!($value == '父亲' || $value=="母亲" || $value =="其他" || $value == '')){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						if($res[$row-1]['parentTel2'] == '' && $value != ''){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						break;
					case '6':
						$column_name = "studentCode";
						if(($value && $this->student_model->existSameCode($value,$_SESSION['institution'])) ||strlen(trim($value)) > 21){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						break;
					case '7':
						$column_name = "sex";
						if($value == '男'){
							$value = '1';
						}elseif($value=='女'){
							$value='0';
						}elseif($value == ''){
							$value = null;
						}else{
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}
						break;
					case '8':
						$column_name = "birthday";
						if(!$value){
							break;
						}
						if(! preg_match('/^\d{6}$/',$value)){
							$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						}else{
							$currentYear = date('Y',time());
							$year = substr($value,0,4);
							$month = substr($value,4,2);
							if(($year > $currentYear - 5 or $year < $currentYear - 22) or ($month > 12 or $month < 1)){
								$err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
							}else{
								$value = substr($value,0,4).'-'.substr($value,4,2);
							}
						}
						break;
					case '9':
						$column_name = "school";
						if(strlen(trim($value)) > 61) $err[$row] = array('name'=>$res[$row-1]['truthName'],'item'=>$column_name,'type'=>1);
						break;
					default :
						break;
					}
					$res[$row-1][$column_name] = $value;
				}
			}
		}
		$count = count($err);
		$data['excelErr']= count($err);
		$data['res'] = $res;
		$data['continue'] = true;
		$row = 10;
		$page =(int) isset($_REQUEST['p'])?$_REQUEST['p']:"1";
		if($page == 'undefined') $page = '1';
		if(isset($err)){
			foreach($err as $k=>$v){
				if($v['type'] == 1 or $v['type'] == 2 or $v['type'] == 3){
					$data['continue'] = false;
					break;
				}
			}
			$length = $row;
			if($page*$row > $count) $length = $count%$row;
			$errPageArr = array_slice($err,($page-1)*$row,$length,true);	
			foreach($errPageArr as $k=>$v){
				if($v['type'] == '1'){
					$errPageArr[$k]['checkinfo'] = "不完整或信息无效";
				}elseif($v['type']=='3'){
					$errPageArr[$k]['checkinfo'] = "与第".$v['row']."行重复";
				}elseif($v['type']=='2'){
					$errPageArr[$k]['checkinfo'] = "与现有学员".$v['name']."重复|该学员已存在";
				}elseif($v['type'] =='4'){
					$errPageArr[$k]['checkinfo'] = "与现有学员".$v['name']."姓名重复|如果录入，将会生成一个新学员账号";
				}elseif($v['type'] == '5'){
					$errPageArr[$k]['checkinfo'] = "与第".$v['row']."行姓名重复|如果录入，将会分别生成一个学员账号";
				}
			}
		}
		$data['err'] = $errPageArr;
		$data['current_count']  = count($err);
		$operation_data =new Operation_data(); 
		$operation_data->base_url = "/index.php/student/checkStep2?fileMd5=".$fileMd5;
		$operation_data->total_rows = $count;
		$operation_data->per_page = $row;
		$operation_data->cur_page= $page;
		$data['page'] = $operation_data->show_page_ajax();
		return $data;
	}

	/**
	 * Description : 执行插入操作
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:25
	 */
	public function doinsert(){
		$this->ajaxChecklogin();
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$this->config->load('public'); 
		$studentInfoConfig = $this->config->item('common_public');
		$password = md5($studentInfoConfig['studentInfo']['initPass']);
		$sourcefile = $config['upload_path'].$fileMd5.".xlsx";
		if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
		$data = $this->checkdata($fileMd5);
		if((isset($data['continue']) && ($data['continue'] == false))){
			echojson(0,'','有错误信息不能上传');
		}
		$res = $data['res'];
		foreach($res as $k=>$v){
			$tableStudent[$k]['truthName'] = $v['truthName'];
			$tableStudent[$k]['password'] = $password;
			$tableStudent[$k]['grade'] = $v['grade'];
			$tableStudent[$k]['institution'] = $_SESSION['institution'];
			$tableStudent[$k]['studentCode'] = $v['studentCode'];
			$tableStudent[$k]['sex'] = $v['sex'];
			$tableStudent[$k]['school'] = $v['school'];
			$tableStudent[$k]['birthDay'] = $v['birthday'];
			$tableStudent[$k]['parentTel1'] = $v['parentTel1'];
			$tableStudent[$k]['parentTel2'] = $v['parentTel2'];
			$tableStudent[$k]['parent1ref'] = $v['parent1ref'];
			$tableStudent[$k]['parent2ref'] = $v['parent2ref'];
			$tableStudent[$k]['creatTime'] = date('Y-m-d H:i:s',time());
		}
		if($data['succNum'] = $this->student_model->uploadInsert($tableStudent,$_SESSION['institution'])){
			$_SESSION['succNum'] = $data['succNum'];
			$data['url'] = '/'.$this->url_config['studentEnterSucc'];
			echojson(1,$data,'录入成功');
		}else{
			echojson(0,'','录入失败');
		}

	}

	/**
	 * Description : 批量录入成功提示页
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:25
	 */
	public function enterSucc(){
		$this->checklogin();
		$data['title'] = '上传成功';
		$data['succNum'] = $_SESSION['succNum'];
		$this->sm->view('student/entersucc',$data);
	}

	/**
	 * Description : 下载学员信息表模板
	 * Author      : jishuai
	 * Created Time: 2014-11-28 13:26
	 */
	public function download(){
		$this->checklogin();
		ob_clean();
		$fileName = "学员信息表模板".date('Ymd',time()).'.xlsx';
		$file = $_SERVER['DOCUMENT_ROOT'].'/uploads/default/studentInfo.xlsx';
		sendFile($fileName,'',array('filepath'=>$file));
	}

	/**
	 * Description : 修改旧系统的密码
	 * Author      : jishuai
	 * Created Time: 2015-01-23 17:21
	 */
	private function modifyOldPwd ($data){
		$url = $this->post_config['modifyOldURL'].$this->post_config['modifyOldStu'];
		return curl_post_data($url,http_build_query($data));
	}
}
