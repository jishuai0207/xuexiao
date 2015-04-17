<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class  Orgclass extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->checklogin();
        $this->load->model("subject_model");
        $this->load->model("grade_model");
        $this->load->model("student_model");
        $this->load->model("class_model");
        $this->load->model("classtype_model");
        $this->load->model("institution_classtype_model");
        $this->config->load('public');
        $this->sm->assign('menu_hover',$this->left_menu_config['class']);
        loadLib('Operation_data');
    }
    /**
     *description:班级列表页
     *author:yanyalong
     *date:2014/11/04
     */
    public function index(){
        $page = (isset($_REQUEST['p'])&&$_REQUEST['p']!='')?$_REQUEST['p']:'1';
        $teacherId = isset($_REQUEST['teacherId'])?$_REQUEST['teacherId']:"";
        $gradeId = isset($_REQUEST['gradeId'])?$_REQUEST['gradeId']:"";
        $classTypeCode = isset($_REQUEST['classTypeCode'])?$_REQUEST['classTypeCode']:"";
        $classTypePeriod = isset($_REQUEST['classTypePeriod'])?$_REQUEST['classTypePeriod']:"";
        $isEnd = (isset($_REQUEST['isEnd'])&&$_REQUEST['isEnd']!='')?$_REQUEST['isEnd']:"0";
        $keywords= (isset($_REQUEST['keywords'])&&$_REQUEST['keywords']!='')?$_REQUEST['keywords']:"";
        $data['searchFlag']= true;
        if(empty($_REQUEST)){
            $data['searchFlag']= false;
        }
        if($keywords!=""){
            $isEnd = "2";
        }
        $data['ctId'] = (isset($_REQUEST['ctId'])&&$_REQUEST['ctId']!='')?$_REQUEST['ctId']:'';
        $public_config = $this->config->item('common_public');
        $data['_classTypeCode'] = $classTypeCode;
        $data['_classTypePeriod'] = $classTypePeriod;
        $data['classTypePeriodList'] = $public_config['classTypePeriod'];
        $data['ClassTypeInfo'] = "";
        if($data['ctId']!=''){
            $classTypeInfo = $this->institution_classtype_model->getInfoByCTIns($_SESSION['institution'],$data['ctId']);
            if($classTypeInfo!=false){
				$classTypeName = $classTypeInfo->classTypeName?$classTypeInfo->classTypeName:$classTypeInfo->name;
                if($isEnd=='1')
                    $data['ClassTypeInfo'] = $classTypeName."-".$data['classTypePeriodList'][$classTypeInfo->period].'的历史班级';
                elseif($isEnd=='0'){
                    $data['ClassTypeInfo'] = $classTypeName.$data['classTypePeriodList'][$classTypeInfo->period].'的当前班级';
                }
                $data['_classTypeCode'] = $classTypeInfo->code;
                $data['_classTypePeriod'] = $classTypeInfo->period;
                $classTypePeriod = $classTypeInfo->period;
                $classTypeCode = $classTypeInfo->code;
            }
        }
        $classTypePeriodArr = array();
        foreach ($data['classTypePeriodList'] as $key => $val) {
            $classTypePeriodArr[$key]['periodName'] = $val;
            $classTypePeriodArr[$key]['isselect'] = '0';
            if(isset($data['_classTypePeriod'])&&$data['_classTypePeriod']==$key) {
                $classTypePeriodArr[$key]['isselect'] = '1';
            }
        }
        $data['classTypePeriodArr']  = $classTypePeriodArr;
        //隐藏域赋值
        $data['_p'] = $page;
        $data['_teacher'] = $teacherId;
        $data['_gradeId']= $gradeId;
        $data['_isEnd'] = $isEnd; 
        $data['_keywords'] = $keywords;
        $row = 30;
        $data['createClass'] = "/".$this->url_config['classCreate'];
        $data['title'] = "班级列表";
        $gradelist = $this->grade_model->getlist();
        foreach ($gradelist as $key => $val) {
            $grade[$key]['grade_id']  = $val->id;
            $grade[$key]['grade_name']  = $val->name;
            $grade[$key]['isselect']  = '0';
            if($gradeId==$val->id){
                $grade[$key]['isselect']  = '1';
            }
        }
        $data['grade'] = $grade;
        $teacherList= $this->class_model->getTeacherListByInstitution($_SESSION['institution']);
        $teacher = array();
        foreach ($teacherList as $key => $val) {
            $teacher[$key]['teacherId']  = $val->id;
            $teacher[$key]['truthName']  = $val->truthName;
            $teacher[$key]['isselect']  = '0';
            if($teacherId==$val->id){
                $teacher[$key]['isselect']  = '1';
            }
        }
        $data['teacher'] = $teacher;
        $classTypelist = $this->classtype_model->getlist($_SESSION['institution']);
        if($classTypelist){
            foreach ($classTypelist as $key => $val) {
                $classType[$key]['classTypeName']  = $val->classTypeName?$val->classTypeName:$val->name;
                $classType[$key]['classTypeCode']  = $val->code;
                if($data['_classTypeCode']!=""&&$data['_classTypeCode']==$val->code){
                    $classType[$key]['isselect']  = '1';
                }else{
                    $classType[$key]['isselect']  = '0';
                }
            }
        }else{
            $classType = "";
        }
        $data['classTypeCodeList'] = $classType;
        //查询班级列表信息
        $whereIsEnd = $isEnd;
        if($isEnd=='2') $whereIsEnd = "";
        $res = $this->class_model->getlistByInstitution($_SESSION['institution'],$teacherId,$gradeId,$classTypeCode,$classTypePeriod,'',$whereIsEnd,trim($keywords),$page,$row);
		//var_dump($res);exit;
        if($res==false){
            $data['count']= 0;
            $data['classlist'] = false;
        }else{
            $data['count'] = $res['count'];
            $list = $res['classlist'];
            $classIdList = "";
            foreach ($list as $key => $val) {
                $classIdList.= $val['classId'].","; 
            }
            $alllessonnumList = array();
			$lessonKeys = array();
            $alllessonnumList = $this->class_model->getReadyLessonNumByClass(trim($classIdList,','));
            foreach ($alllessonnumList as $k => $v) {
                $lessonKeys[$v->classId] = $v->readyLessonNum;
            }
			$loginNumArr = array();
            $loginNumArr = $this->class_model->getloginNumByClassList(trim($classIdList,','));
			foreach($loginNumArr as $k => $v){
				$loginArr[$v['classId']] = $v['loginNum'];
			}
            foreach ($list as $key => $val) {
                foreach ($lessonKeys as $keys=> $vals) {
                    if($val['classId']==$keys){
                        $list[$key]['readyLessonNum'] = $vals;
                    }
                }
            }
            foreach ($list as $key => $val) {
				if(isset($loginArr[$val['classId']])){
					$list[$key]['loginNum'] = $loginArr[$val['classId']];
				}else{
					$list[$key]['loginNum'] = '0';
				}
				$list[$key]['createTime'] = substr($val['createTime'],0,10);
            }
            $teacherList = $this->class_model->getTeacherbyClassList(trim($classIdList,','));
            foreach ($list as $key => $val) {
                if(!isset($val['readyLessonNum'])){
                    $list[$key]['readyLessonNum'] = 0;
                }
                $list[$key]['classCode'] = $val['classCode'];
                $list[$key]['classTypeName'] = $val['customName']?$val['customName']:$val['classTypeName'];
                $list[$key]['classUrl'] = "/".$this->url_config['classInfo']."?classId=".$val['classId'];
                if($val['ClassStatus']=='0'){
                    $list[$key]['classEndStatus']  = "未结课";
                }else{
                    $list[$key]['classEndStatus']  = "已结课";
                }
                $list[$key]['periodTitle']  = $this->common_public['classTypePeriod'][$val['period']];
                $list[$key]['teacher'] = "";
                if($teacherList!=false){
                    foreach ($teacherList as $keys => $vals) {
                        if($vals->classId==$val['classId']&&$vals->truthName!=null){
                            $list[$key]['teacher'] .= $vals->truthName;
                            if($vals->nickname!=''&&$vals->nickname!=$vals->truthName){
                                $list[$key]['teacher'] .= "(".$vals->nickname.")";
                            }
                            $list[$key]['teacher'] .= "<br>";
                        }
                    }
                    $list[$key]['teacher'] = trim($list[$key]['teacher'],'<br>');
                }
                if($list[$key]['teacher']==""){
                    $list[$key]['teacher'] = "无";
                }
            }
            $data['classlist'] = $list;
        }
		//var_dump($list);exit;
        $data['pageType'] = '';
        $operation_data =new Operation_data(); 
        $pageUrl = '/'.$this->url_config['classList'].'?teacherId='.$teacherId.'&gradeId='.$gradeId.'&classTypeCode='.$classTypeCode.'&classTypePeriod='.$classTypePeriod.'&isEnd='.$isEnd.'&keywords='.$keywords;
        $operation_data->base_url = $pageUrl;
        $operation_data->total_rows = $data['count'];
        $operation_data->per_page = $row;
        $operation_data->cur_page= $page;
        $data['page'] = $operation_data->show_page();
        $this->sm->view('orgclass/index',$data);  
    }
    /**
     *description:创建班级
     *author:yanyalong
     *date:2014/11/04
     */
    public function create(){
        $subjectlist = $this->subject_model->getlist();
        $gradelist = $this->grade_model->getlist();
        foreach ($subjectlist as $key => $val) {
            $subject[$key]['subjectId']  = $val->id;
            $subject[$key]['subjectName']  = $val->name;
        }
        foreach ($gradelist as $key => $val) {
            $grade[$key]['gradeId']  = $val->id;
            $grade[$key]['gradeName']  = $val->name;
        }
        $data['subject'] = $subject;
        $data['grade'] = $grade;
        //获取班型
        $classTypelist = $this->classtype_model->getlist($_SESSION['institution']);
        $data['classType'] = $classTypelist;
        $data['title'] = "创建班级";
        $this->sm->view('orgclass/create',$data);  
    }
    /**
     *description:创建班级成功页
     *author:yanyalong
     *date:2014/11/06
     */
    public function createsuccess(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $data['title'] = "创建班级-创建成功";
        $data['addStudentUrl'] = '/'.$this->url_config['classInfo']."?classId=".$classId;
        $data['classinfourl'] = '/'.$this->url_config['classInfo']."?classId=".$classId."&pageType=schedule";
        $this->sm->view('orgclass/createsuccess',$data);  
    }
    /**
     *description:班级详情页
     *author:yanyalong
     *date:2014/11/04
     */
    public function info(){
        $data['pageType'] = (isset($_REQUEST['pageType'])&&(in_array($_REQUEST['pageType'],array('student','schedule'))))?$_REQUEST['pageType']:"student";
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        if(intval($classId)==""){
            header("Location:/".$this->url_config['classList']);exit;
        }
        $data['title'] = "班级详情";
        $classInfo = $this->class_model->getClassInfoByInst($classId,$_SESSION['institution']);
        $loginInfo = $this->class_model-> getStudentStatByClassId($classId);
		$classInfo->stuLogNum = $loginInfo->loginNum;
        if($classInfo==false||$classInfo->status=='2'){
            show_404('不存在的班级');exit;
        }
		if($classInfo->semester == null){
			$day = $classInfo->shoukeDay;
			switch ($day){
				case 1: $day='星期一'; break;
				case 2: $day='星期二'; break;
				case 3: $day='星期三'; break;
				case 4: $day='星期四'; break;
				case 5: $day='星期五'; break;
				case 6: $day='星期六'; break;
				case 7: $day='星期日'; break;
				default: $day='未知'; break;
			}
		}else{
			$day = $classInfo->semester;
			switch ($day){
				case 0: $day='第零期'; break;
				case 1: $day='第一期'; break;
				case 2: $day='第二期'; break;
				case 3: $day='第三期'; break;
				case 4: $day='第四期'; break;
				case 5: $day='第五期'; break;
				case 6: $day='第六期'; break;
				default: $day='未知'; break;
			}
		}
		$info['day'] = $day;
		$info['beginTimeSlot'] = substr($classInfo->beginTimeSlot,0,5);
		$info['id'] = $classInfo->classId;
		$info['endTimeSlot'] = substr($classInfo->endTimeSlot,0,5);
        $info['classCode'] = $classInfo->classCode;
        $info['className'] = $classInfo->className;
        $info['classNumber'] = $classInfo->classNumber;
        $info['studentNumber'] = $classInfo->studentNumber;
        $info['readyScheduleNum'] = $classInfo->readyScheduleNum;
        $info['noScheduleNum'] = $classInfo->classNumber-$classInfo->readyScheduleNum;
        $info['stuLogNum'] = $classInfo->stuLogNum;
        $info['beginTime'] = (strtotime($classInfo->beginTime)!='0')?$classInfo->beginTime:"未知";
        $info['endTime'] = (strtotime($classInfo->endTime)!='0')?$classInfo->endTime:"未知";
        $info['gradeName'] = $classInfo->gradeName;
        $info['subjectName'] = $classInfo->subjectName;
        $info['createTime'] = $classInfo->createTime;
        $info['classTypeName'] = $classInfo->customName?$classInfo->customName:$classInfo->classTypeName;
        $info['place'] = $classInfo->place;
        $public_config = $this->config->item('common_public');
        $info['classTypePeriodName'] = $public_config['classTypePeriod'][$classInfo->period];
        $info['classStatus'] = $classInfo->ClassStatus;
        $info['classStatusDesc'] = "未结课";
        if($classInfo->ClassStatus=='1') $info['classStatusDesc'] = "已结课";
        //获取班级已排课数
        $data['info'] = $info; 
        //获取任课老师列表数据
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        foreach ($teacherList as $key => $val) {
            $teacherList[$key]->teacherUrl = '/'.$this->url_config['teacherInfo']."?teacherId=".$val->teacherId;
            $teacherList[$key]->truthName = $val->truthName;
            $teacherList[$key]->truthName .= ($val->nickname!=""&&$val->nickname!=$val->truthName)?"(".$val->nickname.")":"";
            $teacherList[$key]->secheduleNum = $val->secheduleNum;
        }
        $data['teacherList'] = $teacherList;
        $data['count_teacher'] = count($teacherList);
        $data['classId'] = $classId;
        //获取学科老师信息
        $res = $this->class_model->getSubjectByClass($classId);
        if($res==false) $ListBysortHead = "";
        $teacherList= $this->class_model->getTeacherListByInstitution($_SESSION['institution'],$res->subject,"",'1','1');
        if($teacherList==false) $ListBysortHead = ""; 
        $public_config = $this->config->item('common_public');
        foreach ($teacherList as $key => $val) {
            if(!isset($sortHeadArr[$val->sortHead])){
                $sortHeadArr[$val->sortHead] = array();
            }
            if(!in_array($val->id,$sortHeadArr[$val->sortHead])){
                $ListBysortHead[$val->sortHead][$key]['teacherinfourl']  = $this->url_config['teacherInfo']."?teacherId=".$val->id;  
                $ListBysortHead[$val->sortHead][$key]['truthName']  = $val->truthName;  
                $ListBysortHead[$val->sortHead][$key]['truthName']  .= ($val->nickname!=""&&$val->nickname!=$val->truthName)?"(".$val->nickname.")":"";  
                //$ListBysortHead[$val->sortHead][$key]['nickname']  = $val->nickname;  
                $ListBysortHead[$val->sortHead][$key]['teacherId']  = $val->id;  
                $ListBysortHead[$val->sortHead][$key]['teacherCode']  =  $val->teacherCode;
                $ListBysortHead[$val->sortHead][$key]['path']  = ($val->path==null)?$public_config['default_avatar']['120']:$val->path;  
            }
        }
        $data['subjectTeacher'] = $ListBysortHead;
        $data['studentList'] = "";
        $data['prevkeywords'] = "";
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
		//var_dump($data);exit;
        $this->sm->view('orgclass/info',$data);  
    }

    /**
 	* Description : 下载班级学员的模板
 	* Author      : jishuai
 	* Created Time: 2014-12-24 13:37
	*/
	public function download(){
		$this->checklogin();
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $classInfo = $this->class_model->getClassInfoByInst($classId,$_SESSION['institution']);
		$className = $classInfo->className?$classInfo->className:'';
		ob_clean();
		$fileName = "班级学员表_$className.xlsx";
		$file = $_SERVER['DOCUMENT_ROOT'].'/uploads/default/classStudent.xlsx';
		sendFile($fileName,'',array('filepath'=>$file));
	}

    /**
 	* Description : 上传班级的学员
 	* Author      : jishuai
 	* Created Time: 2014-12-24 13:59
	*/
	public function upload(){
		$this->checklogin();
		$data['classId'] = $classId = $this->hasClass();
		if(! $classId) show_404();
		$data['step'] = (isset($_REQUEST['step'])&&(in_array($_REQUEST['step'],array('1','2'))))?$_REQUEST['step']:"1";
		$data['fileMd5'] = (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:"";
		$data['status'] = (isset($_REQUEST['status'])&&(in_array($_REQUEST['status'],array('1','0'))))?$_REQUEST['status']:"0";
		$data['isup'] = (isset($_REQUEST['isup'])&&(in_array($_REQUEST['isup'],array('1'))))?$_REQUEST['isup']:"0";
		if($data['step']=='1')
			$data['status'] = '0';
		if($data['status']=='0')
			$data['step'] = '1';
		$data['upUrl'] = '/'.$this->url_config['classStuDoUpload'].'?fileMd5='.$data['fileMd5'].'&classId='.$classId;
		$data['doNext'] = '/'.$this->url_config['classStuShowErr'].'?fileMd5='.$data['fileMd5'].'&classId='.$classId;
		$this->sm->view('orgclass/upload',$data);
	}

	/**
	 * Description :  对上传进行简单处理（文件类型、上传结果等）
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:47
	 */
	public function doupload(){
		$this->checklogin();
		$classId = $this->hasClass();
		if(! $classId) show_404();
		$this->config->load('uploads');		
		$config = $this->config->item("student");
		$this->load->library('upload');
		$_FILES['userfile'] = $_FILES['UpLoadFile'];
		$is_upload = $this->upload->upload_file($config);
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
		$url = '/'.$this->url_config['classStuUpload'].'?step='.$step.'&status='.$status.$fileMd5Para.'&isup=1&classId='.$classId;
		header("Location:".$url);exit; 
	}


	/**
	 * Description : 获取文件上传反馈错误信息
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:48
	 */
	public function uploadstatus(){
		$this->ajaxChecklogin();
		$classId = $this->hasClass();
		if(! $classId) show_404();
		$status = (isset($_REQUEST['status'])&&$_REQUEST['status']!="")?$_REQUEST['status']:'0';
		$fileMd5= (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:'';

		if($status=='0'){
			echojson(0,"",'文件无效，请使用标准模板');
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
		if($highestColumnIndex != '2') echojson(0,'','文件无效，请使用标准模板');
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
		$student_config = $this->config->item("titlecs");
		$schedulecolumn_config = $this->config->item("scheduleFileColumn");		
		if($student_config != $titles) echojson(0,"",'文件无效,请使用标准模板');
		$url = '/index.php/orgclass/uploadstep1?fileMd5='.$fileMd5.'&classId='.$classId;
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
		$data['title'] = "上传班级学员信息表";
		$data['fileMd5'] = $fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
		$classId = $this->hasClass();
		if(! $classId) show_404();
		if($fileMd5==""){
			$data['fileMd5'] = "";
		}else{
			$data['fileMd5'] = $fileMd5;
		}
		$data['url']['enter'] = '/'.$this->url_config['classStuUploadEnter'].'?fileMd5='.$fileMd5;
		$data['url']['back'] = '/'.$this->url_config['classStuUpload'].'?classId='.$classId;
		$data['fileMd5'] = $fileMd5;
		$data['classId'] = $classId;
		$this->sm->view('orgclass/check',$data); 
	}

	/**
	 * Description : 检测错误问题，并进行问题反馈
	 * Author      : jishuai
	 * Created Time: 2014-11-28 12:48
	 */
	public function  checkStep2(){
		$this->ajaxChecklogin();
		$classId = $this->hasClass();
		if(! $classId) show_404();
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:echojson(0,'','异常操作');
		$this->config->load('uploads');     
		$config = $this->config->item("student");      
		$sourcefile = $config['upload_path'].$fileMd5.".xlsx";
		if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
		$data = $this->checkdata($fileMd5);
		$tmpData['errNum'] = $data['excelErr'];
		$tmpData['err'] = $data['err'];
		$tmpData['total'] = $data['total'];
		$tmpData['isAllowInsert'] = $data['continue'];
		$tmpData['normal'] = $data['total']-$data['excelErr'];
		if($tmpData['normal'] == 0) $data['continue']=false;
		$tmpData['url']['next'] = '/'.$this->url_config['classStuUploadEnter'].'?fileMd5='.$fileMd5.'&classId='.$classId;
		$data['url']['back'] = '/'.$this->url_config['classStuUpload'].'?classId='.$classId;
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
		$classId = $this->hasClass();
		if(! $classId) show_404();
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
		$insertId = array();
		foreach($excelDate as $k => $v){
			if($v[0] == ''){
				$err[$k] = array('name'=>$v[0],'type'=>1); continue;
			}
			if($v[1] == ''){
				$err[$k] = array('name'=>$v[0],'type'=>2); continue;
			}
			$stuExist = $this->student_model->exist($v[0],$v[1],'',$_SESSION['institution']);
			if($stuExist){
				$isInClass = $this->student_model->existByClassId($stuExist[0]->id,$classId);
				if($isInClass){
					$err[$k] = array('name'=>$v[0],'type'=>7);
				}else{
					$studentId = $stuExist[0]->id;
					if(in_array($studentId,$insertId)){
						$sameRow = array_search($studentId,$insertId);
						$err[$k] = array('name'=>$v[0],'sameRow'=>$k,'type'=>8);
					}else{
						$insertId[$k] = $stuExist[0]->id;
					}
				}
			}else{
				$err[$k] = array('name'=>$v[0],'type'=>3);
				$hasName = $this->student_model->existSameName($v[0],$_SESSION['institution']);
				if($hasName) $err[$k] = array('name'=>$v[0],'type'=>5);
				$hasTel = $this->student_model->existTel($v[1],$_SESSION['institution']);
				if($hasTel) $err[$k] = array('name'=>$v[0],'type'=>4);
			}
		}
		$count = count($err);
		$data['excelErr']= count($err);
		$data['res'] = $insertId;
		$data['continue'] = true;
		$row = 10;
		$page =(int)(isset($_REQUEST['p'])?$_REQUEST['p']:"1");
		if($page == 'undefined') $page = '1';
		if(isset($err)){
			$length = $row;
			if($page*$row > $count) $length = $count%$row;
			$errPageArr = array_slice($err,($page-1)*$row,$length,true);	
			foreach($errPageArr as $k=>$v){
				if($v['type'] < 7) $data['continue'] = false;
				if($v['type'] == '1'){
					$errPageArr[$k]['checkinfo'] = "学生姓名不能为空";
				}elseif($v['type']=='2'){
					$errPageArr[$k]['checkinfo'] = "家长A手机号不能为空";
				}elseif($v['type']=='3'){
					$errPageArr[$k]['checkinfo'] = "未找到符合条件的学员";
				}elseif($v['type']=='4'){
					$errPageArr[$k]['checkinfo'] = "未找到姓名符合的学员";
				}elseif($v['type'] =='5'){
					$errPageArr[$k]['checkinfo'] = "未找到家长A手机号符合的学员";
				}elseif($v['type'] == '7'){
					$errPageArr[$k]['checkinfo'] = "与班级已有学员重复";
				}elseif($v['type'] == '8'){
					$errPageArr[$k]['checkinfo'] = "与第 $v[sameRow] 行重复";
				}
			}
		}
		$data['err'] = $errPageArr;
		$data['current_count']  = count($err);
		$operation_data =new Operation_data(); 
		$operation_data->base_url = "/index.php/orgclass/checkStep2?fileMd5=".$fileMd5;
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
		$classId = $this->hasClass();
		if(! $classId) show_404();
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
		$studentIds = $data['res'];
		if($data['succNum'] = $this->student_model->addToClass($studentIds,$classId)){
			$_SESSION['succNum'] = $data['succNum'];
			$data['url'] = '/'.$this->url_config['classStuEnterSucc'].'?classId='.$classId;
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
		$data['classId'] = $this->hasClass();
		$data['title'] = '上传成功';
		$data['succNum'] = isset($_SESSION['succNum'])?$_SESSION['succNum']:'0';
		$this->sm->view('orgclass/entersucc',$data);
	}

    /**
 	* Description : 查询是否是当前机构的班级（内部调用）
 	* Author      : jishuai
 	* Created Time: 2014-12-25 11:25
	*/
	public function hasClass(){
		$classId = (int)(isset($_REQUEST['classId'])?$_REQUEST['classId']:"");
        $classInfo = $this->class_model->getClassInfoByInst($classId,$_SESSION['institution']);
		if($classInfo){
			return $classId;
		}else{
			return false;
		}
	}
}
