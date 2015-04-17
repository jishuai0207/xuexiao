<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class  Schedule extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("classrefstutea_model");
        $this->load->model("schedule_model");
        $this->load->model("teacher_model");
        $this->load->model("lesson_model");
        $this->load->model("classtype_model");
        $this->load->model("class_model");
        $this->ajaxChecklogin();
    }

    /**
     *description:修改排课
     *author:yanyalong
     *date:2014/11/04
     */
    public function modify(){
        $teacherId = (isset($_REQUEST['teacherId'])&&$_REQUEST['teacherId']!="")?$_REQUEST['teacherId']:echojson(0,'','请选择老师');
        $classId= (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:echojson(0,'','异常操作');
        $lessonId= (isset($_REQUEST['lessonId'])&&$_REQUEST['lessonId']!="")?$_REQUEST['lessonId']:echojson(0,'','异常操作');
        $teacherId = (isset($_REQUEST['teacherId'])&&$_REQUEST['teacherId']!="")?$_REQUEST['teacherId']:echojson(0,'','请选择老师');
        $year= (isset($_REQUEST['year'])&&$_REQUEST['year']!="")?$_REQUEST['year']:echojson(0,'','请选择上课年份');
        $mouth= (isset($_REQUEST['mouth'])&&$_REQUEST['mouth']!="")?$_REQUEST['mouth']:echojson(0,'','请选择上课月份');
        $day= (isset($_REQUEST['day'])&&$_REQUEST['day']!="")?$_REQUEST['day']:echojson(0,'','请选择上课天数');
        $start_hour= (isset($_REQUEST['start_hour'])&&$_REQUEST['start_hour']!=""&&(intval($_REQUEST['start_hour'])==$_REQUEST['start_hour'])&&$_REQUEST['start_hour']>-1&&$_REQUEST['start_hour']<24)?$_REQUEST['start_hour']:echojson(0,'','请正确填写上课开始小时');
        $start_minu= (isset($_REQUEST['start_minu'])&&$_REQUEST['start_minu']!=""&&(intval($_REQUEST['start_minu'])==$_REQUEST['start_minu'])&&$_REQUEST['start_minu']>-1&&$_REQUEST['start_minu']<60)?$_REQUEST['start_minu']:echojson(0,'','请正确填写上课开始分钟');
        $end_hour= (isset($_REQUEST['end_hour'])&&$_REQUEST['end_hour']!=""&&(intval($_REQUEST['end_hour'])==$_REQUEST['end_hour'])&&$_REQUEST['end_hour']>-1&&$_REQUEST['end_hour']<24)?$_REQUEST['end_hour']:echojson(0,'','请正确填写上课结束小时');
        $end_minu= (isset($_REQUEST['end_minu'])&&$_REQUEST['end_minu']!=""&&(intval($_REQUEST['end_minu'])==$_REQUEST['end_minu'])&&$_REQUEST['end_minu']>-1&&$_REQUEST['end_minu']<60)?$_REQUEST['end_minu']:echojson(0,'','请正确填写上课结束分钟');
        $start_time = $year.'-'.$mouth.'-'.$day.' '.$start_hour.':'.$start_minu;
        $end_time = $year.'-'.$mouth.'-'.$day.' '.$end_hour.':'.$end_minu;
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        if(strtotime($start_time)<time()) echojson(0,'','上课时间不能早于当前时间');
        if(strtotime($start_time)>strtotime($end_time)||strtotime($start_time)==strtotime($end_time))
            echojson(0,'','结束时间必须晚于开始时间');
        $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$lessonId); 
        if($scheduleInfo==false) echojson(0,'','不存在的排课信息');
        $scheduleId = $scheduleInfo->id;
        //获取当前课节所在班型科目信息
        $scheSubInfo = $this->schedule_model->getSubject($scheduleId);
        //获取当前老师所在科目信息
        $teaSubList = $this->teacher_model->getSubject($teacherId);
        $flag = false;
        foreach ($teaSubList as $key => $val) {
            if($val->id==$scheSubInfo->subject){
                $flag = true;
            } 
        }
        if($flag==false) echojson(0,'','当前老师不属于当前学科');
        //获取任课老师信息，判断是否是当前班级的任课老师
        $res = $this->classrefstutea_model->getInfoByStuClass($scheSubInfo->classId,$teacherId,'1');
        if($res==false||$res->leaveTime!=null||strtotime($res->leaveTime)!=0) echojson(0,'','该老师不在这个班级内');
        $data= array(
            'teacher' => $teacherId,
            'beginTime' => $start_time,
            'endTime' => $end_time
        );
        $this->db->where('id',$scheduleId);
        $this->db->update('Schedule',$data);
        $lessonInfo = $this->lesson_model->getSubject($lessonId);    
        //判断当前课节是否是第一节课
        if($lessonInfo->num=='1'){
            //更新班级结束时间为第一节课的排课时间
            $this->db->where('id',$classId);
            $res = $this->db->update('Class', array('beginTime'=>$start_time));
        }
        //判断当前课节是否是最后一节课
        if($lessonInfo->classNumber==$lessonInfo->num){
            //更新班级结束时间为最后一节课的排课时间
            $this->db->where('id',$classId);
            $res = $this->db->update('Class', array('endTime'=>$end_time));
        }
        echojson(1,'','修改排课成功');
    }
    /**
     *description:添加排课
     *author:yanyalong
     *date:2014/11/04
     */
    public function add(){
        $teacherId = (isset($_REQUEST['teacherId'])&&$_REQUEST['teacherId']!="")?$_REQUEST['teacherId']:echojson(0,'','请选择老师');
        $classId= (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:echojson(0,'','异常操作');
        $lessonId= (isset($_REQUEST['lessonId'])&&$_REQUEST['lessonId']!="")?$_REQUEST['lessonId']:echojson(0,'','异常操作');
        $year= (isset($_REQUEST['year'])&&$_REQUEST['year']!="")?$_REQUEST['year']:echojson(0,'','请选择上课年份');
        $mouth= (isset($_REQUEST['mouth'])&&$_REQUEST['mouth']!="")?$_REQUEST['mouth']:echojson(0,'','请选择上课月份');
        $day= (isset($_REQUEST['day'])&&$_REQUEST['day']!="")?$_REQUEST['day']:echojson(0,'','请选择上课天数');
        $start_hour= (isset($_REQUEST['start_hour'])&&$_REQUEST['start_hour']!=""&&(intval($_REQUEST['start_hour'])==$_REQUEST['start_hour'])&&$_REQUEST['start_hour']>-1&&$_REQUEST['start_hour']<24)?$_REQUEST['start_hour']:echojson(0,'','请正确填写上课开始小时');
        $start_minu= (isset($_REQUEST['start_minu'])&&$_REQUEST['start_minu']!=""&&(intval($_REQUEST['start_minu'])==$_REQUEST['start_minu'])&&$_REQUEST['start_minu']>-1&&$_REQUEST['start_minu']<60)?$_REQUEST['start_minu']:echojson(0,'','请正确填写上课开始分钟');
        $end_hour= (isset($_REQUEST['end_hour'])&&$_REQUEST['end_hour']!=""&&(intval($_REQUEST['end_hour'])==$_REQUEST['end_hour'])&&$_REQUEST['end_hour']>-1&&$_REQUEST['end_hour']<24)?$_REQUEST['end_hour']:echojson(0,'','请正确填写上课结束小时');
        $end_minu= (isset($_REQUEST['end_minu'])&&$_REQUEST['end_minu']!=""&&(intval($_REQUEST['end_minu'])==$_REQUEST['end_minu'])&&$_REQUEST['end_minu']>-1&&$_REQUEST['end_minu']<60)?$_REQUEST['end_minu']:echojson(0,'','请正确填写上课结束分钟');
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $start_time = $year.'-'.$mouth.'-'.$day.' '.$start_hour.':'.$start_minu;
        $end_time = $year.'-'.$mouth.'-'.$day.' '.$end_hour.':'.$end_minu;
        if(strtotime($start_time)<time()) echojson(0,'','上课时间不能早于当前时间');
        if(strtotime($start_time)>strtotime($end_time)||strtotime($start_time)==strtotime($end_time))
            echojson(0,'','结束时间必须晚于开始时间');
        //判断是否存在排课信息
        $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$lessonId);
        if($scheduleInfo!=false) echojson(0,'','该课节已经排过课了');
        //获取任课老师信息，判断是否是当前班级的任课老师
        $res = $this->classrefstutea_model->getInfoByStuClass($classId,$teacherId,'1');
        if($res==false||($res->leaveTime!=null&&strtotime($res->leaveTime)!=0)) echojson(0,'','该老师不在这个班级内');
        $data= array(
            'classId' => $classId,
            'teacher' => $teacherId,
            'lessonId' => $lessonId,
            'beginTime' => $start_time,
            'endTime' => $end_time
        );
        $this->schedule_model->insert($data);
        $lessonInfo = $this->lesson_model->getSubject($lessonId);    
        //判断当前课节是否是第一节课
        if($lessonInfo->num=='1'){
            //更新班级结束时间为第一节课的排课时间
            $this->db->where('id',$classId);
            $res = $this->db->update('Class', array('beginTime'=>$start_time));
        }
        //判断当前课节是否是最后一节课
        if($lessonInfo->classNumber==$lessonInfo->num){
            //更新班级结束时间为最后一节课的排课时间
            $this->db->where('id',$classId);
            $res = $this->db->update('Class', array('endTime'=>$end_time));
        }
        echojson(1,'','添加排课成功');
    }
    /**
     *description:添加代课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function replaceteacheradd(){
        $lessonId = (isset($_REQUEST['lessonId'])&&$_REQUEST['lessonId']!="")?$_REQUEST['lessonId']:echojson(0,'','操作异常');
        $classId= (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:echojson(0,'','操作异常');
        $teacherId= (isset($_REQUEST['teacherId'])&&$_REQUEST['teacherId']!="")?$_REQUEST['teacherId']:echojson(0,'','请选择老师');
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$lessonId);
        if($scheduleInfo==false)  echojson(0,'','内部数据出错');
        if($scheduleInfo->teacher==$teacherId) echojson(0,'','代课老师不能和任课老师重复');
        $scheduleId = $scheduleInfo->id;
        //获取当前课节所在班型科目信息
        $scheSubInfo = $this->schedule_model->getSubject($scheduleId);
        //获取当前老师所在科目信息
        $teaSubList = $this->teacher_model->getSubject($teacherId);
        $flag = false;
        foreach ($teaSubList as $key => $val) {
            if($val->id==$scheSubInfo->subject){
                $flag = true;
            } 
        }
        if($flag==false) echojson(0,'','当前老师不属于当前学科');
        if($scheduleInfo->teacher==$teacherId) echojson(0,'','代课老师不能和任课老师重复');
        $this->db->where('id',$scheduleId);
        $this->db->update('Schedule', array('replaceTeacher'=>$teacherId));
        echojson(1,"","操作成功");
    }
    /**
     *description:更换代课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function replaceteachermod(){
        $lessonId = (isset($_REQUEST['lessonId'])&&$_REQUEST['lessonId']!="")?$_REQUEST['lessonId']:echojson(0,'','操作异常');
        $classId= (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:echojson(0,'','操作异常');
        $teacherId= (isset($_REQUEST['teacherId'])&&$_REQUEST['teacherId']!="")?$_REQUEST['teacherId']:echojson(0,'','请选择老师');
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$lessonId);
        if($scheduleInfo->teacher==$teacherId) echojson(0,'','代课老师不能和任课老师重复');
        $scheduleId = $scheduleInfo->id;
        //获取当前课节所在班型科目信息
        $scheSubInfo = $this->schedule_model->getSubject($scheduleId);
        //获取当前老师所在科目信息
        $teaSubList = $this->teacher_model->getSubject($teacherId);
        $flag = false;
        foreach ($teaSubList as $key => $val) {
            if($val->id==$scheSubInfo->subject){
                $flag = true;
            } 
        }
        if($flag==false) echojson(0,'','当前老师不属于当前学科');
        $this->db->where('id',$scheduleId);
        $this->db->update('Schedule', array('replaceTeacher'=>$teacherId));
        echojson(1,"","操作成功");
    }
    /**
     *description:删除代课老师
     *author:yanyalong
     *date:2014/11/04
     */
    public function replaceteacherdel(){
        $lessonId = (isset($_REQUEST['lessonId'])&&$_REQUEST['lessonId']!="")?$_REQUEST['lessonId']:echojson(0,'','操作异常');
        $classId= (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:echojson(0,'','操作异常');
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$lessonId);
        $scheduleId = $scheduleInfo->id;
        //获取当前课节所在班型科目信息
        if($scheduleInfo!=false&&($scheduleInfo->replaceTeacher!=null&&$scheduleInfo->replaceTeacher!="")){
            $this->db->where('id',$scheduleId);
            $this->db->update('Schedule', array('replaceTeacher'=>null));
        }
        echojson(1,"","操作成功");
    }
}
