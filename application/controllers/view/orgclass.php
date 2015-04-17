<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class  Orgclass extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("class_model");
        $this->config->load('public');
        $this->load->model("student_model");
        $this->load->model("grade_model");
        $this->load->model("classtype_model");
        $this->load->model("institution_classtype_model");
        loadLib('Operation_data');
        $this->ajaxChecklogin();
    }
    /**
     *description:班级列表数据
     *author:yanyalong
     *date:2014/11/04
     */
    //public function index(){
        //$page = isset($_REQUEST['p'])?$_REQUEST['p']:'1';
        //$row = 5;
        //$teacherId = isset($_REQUEST['teacherId'])?$_REQUEST['teacherId']:"";
        //$gradeId = isset($_REQUEST['gradeId'])?$_REQUEST['gradeId']:"";
        //$classTypeCode = isset($_REQUEST['classTypeCode'])?$_REQUEST['classTypeCode']:"";
        //$classTypePeriod = isset($_REQUEST['classTypePeriod'])?$_REQUEST['classTypePeriod']:"";
        //$isEnd = isset($_REQUEST['isEnd'])?$_REQUEST['isEnd']:"";
        //$keywords= (isset($_REQUEST['keywords'])&&$_REQUEST['keywords']!='')?$_REQUEST['keywords']:"";
        //$res = $this->class_model->getlistByInstitution($_SESSION['institution'],$teacherId,$gradeId,$classTypeCode,$classTypePeriod,'',$isEnd,trim($keywords),$page,$row);
        //$data['isEnd'] = $isEnd;
        //if($keywords!=""){
            //$data['isEnd'] = "";
        //}
        //$data['prevkeywords'] = $keywords;
        //$data['pageUrl'] = '/'.$this->view_config['classList'].'?teacherId='.$teacherId.'&gradeId='.$gradeId.'&classTypeCode='.$classTypeCode.'&classTypePeriod='.$classTypePeriod.'&isEnd='.$isEnd.'&keywords='.$keywords;
        //if($res==false){
            //$data['count']= 0;
            //echojson(0,$data,"无相关数据");
        //}else $data['count'] = $res['count'];
        //$list = $res['classlist'];
        //$classIdList = "";
        //foreach ($list as $key => $val) {
            //$classIdList.= $val['classId'].","; 
        //}
        //$teacherList = $this->class_model->getTeacherbyClassList(trim($classIdList,','));
        //foreach ($list as $key => $val) {
            //$list[$key]['classCode'] = $val['classCode'];
            //$list[$key]['classUrl'] = "/".$this->url_config['classInfo']."?classId=".$val['classId'];
            //if($val['ClassStatus']=='0'){
                //$list[$key]['classEndStatus']  = "未结课";
            //}else{
                //$list[$key]['classEndStatus']  = "已结课";
            //}
            //$list[$key]['teacher'] = "";
            //foreach ($teacherList as $keys => $vals) {
                //if($vals->classId==$val['classId']){
                    //$list[$key]['teacher'] .= $vals->truthName;
                    //if($vals->nickname!=''&&$vals->nickname!=$vals->truthName){
                        //$list[$key]['teacher'] .= "(".$vals->nickname.")|";
                    //}
                //}
            //}
            //$list[$key]['teacher'] = trim($list[$key]['teacher'],'|');
        //}
        //$data['classlist'] = $list;
        //$data['current_count']  = count($list);
        //$operation_data =new Operation_data(); 
        //$operation_data->base_url = $this->view_config['classList'];
        //$operation_data->total_rows = $res['count'];
        //$operation_data->per_page = $row;
        //$operation_data->cur_page= $page;
        //$data['page'] = $operation_data->show_page_ajax();
        //echojson(1,$data);
    //}
    /**
     *description:创建班级时选择任课老师列表数据
     *author:yanyalong
     *date:2014/11/04
     */
    public function teacherselect(){
        $subjectId = isset($_REQUEST['subjectId'])?$_REQUEST['subjectId']:"";
        $gradeId = isset($_REQUEST['gradeId'])?$_REQUEST['gradeId']:"";
        $keywords= isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
        $teacherList= $this->class_model->getTeacherListByInstitution($_SESSION['institution'],$subjectId,trim($keywords),'1','1');
        if($teacherList==false) echojson(0,"","无相关信息");
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
        $data['list'] = $ListBysortHead;
        echojson(1,$data);
    }
    /**
     *description:添加任课老师列表数据
     *author:yanyalong
     *date:2014/11/04
     */
    public function teacheradd(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,"","异常操作");
        $keywords= isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $res = $this->class_model->getSubjectByClass($classId);
        if($res==false) echojson(0,"","异常操作"); 
        $teacherList= $this->class_model->getTeacherListByInstitution($_SESSION['institution'],$res->subject,trim($keywords),'1','1');
        if($teacherList==false) echojson(0,"","无相关信息");
        $public_config = $this->config->item('common_public');
        foreach ($teacherList as $key => $val) {
            if(!isset($sortHeadArr[$val->sortHead])){
                $sortHeadArr[$val->sortHead] = array();
            }
            if(!in_array($val->id,$sortHeadArr[$val->sortHead])){
                $ListBysortHead[$val->sortHead][$key]['teacherinfourl']  = '/'.$this->url_config['teacherInfo']."?teacherId=".$val->id;  
                $ListBysortHead[$val->sortHead][$key]['truthName']  = $val->truthName;  
                $ListBysortHead[$val->sortHead][$key]['truthName']  .= ($val->nickname!=""&&$val->nickname!=$val->truthName)?"|(".$val->nickname.")":"";  
                //$ListBysortHead[$val->sortHead][$key]['nickname']  = $val->nickname;  
                $ListBysortHead[$val->sortHead][$key]['teacherId']  = $val->id;  
                $ListBysortHead[$val->sortHead][$key]['teacherCode']  =  $val->teacherCode;
                $ListBysortHead[$val->sortHead][$key]['path']  = ($val->path==null)?$public_config['default_avatar']['120']:$val->path;  
            }
        }
        $data['list'] = $ListBysortHead;
        echojson(1,$data);
    }
    /**
     *description:当前班级学员
     *author:yanyalong
     *date:2014/11/04
     */
    public function currentstudent(){
        $page = (isset($_REQUEST['p'])&&$_REQUEST['p']!='')?$_REQUEST['p']:'1';
        $row = 30;
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $classInfo = $this->class_model->getClassInfoByInst($classId,$_SESSION['institution']);
        if($classInfo==false){
            echojson(0,'','无相关数据'); 
        }
        $res = $this->class_model->getStudentListByClassId($classId,$page,$row);
        if($res==false) echojson(0,'','无相关数据');
        $public_config = $this->config->item('common_public');
        foreach ($res['list'] as $key => $val) {
            $list[$key]['avatar']  = ($val->avatar=='')?$public_config['default_avatar']['120']:$val->avatar;  
            $list[$key]['studentUrl'] = '/'.$this->url_config['studentInfo']."?studentId=".$val->studentId;
            $list[$key]['studentId'] = $val->studentId;
            $list[$key]['studentName'] = $val->truthName;
            $list[$key]['sex'] = $val->sex;
            $list[$key]['joinTime'] = $val->joinTime;
            $list[$key]['lastLogin'] = $val->lastLogin;
            $list[$key]['isLogin'] = $val->isLogin;
            $list[$key]['studentId'] = $val->studentId;
        }
        $data['studentList'] = $list;
        $operation_data =new Operation_data(); 
        $operation_data->base_url = '/'.$this->view_config['classCurrentStudent']."?classId=".$classId;
        $operation_data->total_rows = $res['count'];
        $operation_data->per_page = $row;
        $operation_data->cur_page= $page;
        $data['page'] = $operation_data->show_page_ajax();
        $data['totals'] = $res['count'];
        $stuStatInfo =$this->class_model->getStudentStatByClassId($classId);
        $data['stuLogNum'] = $stuStatInfo->loginNum;
        $data['studentNumber'] = $stuStatInfo->studentNum;
        $data['current_count'] = count($list);
        $data['isEnd'] = $classInfo->ClassStatus;
        echojson(1,$data);
    }
    /**
     *description:下载班级学员帐号密码
     *author:yanyalong
     *date:2014/11/04
     */
    public function studownload(){
        $_REQUEST['classId'] = 1;
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $list = $this->student_model->getStudentListByClass($classId);
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        loadLib("excel/PHPExcel");
        loadLib("excel/PHPExcel/IOFactory");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")->setLastModifiedBy("Maarten Balliauw")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0);
        $objRichText = new PHPExcel_RichText();
        // 列宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // 行高
        for($i = 1; $i <=2000; $i++) {
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(35);
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '学员姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '帐号');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '密码');
        $i = 2;
        foreach ($list as $key=>$val) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$val->truthName);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$val->studentName);
            if(md5($this->public_config['stuInitPass'])!=$val->password){
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,'学员已修改密码');
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$this->public_config['stuInitPass']);
            }
            $i++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('班级账号密码');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($_SERVER['DOCUMENT_ROOT'].'application/logs/class_student/'.iconv('utf-8','gbk', $classInfo->className).'.xls');
        header("Location:"."/application/logs/class_student/".$classInfo->className.".xls");
    }
    /**
     *description:添加学员选择列表
     *author:yanyalong
     *date:2014/11/04
     */
    public function addstulist(){
        $selectList= isset($_REQUEST['selectList'])?$_REQUEST['selectList']:array();
        $gradeIdArr = isset($_REQUEST['gradeIds'])?$_REQUEST['gradeIds']:"";
        $keywords= isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $data['gradeShowFlag'] = false;
        if($keywords==""){
            echojson(0,$data,"请先输入搜索条件");
        }
        if((strlen(trim($keywords)) + mb_strlen(trim($keywords),'UTF8'))/2<4)
        echojson(0,$data,"请输入至少2个汉字或完整学员编码");
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,$data,"不存在的班级");
        }
        $gradeIds = "";
        if(!empty($gradeIdArr)) $gradeIds = implode(',',$gradeIdArr);
        //获取机构学员列表
        $studentList = $this->class_model->getStudentListinstitution($_SESSION['institution'],$classId,$gradeIds,trim($keywords));
        if($studentList==false)  echojson(0,$data,'没有查学员信息');
        else{
            $data['gradeShowFlag'] = true;
            //获取班级学员列表
            $thisClassStudentList = $this->class_model->getStudentbyClassList($classId);
            //循环确定学员列表中哪个学员属于当前班级
            if($thisClassStudentList==false){
                foreach ($studentList as $key => $val) {
                    $studentList[$key]->isInThisClass = "0";        
                }
            }else{
                $thisClassStudentArr = array();
                foreach ($thisClassStudentList as $key => $val) {
                    $thisClassStudentArr[] = $val->studentId;
                }
            }
            foreach ($studentList as $key => $val) {
                if(!isset($sortHeadArr[$val->sortHead])){
                    $sortHeadArr[$val->sortHead] = array();
                }
                if(!in_array($val->studentId,$sortHeadArr[$val->sortHead])){
                    $sortHeadArr[$val->sortHead][] = $val->studentId;
                    $SListBysortHead[$val->sortHead][$key]['studentUrl']  = '/'.$this->url_config['studentInfo']."?studentId=".$val->studentId;  
                    $SListBysortHead[$val->sortHead][$key]['studentId']  = $val->studentId;  
                    $SListBysortHead[$val->sortHead][$key]['studentName']  = ($val->studentName!='')?$val->studentName:"佚名";  
                    $SListBysortHead[$val->sortHead][$key]['gradeName']  = ($val->gradeName!='')?$val->gradeName:"空年级"; 
                    $SListBysortHead[$val->sortHead][$key]['studentCode']  =  $val->code;
                    if(isset($thisClassStudentArr)&&!empty($thisClassStudentArr)&&in_array($val->studentId,$thisClassStudentArr)){
                        $SListBysortHead[$val->sortHead][$key]['isInThisClass']  = "1";  
                    }else{
                        $SListBysortHead[$val->sortHead][$key]['isInThisClass']  = "0";  
                    }
                }
                if(in_array($val->studentId,$selectList)){
                     $SListBysortHead[$val->sortHead][$key]['isInThisClass']  = "1";  
                }
            }
        }
        $data['list'] = $SListBysortHead;
        $data['prevkeywords'] = $keywords;
        echojson(1,$data);
    }
    /**
     *description：班级课表
     *author:yanyalong
     *date:2014/11/04
     */
    public function schedule(){
        $page = (isset($_REQUEST['p'])&&$_REQUEST['p']!="")?$_REQUEST['p']:'1';
        $row = 30;
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $classInfo = $this->class_model->getClassInfoByInst($classId,$_SESSION['institution']);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $res = $this->class_model->getScheduleListByClassId($classId,$page,$row);
        if($res==false) echojson(0,'','无相关数据');
        foreach ($res['list'] as $key => $val) {
            $list[$key]['num'] = $val->num;
            $list[$key]['lessonId'] = $val->lessonId;
            $list[$key]['ScheduleDate'] = ($val->ScheduleDate!=null)?$val->ScheduleDate."|".$val->beginTime."-".$val->endTime:"未填写";
            $list[$key]['beginTime'] = $val->beginTime;
            $list[$key]['SecheduleReadyStatus'] = $val->SecheduleReadyStatus;
            $list[$key]['endTime'] = $val->endTime;
            $list[$key]['truthName'] = ($val->truthName!="")?$val->truthName:"未填写";
            $list[$key]['truthName'] .= ($val->nickname!="")?"(".$val->nickname.")":"";
            $list[$key]['nickname'] = $val->nickname;
            $list[$key]['lessonName'] = $val->lessonName;
            $list[$key]['replaceTruthName'] = ($val->replaceTruthName!="")?$val->replaceTruthName:"无";
            $list[$key]['replaceTruthName'] .= ($val->replaceNickname!="")?"(".$val->replaceNickname.")":"";
            $list[$key]['classStatus']  = $classInfo->ClassStatus;
            $list[$key]['replaceStatus'] = $val->replaceStatus;
        }
        $data['schedulelist'] = $list;
        $operation_data =new Operation_data(); 
        $operation_data->base_url = '/'.$this->view_config['classSchedule']."?classId=".$classId;
        $operation_data->total_rows = $res['count'];
        $operation_data->per_page = $row;
        $operation_data->cur_page= $page; 
        $data['page'] = $operation_data->show_page_ajax();
        $data['totals'] = $res['count'];
        $data['current_count'] = count($list);
        $scheStatInfo =$this->class_model->getScheduleStatByClassId($classId);
        $data['readyLessonNum'] = $scheStatInfo->readyLessonNum;
        $data['classNumber'] = $scheStatInfo->classNumber;
        echojson(1,$data);
    }

    /**
     *description:获取年级列表
     *author:yanyalong
     *date:2014/11/07
     */
    public function getgrade(){
        $gradelist = $this->grade_model->getlist();
        foreach ($gradelist as $key => $val) {
            $data[$key]['gradeId'] = $val->id;
            $data[$key]['gradeName'] = $val->name;
        }
        echojson(1,$data);
    }
    /**
     *description:学员转班弹窗
     *author:yanyalong
     *date:2014/11/09
     */
    public function studentchange(){
        $subjectId= isset($_REQUEST['subjectId'])?$_REQUEST['subjectId']:"";
        $gradeId = isset($_REQUEST['gradeId'])?$_REQUEST['gradeId']:"";
        $keywords= isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
        $studentId = isset($_REQUEST['studentId'])?$_REQUEST['studentId']:echojson(0,'','异常操作');
		if(! $this->student_model->existById($_SESSION['institution'],$studentId)) echojson(0,'','异常操作'); 
        $res = $this->class_model->getlistByInstitution($_SESSION['institution'],"",$gradeId,"","",$subjectId,'0',trim($keywords));
        if($res==false) echojson(0,"","无相关数据");
        $list = $res['classlist'];
        $classIdList = "";
        foreach ($list as $key => $val) {
            $classIdList.= $val['classId'].","; 
        }
        $teacherList = $this->class_model->getTeacherbyClassList(trim($classIdList,','));
        $studentList = $this->class_model->getStudentbyClassList(trim($classIdList,','));
        foreach ($list as $key => $val) {
            $list[$key]['classCode'] = $val['classCode'];
            $list[$key]['classUrl'] = "/".$this->url_config['classInfo']."?classId=".$val['classId'];
            $list[$key]['stuLogNum'] = (in_array($list[$key]['stuLogNum'],array(null,'')))?'0':$list[$key]['stuLogNum'];
            $i = 0;
            if($teacherList==false){
                $list[$key]['teacher'] = "数据异常";
            }else{
                foreach ($teacherList as $keys => $vals) {
                    if(!isset($list[$key]['teacher'])){
                        $list[$key]['teacher']= '';
                    }
                    if($vals->classId==$val['classId']){
                        $list[$key]['teacher'] .= $vals->truthName;
                        $list[$key]['teacher'] .= ($vals->nickname!=""&&$vals->nickname!=$vals->truthName)?"(".$vals->nickname.")":"";
                        $list[$key]['teacher'] .= " + ";
                        $i++;
                    }
                }
                $list[$key]['teacher'] = rtrim($list[$key]['teacher'],' + ');
            }
            $list[$key]['isInThisClass']= '0';
            foreach ($studentList as $keyss => $valss) {
                if($valss->classId==$val['classId']&&$valss->studentId==$studentId){
                    $list[$key]['isInThisClass']= '1';
                }
            }
        }
        $data['classlist'] = $list;
		$data['prevkeywords'] = $keywords;
		//var_dump($data);exit;
		$res =  json_encode($data);
		//var_dump($res);
        echojson(1,$data,'');
    }
    /**
     *description:创建班级时选择任课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function createTeacherSelect(){
        $keywords= isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
        $subjectId = isset($_REQUEST['subjectId'])?$_REQUEST['subjectId']:"";
        $teacherList= $this->class_model->getTeacherListByInstitution($_SESSION['institution'],$subjectId,trim($keywords),'1','1');
        if($teacherList==false) echojson(0,"","无相关信息");
        $public_config = $this->config->item('common_public');
        foreach ($teacherList as $key => $val) {
            if(!isset($sortHeadArr[$val->sortHead])){
                $sortHeadArr[$val->sortHead] = array();
            }
            if(!in_array($val->id,$sortHeadArr[$val->sortHead])){
                $ListBysortHead[$val->sortHead][$key]['teacherinfourl']  = '/'.$this->url_config['teacherInfo']."?teacherId=".$val->id;  
                $ListBysortHead[$val->sortHead][$key]['truthName']  = $val->truthName;  
                $ListBysortHead[$val->sortHead][$key]['truthName']  .= ($val->nickname!=""&&$val->nickname!=$val->truthName)?"|(".$val->nickname.")":"";  
                //$ListBysortHead[$val->sortHead][$key]['nickname']  = $val->nickname;  
                $ListBysortHead[$val->sortHead][$key]['teacherId']  = $val->id;  
                $ListBysortHead[$val->sortHead][$key]['teacherCode']  =  $val->teacherCode;
                $ListBysortHead[$val->sortHead][$key]['path']  = ($val->path==null)?$public_config['default_avatar']['120']:$val->path;  
            }
        }
        $data['list'] = $ListBysortHead;
        echojson(1,$data);
    }
    /**
     *description:根据学科和年级获取班型
     *author:yanyalong
     *date:2014/11/19
     */
    public function gradesubject(){
        $subjectId =(int)(isset($_REQUEST['subjectId'])?$_REQUEST['subjectId']:"");
        $gradeId=(int)(isset($_REQUEST['gradeId'])?$_REQUEST['gradeId']:"");
        $res = $this->classtype_model->getClassTypeBySubectGrade($_SESSION['institution'],$subjectId,$gradeId);
        $data['0']['code'] = "";
        $data['0']['name'] = "请选择班型";
        foreach ($res as $key => $val) {
            $data[$key+1]['code'] = $val->code;
            $data[$key+1]['name'] = $val->classTypeName?$val->classTypeName:$val->name;
        }
        echojson(1,$data);
    }
    /**
     *description:根据班型code获取学期列表
     *author:yanyalong
     *date:2014/12/02
     */
    public function getPeriod(){
        $classTypeCode = isset($_REQUEST['classTypeCode'])?$_REQUEST['classTypeCode']:"";
        $res = $this->institution_classtype_model->getPeriodByCTCode($_SESSION['institution'],$classTypeCode);
        if($res==false) {
            $data['period'] = "";
            echojson(0,$data,"无相关数据");
        }
        $period = array();
        foreach ($res as $key => $val) {
            $period[$key]['classTypePeriod'] = $val->period; 
            $period[$key]['periodName'] = $this->common_public['classTypePeriod'][$val->period];
        }
        $data['period'] = $period;
        echojson(1,$data);
    }


    /**
 	* Description : 获取修改班级的回显
 	* Author      : jishuai
 	* Created Time: 2015-02-09 19:40
	*/
	public function getTimeOfClass(){
		$classId = isset($_REQUEST['classId'])?$_REQUEST['classId']:'';
		if(! $this->class_model->existByInsID($classId)) show_404();
		$info = $this->class_model->get($classId);
		$beginTimeSlot = explode(':',$info->beginTimeSlot);
		$endTimeSlot = explode(':',$info->endTimeSlot);
		$beginTime = explode('-',substr($info->beginTime,0,10));
		$endTime = explode('-',substr($info->endTime,0,10));
		if($info->semester != null){
			$show = 'semester';
		}else{
			$show = 'shoukeDay';
		}
		$tearm = $info->semester?$info->semester:$info->shoukeDay;
		$arr = get_defined_vars();
		echojson('1',$arr,'');
	}









}

