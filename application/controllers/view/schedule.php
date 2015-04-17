<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class  Schedule extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->config('public');
        $this->load->model('class_model');
        $this->load->model('schedule_model');
        $this->load->model("classtype_model");
        $this->ajaxChecklogin();
    }
    /**
     *description:添加排课
     *author:yanyalong
     *date:2014/11/04
     */
    public function add(){
        $classId = isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $lessonId= isset($_REQUEST['lessonId'])?$_REQUEST['lessonId']:echojson(0,'','异常操作');
        $action= (isset($_REQUEST['action'])&&(in_array($_REQUEST['action'],array('add','mod'))))?$_REQUEST['action']:echojson(0,'','异常操作');
        //获取任课老师
        $teacherlist = $this->class_model->getTeacherByClassId($classId);
        if($teacherlist==false)  echojson(0,'','数据异常，当前班级还没有任课老师');
        if($action=='add'){
            foreach ($teacherlist as $key => $val) {
                $data['teacherlist'][$key]['teacherId'] = $val->id; 
                $data['teacherlist'][$key]['truthName'] = $val->truthName; 
                $data['teacherlist'][$key]['is_select'] = 0; 
            }
        }else{
            $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$lessonId); 
            if($scheduleInfo==false) echojson(0,'','不存在的排课信息');
            foreach ($teacherlist as $key => $val) {
                $data['teacherlist'][$key]['teacherId'] = $val->id; 
                $data['teacherlist'][$key]['truthName'] = $val->truthName; 
                $data['teacherlist'][$key]['is_select'] = 0; 
                if($action=='mod'){
                    if($val->id==$scheduleInfo->teacher){
                        $data['teacherlist'][$key]['is_select'] = 1; 
                    }
                }
            }
        }
        //获取上课日期列表
        $data['yearlist'] = array(intval(date('Y')),date('Y')+1);
        echojson(1,$data,'无相关信息');
    }
    /**
     *description:获取上课小时
     *author:yanyalong
     *date:2014/11/08
     */
    public function getHour(){
        $_REQUEST['date']= "2014-11-8";
        $curDate= isset($_REQUEST['date'])?$_REQUEST['date']:echojson(0,'','异常操作');
        if(strtotime(date('Y-m-d'))>strtotime($curDate)) echojson(0,'','异常操作');
        //根据判断所选日期是否等于今天，若等于，则生成从当前小时开始的之后所有小时列表，否则，则返回所有小时
        if(strtotime($curDate)==strtotime(date('Y-m-d'))) $hournum = date('H');
        else $hournum = 6;
        $hourArr= array('-');
        for ($i=$hournum;$i<=22;$i++) {
            $hourArr[] = intval($i);
        }
        echojson(1,$hourArr);
    }
    /**
     *description:获取上课分钟
     *author:yanyalong
     *date:2014/11/08
     */
    public function getMinute(){
        $_REQUEST['date']= "2014-11-8-18";
        $curHour= isset($_REQUEST['date'])?$_REQUEST['date']:echojson(0,'','异常操作');
        if(strtotime(date('Y-m-d-H'))>strtotime($curHour)) echojson(0,'','异常操作');
        //根据判断所选小时是否等于当前小时，若等于，则生成从当前分钟所在组开始的之后所有分钟组列表，否则，则返回所有分钟组
        $minutrArrAll = array();
        for ($i=0;$i<60;$i++) {
            if($i%5==0){
                $minutrArrAll[] = $i;
            } 
        }
        if(strtotime($curHour)==strtotime(date('Y-m-d-H'))){
            foreach ($minutrArrAll as $key => $val) {
                if(ceil($val/5)==ceil((date('H',strtotime($curHour)))/5)){
                    $minuNum = $val-1;
                    break;
                }
            }
        }else{
            $minuNum=0; 
        }
        $minuArr= array('-');
        for ($i=$minuNum;$i<=count($minutrArrAll);$i++) {
            $minuArr[] = intval($i)*5;
        }
        echojson(1,$minuArr);
    }
    /**
     *description:获取指定年月的天数
     *author:yanyalong
     *date:2014/11/08
     */
    public function getDaysListByMonth(){
        $year= isset($_REQUEST['year'])?$_REQUEST['year']:echojson(0,'','异常操作');
        $month= isset($_REQUEST['month'])?$_REQUEST['month']:echojson(0,'','异常操作');
        $curYearMonth = date('Y-m');
        $curMonth = date('m');
        //先确定月份的总天数
        //确定当前月份是否和指定月份相同，若相同则返回从今天开始的剩余天列表，否则返回该月份所有天列表
        $days = getDaysByMonth($year,$month);
        // if(strtotime($curYearMonth)==strtotime($year.'-'.$month)) $daynum = date('d');
        // else 
        $daynum = 1;
        for ($i=$daynum;$i<=$days;$i++) {
            $dayArr[] = intval($i);
        }
        echojson(1,$dayArr);
    }
    /**
     *description:获取指定年从本月开始的月列表
     *author:yanyalong
     *date:2014/11/08
     */
    public function getMonthsListByYear(){
        //$_REQUEST['year']= "2015";
        $year= isset($_REQUEST['year'])?$_REQUEST['year']:echojson(0,'','异常操作');
        $curYear = date('Y');
        if($curYear>$year) echojson(0,'','异常操作');
        if($curYear==$year) $monthnum = date('m');
        else $monthnum = 1; 
        $monthArr = array('-');
        for ($i=$monthnum;$i<=12;$i++) {
            $monthArr[] = intval($i);
        }
        echojson(1,$monthArr);
    }
    /**
     *description:修改排课
     *author:yanyalong
     *date:2014/11/04
     */
    public function modify(){
        $classId = isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $scheduleId= isset($_REQUEST['scheduleId'])?$_REQUEST['scheduleId']:echojson(0,'','异常操作');
        $scheduleInfo = $this->schedule_model->get($scheduleId); 
        if($scheduleInfo==false) echojson(0,'','不存在的排课信息');
        //获取上课日期列表
        $data['yearlist'] = array(intval(date('Y')),date('Y')+1);
        //获取任课老师
        $teacherlist = $this->class_model->getTeacherByClassId($classId);
        if($teacherlist==false)  echojson(0,'','操作异常，当前班级还没有任课老师');
        foreach ($teacherlist as $key => $val) {
            $data['teacherlist'][$key]['teacherId'] = $val->id; 
            $data['teacherlist'][$key]['truthName'] = $val->truthName; 
            $data['teacherlist'][$key]['is_select'] = 0; 
            if($val->id==$scheduleInfo->teacher){
                $data['teacherlist'][$key]['is_select'] = 1; 
            }
        }
        ////获取上课年份列表
        //$yearlist['0']['year'] = intval(date('Y'));
        //$yearlist['1']['year'] = ''.date('Y')+1;
        //foreach ($yearlist as $key => $val) {
        //$yearlist[$key]['is_select'] = 0; 
        //if(strtotime($val['year'])==strtotime(date('Y',strtotime($scheduleInfo->beginTime)))){
        //$yearlist[$key]['is_select'] = 1; 
        //}
        //}
        //$schedule['year'] = $yearlist;
        ////获取上课月份列表
        //$yearinfo = date('Y',strtotime($scheduleInfo->beginTime));
        //$curYear = date('Y');
        //if($curYear>$year) echojson(0,'','异常操作');
        //if($curYear==$year) $monthnum = date('m');
        //else $monthnum = 1; 
        //$monthArr = array('-');
        //for ($i=$monthnum;$i<=12;$i++) {
        //$monthArr[] = intval($i);
        //} 

        ////获取排课信息
        //$scheduleInfo['mouth'] =date('m',strtotime($scheduleInfo->beginTime)); 
        //$scheduleInfo['day'] = date('d',strtotime($scheduleInfo->beginTime));
        //$scheduleInfo['start_hour'] = date('H',strtotime($scheduleInfo->beginTime));
        //$scheduleInfo['start_minu'] =date('i',strtotime($scheduleInfo->beginTime)); 
        //$scheduleInfo['end_hour'] = date('H',strtotime($scheduleInfo->endTime));
        //$scheduleInfo['end_minu'] = date('i',strtotime($scheduleInfo->endTime));

        ////获取上课日期列表
        //$data['yearlist'] = array(intval(date('Y')),date('Y')+1);
        echojson(1,$data);
    }
    /**
     *description:下载排课信息
     *author:yanyalong
     *date:2014/11/04
     */
    public function download(){
        $this->load->model("student_model");
        $this->load->model("class_model");
        $classId= isset($_REQUEST['classId'])?$_REQUEST['classId']:echojson(0,'','异常操作');
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        if(count($teacherList)==2&&($teacherList['0']->truthName==$teacherList['1']->truthName))
            echojson(0,'','抱歉，目前在两个任课老师真实姓名相同时，暂不支持批量排课');
        $list = $this->class_model->getScheduleListByClass($classId);
        $classInfo = $this->classtype_model->getCTByClassId($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $countList = count($list);
        $allNumArr = array();
        for ($i=1; $i<=$classInfo->classNumber; $i++) {
            $allNumArr[] = strval($i);
        }
        $readyNumArr = array();
        $newList = array();
        if(!empty($list)){
            foreach ($list as $key => $val) {
                $readyNumArr[] = $val['num'];
                $newList[$val['num']] = $val;
            }
        }
        $noReadyNumArr = array_diff($allNumArr,$readyNumArr);
        if(!empty($noReadyNumArr)){
            for ($i=1;$i<=$classInfo->classNumber; $i++) {
                if(in_array(strval($i),$noReadyNumArr)){
                    $newList[$i]['num']= strval($i);
                    $newList[$i]['date'] = "";
                    $newList[$i]['beginTime']= "";
                    $newList[$i]['endTime']= "";
                    $newList[$i]['truthName']= "";
                }
            }
        }
        $newList = arraysort($newList,'num');
        loadLib("excel/PHPExcel");
        loadLib("excel/PHPExcel/IOFactory");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")->setLastModifiedBy("Maarten Balliauw")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0);
        $objRichText = new PHPExcel_RichText();
        // 列宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(54);

        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // 行高
        for($i = 1; $i <=200; $i++) {
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(35);
        }
        $this->config->load('uploads');		
        $scheduleColumn_config = $this->config->item("scheduleFileColumn");		
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $scheduleColumn_config['0']);
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $scheduleColumn_config['1']);
        $objPHPExcel->getActiveSheet()->setCellValue('C1', $scheduleColumn_config['2']);
        $objPHPExcel->getActiveSheet()->setCellValue('D1', $scheduleColumn_config['3']);
        $objPHPExcel->getActiveSheet()->setCellValue('E1', $scheduleColumn_config['4']);
        $i = 2;
        foreach ($newList as $key=>$val) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$val['num']);
            if($val['beginTime']!=null){
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,date("Ymd",strtotime($val['beginTime'])));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,date("H:i",strtotime($val['beginTime'])));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,date("H:i",strtotime($val['endTime'])));
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,"");
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,"");
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,"");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$val['truthName']);
            $i++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('排课信息');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileName = md5(time().rand(1,9999999));
        $objWriter->save($_SERVER['DOCUMENT_ROOT'].'/uploads/temp/'.$fileName.'.xlsx');
        $data['downLoadurl'] = '/'.$this->view_config['Scheduledownloadfile']."?fileMd5=".$fileName."&classId=".$classId; 
        echojson(1,$data,"下载成功");
    }
    /**
     *description:读取文件并下载
     *author:yanyalong
     *date:2014/11/26
     */
    public function downloadfile(){
        $fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
        $classId = isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $classInfo = $this->classtype_model->getCTByClassId($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        $fileName = "排课模版_".$classInfo->TeacherName.'_'.$classInfo->classCode."_".date("Ymd").".xlsx";
        $file = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/'.$fileMd5.'.xlsx';
        sendFile($fileName,'',array('filepath'=>$file));
    }
    /**
     *description:判断是否允许上传课节信息表
     *author:yanyalong
     *date:2014/12/01
     */
    public function checkIsAllowUpload(){
        $classId = (isset($_REQUEST['classId'])&&$_REQUEST['classId']!='')?$_REQUEST['classId']:echojson(0,"","异常操作");
        $classInfo = $this->classtype_model->getCTByClassId($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        //获取任课老师列表数据
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        $teacherCount = count($teacherList);
        if($teacherCount==2&&($teacherList[0]->truthName==$teacherList[1]->truthName)){
            echojson(0,"",'抱歉，目前在两个任课老师真实姓名相同时，暂不支持批量排课');
        }
        $data['url']= '/'.$this->url_config['scheduleUpload']."?classId=".$classId;
        echojson(1,$data);
    }
}
