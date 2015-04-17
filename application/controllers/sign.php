<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Sign extends OrgCenter_Controller{
	public function __construct(){
		parent::__construct();
		$this->checklogin();
		$this->load->model('sign_model');
		$this->sign = $this->sign_model;
		loadLib('Operation_data');
	}

	/**
	 * Description : 考勤首页
	 * Author      : jishuai
	 * Created Time: 2015-02-27 18:16
	 */
	public function index(){
		$res = $this->checkdata();
		if(!$res) exit('数据出错');
		foreach($res as $k => $v){
			$$k = $v;
		}
		$institution = $_SESSION['institution'];
		for($i = $currentYear;$i>2009;$i--){
			$optionSYear[] = $i;
		}
		for($i = 1;$i < 13;$i++){
			$optionSMonth[] = $i<10?'0'.$i:$i;
		}
		for($i = 1;$i <= $days;$i++){
			$optionSDay[] = $i<10?'0'.$i:$i;
		}
		for($i = 1;$i <= $days;$i++){
			$optionSDay[] = $i<10?'0'.$i:$i;
		}
		$page = (int) (isset($_REQUEST['p']) && $_REQUEST['p']?$_REQUEST['p']:'1');
		$row = 30;
		$res = $this->sign->getSignInfo($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId,$page,$row);
		$num = $this->sign->getSignNum($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId,$page,$row);
		$info = $this->sign->dataProcess($res);
		//var_dump($info);
		$operation_data =new Operation_data(); 
		$pageUrl = "/index.php/sign/getTmpData?syear=$syear&smonth=$smonth&sday=$sday&eyear=$eyear&emonth=$emonth&eday=$eday&issign=$issign&classType=$classType&classValue=$classValue&studentType=$studentType&studentValue=$studentValue";
		$operation_data->base_url = $pageUrl;
		$operation_data->total_rows = $num;
		$operation_data->per_page = $row;
		$operation_data->cur_page= $page;
        $data['page'] = $operation_data->show_page();
		$data['info'] = $info;
		$downloadUrl = '/index.php/sign/download';
		$menu_hover = 'sign';
		$title = '考勤和成绩';
		$data = get_defined_vars();
		$this->sm->view('sign/index',$data);
	}

	/**
	 * Description : 将考勤数据保存到excel表格
	 * Author      : jishuai
	 * Created Time: 2015-02-28 10:30
	 */
	public function downLoad(){
		loadLib('Dumpexcel');
		$this->config->load('uploads');

		safeFilter();
		$institution = $_SESSION['institution'];
		$res = $_SESSION['postData'];
		foreach($res as $k => $v){
			$$k = $v;
		}
		$res = $this->sign->getDownloadInfo($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId);
		$info = $this->sign->dataProcess($res);
		$data = $this->sign->dataExcel($info);
		$dump = new Dumpexcel();
		$dump->thead = $this->config->item('sign');
		$dump->content = $data;
		$uploadPath = $this->config->item('sign_path');

		$fileName = $syear.'.'.$smonth.'.'.$sday.'-'.$eyear.'.'.$emonth.'.'.$eday.'学生出勤和成绩表.xlsx';
		$dest = $uploadPath.$fileName;
		$dump->dataProcess();
		foreach($res as $k => $v){
			if($v->issign == '0') $dump->setColor($k+1,6,'FFFF0000');
		}
		$dump->createExcel($dest);
		sendFile($fileName,'',array('filepath'=>$dest));
	}


	/**
	 * Description : 检测接收的数据
	 * Author      : jishuai
	 * Created Time: 2015-03-03 09:25
	 */
	public function checkdata($type='ajax'){
		safeFilter();
		$currentYear = date('Y');
		$start = ''; $end = '';$syear = '';$smonth='';$sday='';$eyear = '';$emonth='';$eday='';
		if(isset($_REQUEST['syear']) && isset($_REQUEST['smonth']) && isset($_REQUEST['sday'])){
			if($_REQUEST['syear'] != '' && $_REQUEST['smonth'] != '' && $_REQUEST['sday'] != ''){
				$start = $_REQUEST['syear'].'-'.$_REQUEST['smonth'].'-'.$_REQUEST['sday'].' 00:00:00';
				$syear = intval($_REQUEST['syear']);
				$smonth = intval($_REQUEST['smonth']);
				$days = cal_days_in_month(CAL_GREGORIAN,$smonth,$syear);
				$sday = intval($_REQUEST['sday']);
			}
		}else{
			$start = date('Y-m-d').' 00:00:00';
			$syear = $currentYear;
			$smonth = date('m');
			$days = cal_days_in_month(CAL_GREGORIAN,$smonth,$syear);
			$sday = date('d');
		}
		if(isset($_REQUEST['eyear']) && isset($_REQUEST['emonth']) && isset($_REQUEST['eday'])){
			$end = $_REQUEST['eyear'].'-'.$_REQUEST['emonth'].'-'.$_REQUEST['eday'].' 23:59:59';
			$eyear = intval($_REQUEST['eyear']);
			$emonth = intval($_REQUEST['emonth']);
			$eday = intval($_REQUEST['eday']);
		}else{
			$end = date('Y-m-d').' 23:59:59';
			$eyear = $currentYear;
			$emonth = date('m');
			$eday = date('d');
		}
		$classType = isset($_REQUEST['classType'])?$_REQUEST['classType']:'';
		$studentType = isset($_REQUEST['studentType'])?$_REQUEST['studentType']:'';
		$classValue = isset($_REQUEST['classValue'])?$_REQUEST['classValue']:'';
		$studentValue = isset($_REQUEST['studentValue'])?$_REQUEST['studentValue']:'';
		if($classType == 'className'){
			$className = $classValue;
			$classCode = '';
		}else if($classType == 'classCode'){
			$classCode = $classValue;
			$className = '';
		}else{
			$classCode = '';
			$className = '';
		}
		if($studentType == 'studentName'){
			$studentName = $studentValue;
			$truthName = $studentValue;
			$studentId = '';
		}else if($studentType == 'studentId'){
			$studentId = $studentValue;
			$truthName = $studentName = '';
		}else{
			$studentId = '';
			$truthName = $studentName = '';
		}
		$issign = isset($_REQUEST['issign'])?$_REQUEST['issign']:2;
		if($type=='ajax'){
			if((! strtotime($start)) or (! strtotime($end))) echojson('0','','请选择完整的日期');
			if(strtotime($start) > strtotime($end)) echojson('0','','开始时间不能小于截止时间');
		}else{
			if((! strtotime($start)) or (! strtotime($end))) return false;
			if(strtotime($start) > strtotime($end)) return false;
		}
		$startTime = strtotime($start);
		$endTime = strtotime($end);
		$data = get_defined_vars();
		$_SESSION['postData'] = $data;
		return $data;
	}


	/**
	 * Description : 生成模板数据
	 * Author      : jishuai
	 * Created Time: 2015-03-03 09:25
	 */
	public function getTmpData(){
		$res = $this->checkdata('ajax');
		foreach($res as $k => $v){
			$$k = $v;
		}
		$institution = $_SESSION['institution'];
		$page = (int) (isset($_REQUEST['p']) && $_REQUEST['p']?$_REQUEST['p']:'1');
		$row = 30;
		//var_dump($res);exit;
		$res = $this->sign->getSignInfo($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId,$page,$row);
		//echo $this->db->last_query();
		$num = $this->sign->getSignNum($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId,$page,$row);
		$info = $this->sign->dataProcess($res);

		$operation_data =new Operation_data(); 
		$pageUrl = "/index.php/sign/getTmpData?syear=$syear&smonth=$smonth&sday=$sday&eyear=$eyear&emonth=$emonth&eday=$eday&issign=$issign&classType=$classType&classValue=$classValue&studentType=$studentType&studentValue=$studentValue";
		$operation_data->base_url = $pageUrl;
		$operation_data->total_rows = $num;
		$operation_data->per_page = $row;
		$operation_data->cur_page= $page;
        //$data['page'] = $operation_data->show_page_ajax();
        $data['page'] = $operation_data->show_page();

		$data['info'] = $info;
		echojson('1',$data,'');exit;
	}















}
