<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Student extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
		$this->load->model('student_model');
		$this->load->model('class_model');
        $this->ajaxChecklogin();
		loadlib('pin');
		$this->pin = new pin();
    }
    /**
 	* Description : 处理学生添加提交的数据
 	* Author      : jishuai
 	* Created Time: 2014-12-01 13:20
	*/
	public function add(){
        safeFilter();
		$data['truthName'] = (isset($_POST['truthName']) && $_POST['truthName'] != '')?trim($_POST['truthName']):echojson(0,'','请输入学员姓名');
		if(! checkName($data['truthName'])) echojson(0,'','请填写真实姓名');
		$sort = $this->pin->pinyin($data['truthName'],'UTF-8');
		$data['parentTel1'] = (isset($_POST['parentTel1']) && $_POST['parentTel1'] != '')?trim($_POST['parentTel1']):echojson(0,'','请输入手机号');
		//var_dump($data);exit;
		if(!checkTel($data['parentTel1'])) echojson(0,"","手机号格式错误");
		if(isset($_POST['parent1ref']) && $_POST['parent1ref'] != ''){
			$data['parent1ref'] = trim($_POST['parent1ref']);
			if(! in_array($data['parent1ref'],array('父亲','母亲','其他'))) echojson(0,'','异常操作');
		}else{
			$data['parent1ref'] = '';
		}
		if(isset($_POST['parent2ref']) && $_POST['parent2ref'] != ''){
			$data['parent2ref'] = trim($_POST['parent2ref']);
			if(! in_array($data['parent2ref'],array('父亲','母亲','其他'))) echojson(0,'','异常操作');
		}else{
			$data['parent2ref'] = '';
		}
		if(isset($_POST['parentTel2']) && $_POST['parentTel2'] != ''){
			$data['parentTel2'] = trim($_POST['parentTel2']);
			if(!checkTel($data['parentTel2'])) echojson(0,"","家长B手机号格式错误");
		}else{
			$data['parentTel2'] = '';
		}
		$data['sex'] = (isset($_POST['sex']) && in_array($_POST['sex'],array('1','0')))?$_POST['sex']:null;
		$birthday['year'] =  isset($_POST['year'])?$_POST['year']:'';
		$birthday['month'] =  isset($_POST['month'])?$_POST['month']:'';
		$data['birthday'] = '';
		$currentYear = date('Y',time());
		if($birthday['year'] != '' and $birthday['year'] and $birthday['month'] != ''){
			if($birthday['year'] > $currentYear - 5 || $birthday['year'] < $currentYear - 22 || $birthday['month'] > 12 || $birthday['month'] < 1 ) echojson(0,'','日期选择异常');
			$data['birthday'] = $birthday['year'].'-'.$birthday['month'];
		}
        $this->config->load('public'); 
		$studentInfoConfig = $this->config->item('common_public');
		$password = md5($studentInfoConfig['studentInfo']['initPass']);
		$data['password'] = $password;
		$data['school'] = strlen(isset($_POST['school'])?trim($_POST['school']):'') < 61?trim($_POST['school']):echojson(0,'','学校名称过长') ;
		$data['studentCode'] = strlen(isset($_POST['schoolCode'])?trim($_POST['schoolCode']):'') < 20?trim($_POST['schoolCode']):echojson(0,'','原学号过长') ;
		if($data['studentCode'] != '' and $this->student_model->existSameCode($data['studentCode'],$_SESSION['institution']))
			echojson(0,'','与已有学员的原学号重复');
		$data['grade'] = (int) (isset($_POST['grade']) and $_POST['grade'] != '')?$_POST['grade']:echojson(0,'','请选择年级');
		$data['studentName'] = $this->student_model->getUniqueNameBySort($sort);
		$ifhas1 = $this->student_model->exist($data['truthName'],$data['parentTel1']);
		if($ifhas1){
			if($ifhas1[0]->parentTel1 == $data['parentTel1']){
				$hasStudent['parent'] = '家长A：'.$data['parentTel1'];
				$hasStudent['student'] = '学员：'.$ifhas1[0]->truthName;
			}
			echojson(0,'','该学员已录入');
		}
		/*
		if(isset($_POST['parentTel2']) and $_POST['parentTel2'] !=''){
			$ifhas2 = $this->student_model->exist($data['truthName'],$data['parentTel2']);
			if($ifhas2){
				if($ifhas2[0]->parentTel1 == $data['parentTel2']){
					$hasStudent['parent'] = '家长A：'.$data['parentName1'];
					$hasStudent['student'] = '学员：'.$ifhas2[0]->truthName;
				}else{
					$hasStudent['parent'] = '家长B:'.$data['parentName2'];
					$hasStudent['student'] = '学员：'.$ifhas2[0]->truthName;
				}
				echojson(0,'','该学员已录入');
			}
		}
		 */
		if($data['parent2ref'] != '' and $data['parentTel2'] == '') echojson(0,'','请补全家长B信息');
		$data['institution'] = $_SESSION['institution'];
		$data['creatTime'] = date('Y-m-d H:i:s',time());
		$res = $this->student_model->insert($data);
		$studentCurrent = $this->student_model->getIdByInfo($data['truthName'],$data['parentTel1']);
		$id = $studentCurrent->id;
		if($res){
            $this->db->where('id',$id);
            $this->db->update('Student', array('code'=>objEncode($id,'S')));
			$return['url'] = "/index.php/student/addsucc?id=$id";
			$return['parent'] = "家长A(".$data['parent1ref'].$data['parentTel1'].")手机号";
			$return['studentId'] = $id;
			echojson(1,$return,'录入成功');
		}else{
			echojson(0,'','录入失败');
		}
	}

    /**
 	* Description : 处理学生修改提交的数据
 	* Author      : jishuai
 	* Created Time: 2014-12-01 13:21
	*/
	public function modify(){
        safeFilter();
		$studentId =(int) isset($_REQUEST['studentId'])?$_REQUEST['studentId']:'0';
		if(! $this->student_model->existById($_SESSION['institution'],$studentId)) echojson('0','','不存在此学生');
		$data['truthName'] = (isset($_POST['truthName']) && $_POST['truthName'] != '')?trim($_POST['truthName']):echojson(0,'','请输入学员姓名');
		if(! checkName($data['truthName'])) echojson(0,'','请填写真实姓名');
		$data['parentTel1'] = (isset($_POST['parentTel1']) && $_POST['parentTel1'] != '')?trim($_POST['parentTel1']):echojson(0,'','请输入手机号');
		if(!checkTel($data['parentTel1'])) echojson(0,"","手机号格式错误");
		if(isset($_POST['parent1ref']) && $_POST['parent1ref'] != ''){
			$data['parent1ref'] = trim($_POST['parent1ref']);
			if(! in_array($data['parent1ref'],array('父亲','母亲','其他'))) echojson(0,'','异常操作');
		}else{
			$data['parent1ref'] = '';
		}
		if(isset($_POST['parent2ref']) && $_POST['parent2ref'] != ''){
			$data['parent2ref'] = trim($_POST['parent2ref']);
			if(! in_array($data['parent2ref'],array('父亲','母亲','其他'))) echojson(0,'','异常操作');
		}else{
			$data['parent2ref'] = '';
		}
		if(isset($_POST['parentTel2']) && $_POST['parentTel2'] != ''){
			$data['parentTel2'] = trim($_POST['parentTel2']);
			if(!checkTel($data['parentTel2'])) echojson(0,"","家长B手机号格式错误");
		}else{
			$data['parentTel2'] = '';
		}
		if($data['parent2ref'] != '' && $data['parentTel2'] == '') echojson('0','','请填写完整家长B信息');
		$data['sex'] = (isset($_POST['sex']) && in_array($_POST['sex'],array('1','0')))?$_POST['sex']:'';
		$birthday['year'] =  isset($_POST['year'])?$_POST['year']:'';
		$birthday['month'] =  isset($_POST['month'])?$_POST['month']:'';
		$data['birthday'] = '';
		if($birthday['year'] != '' and $birthday['month'] != ''){
			$currentYear = date('Y',time());
			if($birthday['year'] > $currentYear - 5 || $birthday['year'] < $currentYear - 22 || $birthday['month'] > 12 || $birthday['month'] < 1 ) echojson(0,'','日期选择异常');
			$data['birthday'] = $birthday['year'].'-'.$birthday['month'];
		}	
		$data['school'] = strlen(isset($_POST['school'])?trim($_POST['school']):'') < 61?trim($_POST['school']):echojson(0,'','学校名称过长') ;
		$data['studentCode'] = strlen(isset($_POST['schoolCode'])?trim($_POST['schoolCode']):'') < 20?trim($_POST['schoolCode']):echojson(0,'','原学号过长') ;
		if($data['studentCode'] != '' and $this->student_model->existSameCode($data['studentCode'],$_SESSION['institution'],$studentId)) echojson(0,'','与已有学员的原学号重复');
		$data['grade'] = (int) (isset($_POST['grade']) and $_POST['grade'] != '')?$_POST['grade']:echojson(0,'','请选择年级');
		
		$ifhas1 = $this->student_model->exist($data['truthName'],$data['parentTel1'],$studentId);
		if($ifhas1 && $ifhas1[0]->parentTel1 == $data['parentTel1']){
			$hasStudent['student'] = '学员：'.$ifhas1[0]->truthName;
			echojson(0,'','该学员已录入');
		}
		$data['institution'] = $_SESSION['institution'];
        $this->db->where('id',$studentId);
		$res = $this->db->update('Student',$data);

		if($res){
			$return['infoUrl'] = '/'.$this->url_config['studentInfo'].'?studentId='.$studentId;
			$return['allUrl'] = '/'.$this->url_config['studentList'];
			echojson(3,$return,'修改成功');
		}else{
			echojson(0,'','修改失败');
		}
	}

    /**
 	* Description : 查询学员编号是否存在
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:11
	*/
	public function checkcode(){
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:'';
		if(! $code){ echo 1;exit; }	
		$res = $this->student_model->isCodeExist($_SESSION['institution'],$code);
		echo $res?1:0;
	}

    /**
 	* Description : 学员退班
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:11
	*/
	public function leaveClass(){
        safeFilter();
		$userid = (int) isset($_POST['studentId'])?$_POST['studentId']:echojson(0,'','异常操作');
		$classid = (int) isset($_POST['classId'])?$_POST['classId']:echojson(0,'','异常操作');
		if(! $this->student_model->existById($_SESSION['institution'],$userid)) echojson(0,'','异常操作'); 
		if(! $this->class_model->existById($_SESSION['institution'],$classid)) echojson(0,'','异常操作');
		if($data = $this->student_model->leaveClass($_SESSION['institution'],$userid,$classid)) echojson (1,'','退班成功');
	}
}
