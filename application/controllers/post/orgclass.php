<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Orgclass extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("classtype_model");
        $this->load->model("class_model");
        $this->load->model("classrefstutea_model");
        $this->load->model("teacher_model");
        $this->load->model("schedule_model");
        $this->ajaxChecklogin();
    }

    /**
 	* Description : 接受创建班级的数据
 	* Author      : jishuai
 	* Created Time: 2015-03-01 14:30
	*/
    public function create(){
		//var_dump($_POST);exit;
        $subjectId= (isset($_REQUEST['subjectId'])&&$_REQUEST['subjectId']!="")?$_REQUEST['subjectId']:echojson(0,'','请选择学科');
        $gradeId= (isset($_REQUEST['gradeId'])&&$_REQUEST['gradeId']!="")?$_REQUEST['gradeId']:echojson(0,'','请选择年级');
        $teacherIdOne= (isset($_REQUEST['teacherIdOne'])&&$_REQUEST['teacherIdOne']!="")?$_REQUEST['teacherIdOne']:echojson(0,'','请至少选择一个老师');
        $teacherIdTwo= (isset($_REQUEST['teacherIdTwo'])&&$_REQUEST['teacherIdTwo']!="")?$_REQUEST['teacherIdTwo']:"";
        (($teacherIdTwo!="")&&($teacherIdTwo==$teacherIdOne))?echojson(0,'','两个任课老师不能相同'):"";
        $classTypeCode= (isset($_REQUEST['classTypeCode'])&&trim($_REQUEST['classTypeCode'])!="")?$_REQUEST['classTypeCode']:echojson(0,'','请选择班型');
        $classTypePeriod= isset($_REQUEST['classTypePeriod'])?$_REQUEST['classTypePeriod']:echojson(0,'','请选择班型学期');
        $className= (isset($_REQUEST['className'])&&trim($_REQUEST['className'])!="")?$_REQUEST['className']:echojson(0,'','请填写班级名称');
        $beginHour = (isset($_REQUEST['beginHour'])&&trim($_REQUEST['beginHour'])!="")?$_REQUEST['beginHour']:echojson(0,'','请填写授课时段');
        $endHour = (isset($_REQUEST['endHour'])&&trim($_REQUEST['endHour'])!="")?$_REQUEST['endHour']:echojson(0,'','请填写授课时段');
        $beginMin = (isset($_REQUEST['beginMin'])&&trim($_REQUEST['beginMin'])!="")?$_REQUEST['beginMin']:echojson(0,'','请填写授课时段');
        $endMin = (isset($_REQUEST['endMin'])&&trim($_REQUEST['endMin'])!="")?$_REQUEST['endMin']:echojson(0,'','请填写授课时段');
        $beginYear = (isset($_REQUEST['beginYear'])&&trim($_REQUEST['beginYear'])!="")?$_REQUEST['beginYear']:echojson(0,'','请填写开课时间');
        $beginMonth= (isset($_REQUEST['beginMonth'])&&trim($_REQUEST['beginMonth'])!="")?$_REQUEST['beginMonth']:echojson(0,'','请填写开课时间');
        $beginDay = (isset($_REQUEST['beginDay'])&&trim($_REQUEST['beginDay'])!="--")?$_REQUEST['beginDay']:echojson(0,'','请填写开课时间');
        $endYear = (isset($_REQUEST['endYear'])&&trim($_REQUEST['endYear'])!="")?$_REQUEST['endYear']:echojson(0,'','请填写结课时间');
        $endMonth = (isset($_REQUEST['endMonth'])&&trim($_REQUEST['endMonth'])!="")?$_REQUEST['endMonth']:echojson(0,'','请填写结课时间');
        $endDay = (isset($_REQUEST['endDay'])&&trim($_REQUEST['endDay'])!="--")?$_REQUEST['endDay']:echojson(0,'','请填写结课时间');
        $chooseWeek = (isset($_REQUEST['chooseWeek'])&&trim($_REQUEST['chooseWeek'])!="")?$_REQUEST['chooseWeek']:echojson(0,'','异常操作');
        $choosePhase = (isset($_REQUEST['choosePhase'])&&trim($_REQUEST['choosePhase'])!="")?$_REQUEST['choosePhase']:echojson(0,'','异常操作');
		if(($beginHour > $endHour) || ($beginHour == $endHour && $beginMin > $endMin)) echojson(0,'','授课时段的截止时间不能小于开始时间');
		$beginTimeSlot = $beginHour.':'.$beginMin.':'.'00';
		$endTimeSlot = $endHour.':'.$endMin.':'.'00';
		$beginTime = $beginYear.'-'.$beginMonth.'-'.$beginDay.' '.'00:00:00';
		$endTime = $endYear.'-'.$endMonth.'-'.$endDay.' '.'23:59:59';
		$tmpBegin = strtotime($beginTime);
		$tmpEnd = strtotime($endTime);
		if($tmpEnd < time()) echojson(0,'','结课时间不能小于当前时间');
		if($tmpEnd < $tmpBegin ) echojson(0,'','结课时间不能小于开课时间');
		if($classTypePeriod == '1' or $classTypePeriod == '3'){
			$semester = null;
			$shoukeDay = $chooseWeek;
		}
		if($classTypePeriod == '2' or $classTypePeriod == '4'){
			$semester = $choosePhase;
			$shoukeDay = null;
		}
        if(mb_strlen($className) > 30 or mb_strlen($className) < 1) echojson(0,"","班级名称为1~30个字符");
        $place = (isset($_REQUEST['place'])&&trim($_REQUEST['place'])!="")?$_REQUEST['place']:"";
		if(! $place) echojson(0,"","请填写授课地点");
        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$place))  echojson(0,"","上课地点包含特殊字符");
        $classTypeInfo  = $this->classtype_model->getinfo($classTypeCode,$classTypePeriod);
        //获取当前老师1所在科目信息
        $tea1SubList= $this->teacher_model->getSubject($teacherIdOne);
        $flag = false;
        foreach ($tea1SubList as $key => $val) {
            if($val->id==$classTypeInfo->subject){
                $flag = true;
            } 
        }
        if($flag==false) echojson(0,'','当前老师1不属于当前学科');
        //获取当前老师2所在科目信息
        if($teacherIdTwo!=''){
            $tea2SubList = $this->teacher_model->getSubject($teacherIdTwo);
            $flag = false;
            foreach ($tea2SubList as $key => $val) {
                if($val->id==$classTypeInfo->subject){
                    $flag = true;
                } 
            }
            if($flag==false) echojson(0,'','当前老师2不属于当前学科');
        }
        $class_data = array(
            'className' => $className,
            'classTypeId' => $classTypeInfo->id,
            'institution' => $_SESSION['institution'],
            'studentNumber' => 0,
            'status' => 1,
            'place' => $place,
            'createTime' => date('Y-m-d H:i:s'),
            'beginTimeSlot' => $beginTimeSlot,
            'endTimeSlot' => $endTimeSlot,
            'beginTime' => $beginTime,
            'endTime' => $endTime,
			'creater' => $_SESSION['realName'],
			'semester'=> $semester,
			'shoukeDay'=> $shoukeDay
        );

		//$arr = get_defined_vars();
		//var_dump($arr);exit;
        $classId = $this->class_model->insert($class_data);
		//添加课节表
		$this->class_model->insertSchedule($classId,$classTypeInfo->id);
        //更新新班级编码
        $this->db->where('id',$classId);
        $res = $this->db->update('Class', array('classCode'=>objEncode($classId,'C')));
        //插入老师1班级关联信息`
        $teachaer_one_data = array(
            'classId'=>$classId,
            'userId'=>$teacherIdOne,
            'leaveTime'=>null,
            'type'=>1
        );
        $classRefStuTeaId = $this->classrefstutea_model->insert($teachaer_one_data);          
        if($teacherIdTwo!=''){
            //插入老师2班级关联信息
            $teachaer_two_data= array(
                'classId'=>$classId,
                'userId'=>$teacherIdTwo,
                'leaveTime'=>null,
                'type'=>1
            );
            $classRefStuTeaId= $this->classrefstutea_model->insert($teachaer_two_data);          
        }
        if($classRefStuTeaId==false) echojson(0,"","创建失败");
        $data['url'] = '/'.$this->url_config['classCreateSuccess']."?classId=".$classId;
        echojson(1,$data);
    }
    /**
     *description:删除班级
     *author:yanyalong
     *date:2014/11/04
     */
    public function del(){  
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        if(intval($classId)==""){
            echojson(0,"","异常操作");
        }
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","异常操作");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许删除");
        }
        if($classInfo->studentNumber>0){
            echojson(0,"","删除班级前，请先将所有学员退班");
        }
		if($this->class_model->existHomework($classId)) echojson('0','','因有学员交过作业，此班级无法删除');
        $this->db->where('id',$classId);
        $this->db->update('Class', array('status'=>'2'));
        //将当前班级的所有老师离开班级
        $this->db->where('classId',$classId);
        $this->db->update('classRefStuTea',array('leaveTime'=>date("Y-m-d H:i:s")));
        $data['url'] = '/'.$this->url_config['classList'];
        echojson(1,$data,"删除班级成功");
    }
    /**
     *description:修改班级基本信息
     *author:yanyalong
     *date:2014/11/04
     */
    public function modify(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
		if(! $this->class_model->existByInsID($classId)) show_404();
        $pageType = isset($_REQUEST['pageType'])?$_REQUEST['pageType']:"student";
        $className= (isset($_REQUEST['className'])&&trim($_REQUEST['className'])!="")?$_REQUEST['className']:echojson(0,'','请填写班级名称');
        $beginHour = (isset($_REQUEST['beginHour'])&&trim($_REQUEST['beginHour'])!="")?$_REQUEST['beginHour']:echojson(0,'','请填写授课时段');
        $endHour = (isset($_REQUEST['endHour'])&&trim($_REQUEST['endHour'])!="")?$_REQUEST['endHour']:echojson(0,'','请填写授课时段');
        $beginMin = (isset($_REQUEST['beginMin'])&&trim($_REQUEST['beginMin'])!="")?$_REQUEST['beginMin']:echojson(0,'','请填写授课时段');
        $endMin = (isset($_REQUEST['endMin'])&&trim($_REQUEST['endMin'])!="")?$_REQUEST['endMin']:echojson(0,'','请填写授课时段');
        $beginYear = (isset($_REQUEST['beginYear'])&&trim($_REQUEST['beginYear'])!="")?$_REQUEST['beginYear']:echojson(0,'','请填写开课时间');
        $beginMonth= (isset($_REQUEST['beginMonth'])&&trim($_REQUEST['beginMonth'])!="")?$_REQUEST['beginMonth']:echojson(0,'','请填写开课时间');
        $beginDay = (isset($_REQUEST['beginDay'])&&trim($_REQUEST['beginDay'])!="--")?$_REQUEST['beginDay']:echojson(0,'','请填写开课时间');
        $endYear = (isset($_REQUEST['endYear'])&&trim($_REQUEST['endYear'])!="")?$_REQUEST['endYear']:echojson(0,'','请填写结课时间');
        $endMonth = (isset($_REQUEST['endMonth'])&&trim($_REQUEST['endMonth'])!="")?$_REQUEST['endMonth']:echojson(0,'','请填写结课时间');
        $endDay = (isset($_REQUEST['endDay'])&&trim($_REQUEST['endDay'])!="--")?$_REQUEST['endDay']:echojson(0,'','请填写结课时间');
        $chooseWeek = (isset($_REQUEST['chooseWeek'])&&trim($_REQUEST['chooseWeek'])!="")?$_REQUEST['chooseWeek']:echojson(0,'','异常操作');
        $choosePhase = (isset($_REQUEST['choosePhase'])&&trim($_REQUEST['choosePhase'])!="")?$_REQUEST['choosePhase']:echojson(0,'','异常操作');
		if(($beginHour > $endHour) || ($beginHour == $endHour && $beginMin > $endMin)) echojson(0,'','授课时段的截止时间不能小于开始时间');
		$beginTimeSlot = $beginHour.':'.$beginMin.':'.'00';
		$endTimeSlot = $endHour.':'.$endMin.':'.'00';
		$beginTime = $beginYear.'-'.$beginMonth.'-'.$beginDay.' '.'00:00:00';
		$endTime = $endYear.'-'.$endMonth.'-'.$endDay.' '.'23:59:59';
		$tmpBegin = strtotime($beginTime);
		$tmpEnd = strtotime($endTime);
		if($tmpEnd < $tmpBegin ) echojson(0,'','结课时间不能小于开课时间');
        $place = (isset($_REQUEST['place'])&&trim($_REQUEST['place'])!="")?$_REQUEST['place']:"";
		if(! $place) echojson(0,"","请填写授课地点");
        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$place))  echojson(0,"","上课地点包含特殊字符");
        if(mb_strlen($className) > 30 or mb_strlen($className) < 1) echojson(0,"","班级名称为1~30个字符");
        //查询班级信息
		$classInfo = $this->class_model->get($classId);
		if($classInfo->semester == null){
			$semester = null;
			$shoukeDay = $chooseWeek;
		}else{
			$semester = $choosePhase;
			$shoukeDay = null;
		}
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","异常操作");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许修改");
        }
		$modifyData = array(
            'className' => $className,
            'place' => $place,
            'createTime' => date('Y-m-d H:i:s'),
            'beginTimeSlot' => $beginTimeSlot,
            'endTimeSlot' => $endTimeSlot,
            'beginTime' => $beginTime,
            'endTime' => $endTime,
			'creater' => $_SESSION['realName'],
			'semester'=> $semester,
			'shoukeDay'=> $shoukeDay
		);
		//$arr = get_defined_vars();
		//var_dump($arr);exit;
		$this->db->where('id',$classId);
        $res = $this->db->update('Class',$modifyData);
        $data['url'] = '/'.$this->url_config['classInfo']."?classId=".$classId."&pageType=".$pageType;
        if($res==false) 
            echojson(0,$data,"修改失败");
        else
            echojson(1,$data,"修改成功");   
    }
    /**
     *description:更换班级任课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function changeteacher(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $teacherIdOld= isset($_REQUEST['teacherIdOld'])?$_REQUEST['teacherIdOld']:"";
        $teacherIdNew= isset($_REQUEST['teacherIdNew'])?$_REQUEST['teacherIdNew']:"";
        $pageType = isset($_REQUEST['pageType'])?$_REQUEST['pageType']:"student";
        if(intval($classId)==""||intval($teacherIdOld)==""||intval($teacherIdNew)==""){
            echojson(0,"","异常操作");
        }
        //获取当前班级所在班型科目信息
        $classSubjectInfo= $this->class_model->getSubjectByClass($classId);
        //获取当前老师所在科目信息
        $teaSubList = $this->teacher_model->getSubject($teacherIdNew);
        $flag = false;
        foreach ($teaSubList as $key => $val) {
            if($val->id==$classSubjectInfo->subject){
                $flag = true;
            } 
        }
        if($flag==false) echojson(0,'','当前老师不属于当前学科');
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","异常操作");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许更改老师");
        }
        //查询原老师与当前所在班级的关系
        $classRefStuTeaOld = $this->classrefstutea_model->getInfoByStuClass($classId,$teacherIdOld,1);
        if($classRefStuTeaOld==false||strtotime($classRefStuTeaOld->leaveTime)!=0&&$classRefStuTeaOld->leaveTime!=null) echojson(0,"","原老师不在此班级");
        //查询新老师与当前所在班级的关系
        $classRefStuTeaNew = $this->classrefstutea_model->getInfoByStuClass($classId,$teacherIdNew,1);
        if($classRefStuTeaNew!=false&&(strtotime($classRefStuTeaNew->leaveTime)==0||$classRefStuTeaNew->leaveTime==null)){
            echojson(0,"","此教师已经在当前班级了");
        }
        //原老师离开
        $this->classrefstutea_model->teacherLeaveClass($teacherIdOld,$classId,'1');
        //新老师加入
        $data = array(
            'classId' => $classId,
            'userId' => $teacherIdNew,
            'type' => 1
        );
        $this->classrefstutea_model->insert($data);
        //更新原老师在当前班级的为完成课程的原任课老师为新老师
        $res = $this->schedule_model->updateOldTeaToNew($classId,$teacherIdOld,$teacherIdNew);
        $datares['url'] = '/'.$this->url_config['classInfo']."?classId=".$classId."&pageType=".$pageType;
        if($res==false) 
            echojson(0,$datares,"更换失败");
        else
            echojson(1,$datares,"更换成功");
    }
    /**
     *description:删除班级任课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function delteacher(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $teacherId= isset($_REQUEST['teacherId'])?$_REQUEST['teacherId']:"";
        $pageType = isset($_REQUEST['pageType'])?$_REQUEST['pageType']:"student";
        if(intval($classId)==""||intval($teacherId)==""){
            echojson(0,"","异常操作");
        }
        //获取任课老师列表数据
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        foreach ($teacherList as $key => $val) {
            if($teacherId==$val->teacherId&&$val->secheduleNum>0){
                echojson(0,"","如果想将老师从本班级删除，请先确保该课表中没有该老师未进行的讲次");
            }
        }
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许删除老师");
        }
        //查询老师与当前所在班级的关系
        $classRefStuTea = $this->classrefstutea_model->getInfoByStuClass($classId,$teacherId,1);
        if($classRefStuTea==false||(strtotime($classRefStuTea->leaveTime)!=0&&$classRefStuTea->leaveTime!=null)){
            echojson(0,"","当前班级中不存在该老师");
        }
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        if($teacherList==false||count($teacherList)<2){
            echojson(0,"","当前班级老师数小于2,不允许删除");
        }
        $this->db->where('id',$classRefStuTea->id);
        $res = $this->db->update('classRefStuTea', array('leaveTime'=>date('Y-m-d H:i:s')));
        $data['url'] = '/'.$this->url_config['classInfo']."?classId=".$classId."&pageType=".$pageType;
        if($res==false) 
            echojson(0,$data,"删除失败");
        else
            echojson(1,$data,"删除成功");
    }
    /**
     *description:添加班级任课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function addteacher(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $teacherId= isset($_REQUEST['teacherId'])?$_REQUEST['teacherId']:"";
        $pageType = isset($_REQUEST['pageType'])?$_REQUEST['pageType']:"student";
        if(intval($classId)==""||intval($teacherId)==""){
            echojson(0,"","异常操作");
        }
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","异常操作");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许加入");
        }
        //获取当前班级所在班型科目信息
        $classSubjectInfo= $this->class_model->getSubjectByClass($classId);
        //获取当前老师所在科目信息
        $teaSubList = $this->teacher_model->getSubject($teacherId);
        $flag = false;
        foreach ($teaSubList as $key => $val) {
            if($val->id==$classSubjectInfo->subject){
                $flag = true;
            } 
        }
        if($flag==false) echojson(0,'','当前老师不属于当前学科');
        //获取任课老师列表数据
        if(count($this->class_model->getTeacherbyClassList($classId))>1)
            echojson(0,'','当前班级老师已经有两个了');
        //查询学员与当前所在班级的关系
        $classRefStuTea = $this->classrefstutea_model->getInfoByStuClass($classId,$teacherId,1);
        if($classRefStuTea!=false&&(strtotime($classRefStuTea->leaveTime)==0||$classRefStuTea->leaveTime==null)){
            echojson(0,"","此教师已经在当前班级了");
        }
        $data = array(
            'classId' => $classId,
            'userId' => $teacherId,
            'type' => 1
        );
        $res= $this->classrefstutea_model->insert($data);
        $data['url'] = '/'.$this->url_config['classInfo']."?classId=".$classId."&pageType=".$pageType;
        if($res==false) 
            echojson(0,$data,"加入失败");
        else
            echojson(1,$data,"加入成功");
    }
    /**
     *description:班级学员退班
     *author:yanyalong
     *date:2014/11/04
     */
    public function studentleave(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $studentId= isset($_REQUEST['studentId'])?$_REQUEST['studentId']:"";
        if(intval($classId)==""||intval($studentId)==""){
            echojson(0,"","异常操作");
        }
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","异常操作");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许退班");
        }
        //查询学员与当前所在班级的关系
        $classRefStuTea = $this->classrefstutea_model->getInfoByStuClass($classId,$studentId,0);
        if($classRefStuTea==false) echojson(0,"","异常操作");
        if(strtotime($classRefStuTea->leaveTime)!=0&&$classRefStuTea->leaveTime!=null){
            echojson(0,"","此学员已经退出过当前班级了，请不要重复退出");
        }
        $this->db->where('id',$classRefStuTea->id);
        $this->db->update('classRefStuTea', array('leaveTime'=>date('Y-m-d H:i:s')));
        $this->db->where('id',$classId);
        $res = $this->db->update('Class', array('studentNumber'=>$classInfo->studentNumber-1));
        if($res==false) 
            echojson(0,"","退出失败");
        else
            echojson(1,"","退出成功");
    }
    /**
     *description:班级学员转班
     *author:yanyalong
     *date:2014/11/04
     */
    public function studentchange(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $classIdNew= isset($_REQUEST['classIdNew'])?$_REQUEST['classIdNew']:"";
        $studentId= isset($_REQUEST['studentId'])?$_REQUEST['studentId']:echojson(0,'','异常操作');
        if(intval($classId)==""||intval($studentId)==""||intval($classIdNew)==""){
            echojson(0,"","异常操作");
        }
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","班级不存在");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许转班");
        }
        //查询学员与当前所在班级的关系
        $classRefStuTea = $this->classrefstutea_model->getInfoByStuClass($classId,$studentId,0);
        if($classRefStuTea==false||(strtotime($classRefStuTea->leaveTime)!=0&&$classRefStuTea->leaveTime!=null)){
            echojson(0,"","您不在当前班级中，无法转班");
        }
        //执行退班
        $this->db->where('id',$classRefStuTea->id);
        $this->db->update('classRefStuTea',array('leaveTime'=>date('Y-m-d H:i:s')));
        $this->db->where('id',$classId);
        $this->db->update('Class', array('studentNumber'=>$classInfo->studentNumber-1));
        //加入新班 
        //查询新班级信息
        $classInfo = $this->class_model->get($classIdNew);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","新班级不存在");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许加入");
        }
        //查询学员与当前所在班级的关系
        $classRefStuTea = $this->classrefstutea_model->getInfoByStuClass($classIdNew,$studentId,0);
        if($classRefStuTea!=false&&(strtotime($classRefStuTea->leaveTime)==0||$classRefStuTea->leaveTime==null)){
            echojson(0,"","此学员已经在当前班级了");
        }
        $data = array(
            'classId' => $classIdNew,
            'userId' => $studentId,
            'type' => 0
        );
        $this->classrefstutea_model->insert($data);
        $this->db->where('id',$classIdNew);
        $res = $this->db->update('Class', array('studentNumber'=>$classInfo->studentNumber+1));
        if($res==false) 
            echojson(0,"","转班失败");
        else
            echojson(1,"","转班成功");
    }
    /**
     *description:学员加入班级
     *author:yanyalong
     *date:2014/11/04
     */
    public function studentInClass(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $studentId= isset($_REQUEST['studentId'])?$_REQUEST['studentId']:"";
        if(intval($studentId)==""||intval($classId)==""){
            echojson(0,"","异常操作");
        }
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","班级不存在");
        }
        //加入新班 
        //查询新班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","新班级不存在");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许加入");
        }
        //查询学员与当前所在班级的关系
        $classRefStuTea = $this->classrefstutea_model->getInfoByStuClass($classId,$studentId,0);
        if($classRefStuTea!=false&&(strtotime($classRefStuTea->leaveTime)==0||$classRefStuTea->leaveTime==null)){
            echojson(0,"","此学员已经在当前班级了");
        }
        $data = array(
            'classId' => $classId,
            'userId' => $studentId,
            'type' => 0
        );
        $this->classrefstutea_model->insert($data);
        $this->db->where('id',$classId);
        $res = $this->db->update('Class', array('studentNumber'=>$classInfo->studentNumber+1));
        if($res==false) 
            echojson(0,"","加入新班级失败");
        else
            echojson(1,"","加入新班级成功");
    }
    /**
     *description:班级学员添加
     *author:yanyalong
     *date:2014/11/04
     */
    public function studentadd(){
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $studentIdList= (isset($_REQUEST['studentIdList'])&&(!empty($_REQUEST['studentIdList'])))?array_unique($_REQUEST['studentIdList']):"";
        if(intval($classId)==""||empty($studentIdList)){
            echojson(0,"","异常操作");
        }
        $studentIdList = implode(',',$studentIdList);
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","异常操作");
        }
        if($classInfo->endTime!=null && strtotime($classInfo->endTime)<time()){
            echojson(0,"","已结课的班级不允许加入");
        }
        //转换要添加的学员列表为数组
        $studentAddArr = explode(',',$studentIdList);
        //查询学员与当前所在班级的关系
        $classStudentList= $this->classrefstutea_model->getListByObjClass($classId,$studentIdList,0);
        $studentIdArrOld = array();
        if($classStudentList!=false){
            foreach ($classStudentList as $key => $val) {
                $studentIdArrOld[] = $val->userId;        
            }
        }
        $insertStuArr = array_diff($studentAddArr,$studentIdArrOld);
        if(count($insertStuArr)>0){
            foreach ($insertStuArr as $key => $val) {
                $data = array(
                    'classId' => $classId,
                    'userId' => $val,
                    'type' => 0
                );
                $this->classrefstutea_model->insert($data);
                $this->db->where('id',$classId);
                ++$classInfo->studentNumber;
                $this->db->update('Class', array('studentNumber'=>$classInfo->studentNumber));
            }
        }
        echojson(1,"","加入成功");
    }

    /**
 	* Description : 查询班级下有没有作业
 	* Author      : jishuai
 	* Created Time: 2015-02-09 13:22
	*/
	public function existHomework(){
		$classId = isset($_GET['classId'])?$_GET['classId']:'';
		if(! $this->class_model->existByInsID($classId)) show_404();
		if($this->class_model->existHomework($classId)){
			echojson('0','','因有学员交过作业，此班级无法删除');
		}else{
			echojson('1','','可以删除');
		}
	}

    /**
 	* Description : 根据班级的初夏秋冬获取星期或者学期的选项
 	* Author      : jishuai
 	* Created Time: 2015-02-09 14:16
	*/
	public function getOptionBySeason(){
		$season = isset($_POST['season'])?$_POST['season']:0;
		$tearm = array('第一期','第二期','第三期','第四期','第五期','第六期');
		$week = array('星期一','星期二','星期三','星期四','星期五','星期六','星期日');
		if($season == '1' || $season == '3'){
			echojson('1',$tearm,'');
		}elseif($season == '2' || $season == '4'){
			echojson('1',$week,'');
		}else{
			echojson('0','','异常操作');
		}
	}














}
