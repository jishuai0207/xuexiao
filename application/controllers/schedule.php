<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class  Schedule extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->sm->assign('menu_hover',$this->left_menu_config['class']);
        $this->load->model('classtype_model');
        $this->load->model('class_model');
        $this->load->model('schedule_model');
    }
    /**
     *description:上传课表页
     *author:yanyalong
     *date:2014/11/04
     */
    public function upload(){
        $this->checklogin();
        $data['classId'] = (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:"";
        $data['step'] = (isset($_REQUEST['step'])&&(in_array($_REQUEST['step'],array('1','2'))))?$_REQUEST['step']:"1";
        $data['fileMd5'] = (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:"";
        $data['status'] = (isset($_REQUEST['status'])&&(in_array($_REQUEST['status'],array('1','0'))))?$_REQUEST['status']:"0";
        $data['isup'] = (isset($_REQUEST['isup'])&&(in_array($_REQUEST['isup'],array('1'))))?$_REQUEST['isup']:"0";
        //查询班级信息
        $classInfo = $this->class_model->get($data['classId']);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            show_404('不存在的班级');exit;
        }
        if($data['step']=='1')
            $data['status'] = '0';
        if($data['status']=='0')
            $data['step'] = '1';
        $this->sm->view('schedule/index',$data); 
    }
    /**
     *description:上传排课信息表
     *author:yanyalong
     *date:2014/11/10
     */
    public function doupload(){
        $this->checklogin();
        $classId = (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:'';
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            show_404('不存在的班级');exit;
        }
        //获取班级老师列表
        //获取任课老师列表数据
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        $teacherCount = count($teacherList);
        if($teacherCount==2&&($teacherList[0]->truthName==$teacherList[1]->truthName)){
            $status = '0';
            $step = 1;
            $fileMd5Para = "";
        }else{
            $this->config->load('uploads');		
            $config = $this->config->item("schedule");		
            $this->load->library('upload');
            $_FILES['userfile'] = $_FILES['UpLoadFile'];
            //上传图片文件
            $is_upload = $this->upload->upload_file($config);
            if(empty($is_upload)||$classId==""){
                $status = '0';
                $step = 1;
                $fileMd5Para = "";
            }else{
                $status = '1';
                $step = 2;
                $fileMd5 = trim($is_upload['upload_data']['file_name'],'.xlsx');
                $fileMd5Para = "&fileMd5=".$fileMd5;
            }
        }
        $data['classId'] = $classId;
        $url = '/'.$this->url_config['scheduleUpload'].'?classId='.$classId.'&step='.$step.'&status='.$status.$fileMd5Para.'&isup=1';
        header("Location:".$url);exit; 
    }
    /**
     *description:获取文件上传反馈错误信息
     *author:yanyalong
     *date:2014/11/19
     */
    public function uploadstatus(){
        $this->ajaxChecklogin();
        $status = (isset($_REQUEST['status'])&&$_REQUEST['status']!="")?$_REQUEST['status']:'0';
        $fileMd5= (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!="")?$_REQUEST['fileMd5']:'';
        $classId= (isset($_REQUEST['classId'])&&$_REQUEST['classId']!="")?$_REQUEST['classId']:'';
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        if($status=='0'){
            echojson(0,"",'上传失败,文件格式与模版文件不符');
        }
        $this->config->load('uploads');     
        $config = $this->config->item("schedule");      
        //判断文件是否存在
        $sourcefile = $config['upload_path'].$fileMd5.".xlsx";
        //判断文件是否存在
        if (!file_exists($sourcefile)) echojson(0,"",'文件不存在');
        //开始处理excel文件，最终生成数组
        //加载PHPexcel
        loadLib("excel/PHPExcel");
        loadLib("excel/PHPExcel/IOFactory");
        $type = 'Excel2007';
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
        //判断列数是否与要求相同
        if($highestColumnIndex!=5){
            //unlink($sourcefile);
            echojson(0,"",'请使用标准模板');
        }
        $classinfo = $this->classtype_model->getCTByClassId($classId);
        $tagthme = array();
        for($row = 1;$row<= $highestRow;$row++){
            $tagthme = array();
            //首项第一行
            for($i=0;$i<$highestColumnIndex;$i++ ){
                //当前字段值
                $current_row_value =strval($objWorksheet->getCellByColumnAndRow($i, $row)->getValue());
                switch ($i) {
                case '0':
                    $column_name = "num";
                    break;
                case '1':
                    $column_name = "date";
                    break;
                case '2':
                    $column_name = "startTime";
                    break;
                case '3':
                    $column_name = "endTime";
                    break;
                case '4':
                    $column_name = "teacherName";
                    break;
                }
                $res[$row-1][$column_name] = $current_row_value;
                if($row==1){
                    $columnres[] = $current_row_value;
                }
            }
        }
        foreach($res as $key => $val){
            if($key!=0&&$key<($classinfo->classNumber+1)){
                $numres[] = intval($val['num']);
            }else{
                $tempRow = array_filter($val);
                if(!$tempRow) unset($res[$key]);
            }
        }
        $numarr = array();
        for ($i=1;$i<=$classinfo->classNumber;$i++) {
            $numarr[] = $i;
        }
        if(count($res)-1!=count($numres)||$numarr!=$numres){
            //unlink($sourcefile);
            echojson(0,"",'请不要删除讲次序号或改变顺序');
        }
        //判断字段是否一致
        $schedulecolumn_config = $this->config->item("scheduleFileColumn");		
        if($schedulecolumn_config!=$columnres){
            //unlink($sourcefile);
            echojson(0,"",'请使用标准模板');
        }
        $url = '/'.$this->url_config['classScheduleStep2']."?classId=".$classId;
        $data['url'] = $url;
        echojson(1,$data,'上传成功');
    }
    /**
     *description:上传课表第2页
     *author:yanyalong
     *date:2014/11/04
     */
    public function check(){
        $this->checklogin();
        $classId = isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            show_404('不存在的班级');exit;
        }
        if($classId==""||$fileMd5==""){
            $data['classId'] = "";
            $data['fileMd5'] = "";
        }else{
            $data['classId'] = $classId;
            $data['fileMd5'] = $fileMd5;
        }
        $data['title'] = "上传排课信息表";
        $this->sm->view('schedule/check',$data); 
    }
    /**
     *description:上传课表成功页
     *author:yanyalong
     *date:2014/11/04
     */
    public function success(){
        $this->checklogin();
        $classId = (isset($_REQUEST['classId'])&&$_REQUEST['classId']!='')?$_REQUEST['classId']:"";
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            show_404('不存在的班级');exit;
        }
        $data['classList'] = '/'.$this->url_config['classList'];
        if($classId=='') {
            header("Location:".$data['classList']);exit;
        }
        $data['title'] = "批量排课成功";
        $data['classInfoUrl'] = '/'.$this->url_config['classInfo'].'?classId='.$classId.'&pageType=schedule';
        $this->sm->view('schedule/success',$data);
    }
    /**
     *description:上传排课信息表第1步上传成功展示结果
     *author:yanyalong
     *date:2014/11/04
     */
    public function uploadstep1(){
        $this->ajaxChecklogin();
        $this->config->load('uploads');     
        $config = $this->config->item("schedule");      
        $classId = isset($_REQUEST['classId'])?$_REQUEST['classId']:"";
        $fileMd5= isset($_REQUEST['fileMd5'])?$_REQUEST['fileMd5']:"";
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        //判断文件是否存在
        $fileName= $config['upload_path'].$fileMd5.".xlsx";
        if($classId==""||$fileMd5==""){
            //unlink($fileName);
            echojson(0,'','异常操作');
        }
        if(!file_exists($fileName)) echojson(0,'','找不到路径');
        $data = $this->checkSchedule($fileName,$classId);
        if($data['msg_count']>0){
            //unlink($fileName);
            echojson(0,$data,"有".$data['msg_count']."讲信息有问题");
        }
        else
            echojson(1,$data,'');
    }
    /**
     *description:上传排课信息表第2步提交(录入)
     *author:yanyalong
     *date:2014/11/04
     */
    public function uploadstep2(){
        $this->ajaxChecklogin();
        $this->config->load('uploads');      
        $config = $this->config->item("schedule");      
        $classId = (isset($_REQUEST['classId'])&&$_REQUEST['classId']!='')?$_REQUEST['classId']:"";
        $fileMd5= (isset($_REQUEST['fileMd5'])&&$_REQUEST['fileMd5']!='')?$_REQUEST['fileMd5']:"";
        //查询班级信息
        $classInfo = $this->class_model->get($classId);
        if($classInfo==false||$classInfo->institution!=$_SESSION['institution']){
            echojson(0,"","不存在的班级");
        }
        //获取任课老师列表数据
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        $teacherCount = count($teacherList);
        if($teacherCount==2&&($teacherList[0]->truthName==$teacherList[1]->truthName)){
            echojson(0,"",'抱歉，目前在两个任课老师真实姓名相同时，暂不支持批量排课');
        }
        //判断文件是否存在
        $fileName= $config['upload_path'].$fileMd5.".xlsx";
        if($classId==""||$fileMd5==""){
            //unlink($fileName);
            echojson(0,'','异常操作');
        }
        if(!file_exists($fileName)) echojson(0,'','找不到文件');
        $res = $this->checkSchedule($fileName,$classId);
        if($res['msg_count']>0) {
            //unlink($fileName);
            echojson(0,'','异常操作'); 
        }
        //获取班级信息(包含课节数)
        $classInfo = $this->class_model->getClassInfo($classId,$_SESSION['institution']);
        foreach ($res['list'] as $key => $val) {
            $beginTime =  $val['date'].' '.$val['startTime'];
            $endTime =  $val['date'].' '.$val['endTime'];
            if($val['isupdate']==1){
                //查询排课信息是否存在
                $scheduleInfo = $this->schedule_model->getInfoByClassId($classId,$val['lessonId']);
                if($scheduleInfo!=false){
                    //若存在，则更新
                    $update_data= array(
                        'teacher' => $val['teacherId'],
                        'beginTime' => $beginTime,
                        'endTime' => $endTime
                    );
                    $this->db->where('id',$scheduleInfo->id);
                    $this->db->update('Schedule',$update_data);
                }else{
                    //若不存在，则插入新数据
                    $insert_data= array(
                        'classId' => $classId,
                        'lessonId' => $val['lessonId'],
                        'teacher' => $val['teacherId'],
                        'beginTime' => $beginTime,
                        'endTime' => $endTime
                    );
                    $this->schedule_model->insert($insert_data);
                }
                //判断当前课节是否是第一节课
                if($val['num']=='1'){
                    //更新班级结束时间为第一节课的排课时间
                    $this->db->where('id',$classId);
                    $res = $this->db->update('Class', array('beginTime'=>$beginTime));
                }
                //判断当前课节是否是最后一节课
                if($classInfo->classNumber==$val['num']){
                    //更新班级结束时间为最后一节课的排课时间
                    $this->db->where('id',$classId);
                    $res = $this->db->update('Class', array('endTime'=>$endTime));
                }
            }
        }
        $url = '/'.$this->url_config['classScheduleSuccess']."?classId=".$classId;
        $data['url'] = $url;
        //unlink($fileName);
        echojson(1,$data,'操作成功');
    }
    /**
     *description:检测排课信息
     *author:yanyalong
     *date:2014/11/10
     */
    public function checkSchedule($fileName,$classId){
        $this->ajaxChecklogin();
        //加载PHPexcel
        loadLib("excel/PHPExcel");
        loadLib("excel/PHPExcel/IOFactory");
        if (!file_exists($fileName)) echojson(0,'','文件不存在');
        //开始处理excel文件，最终生成数组
        $type = 'Excel2007';
        $xlsReader = PHPExcel_IOFactory::createReader($type);
        $objPHPExcel = PHPExcel_IOFactory::load($fileName);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $xlsReader->setReadDataOnly(true);
        $xlsReader->setLoadSheetsOnly(true);
        $Sheets = $xlsReader->load($fileName);
        //开始读取
        $objSheets = $Sheets->getSheet(0);
        $highestRow = $objSheets->getHighestRow(); //行数
        $classInfo = $this->classtype_model->getCTByClassId($classId);
        $highestColumn = $objSheets->getHighestColumn(); //取得总列 
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数

        //判断列数是否与要求相同
        if($highestColumnIndex!=5){
            //unlink($sourcefile);
            echojson(0,"",'讲次列数与模版文件不符');
        }
        $classinfo = $this->classtype_model->getCTByClassId($classId);
        $tagthme = array();
        for($row = 1;$row<= $highestRow;$row++){
            $tagthme = array();
            //首项第一行
            for($i=0;$i<$highestColumnIndex;$i++ ){
                //当前字段值
                $current_row_value =strval($objWorksheet->getCellByColumnAndRow($i, $row)->getValue());
                switch ($i) {
                case '0':
                    $column_name = "num";
                    break;
                case '1':
                    $column_name = "date";
                    break;
                case '2':
                    $column_name = "startTime";
                    break;
                case '3':
                    $column_name = "endTime";
                    break;
                case '4':
                    $column_name = "teacherName";
                    break;
                }
                $res[$row-1][$column_name] = $current_row_value;
                if($row==1){
                    $columnres[] = $current_row_value;
                }
            }
        }
        foreach($res as $key => $val){
            if($key!=0&&$key<($classinfo->classNumber+1)){
                $numres[] = intval($val['num']);
            }else{
                $tempRow = array_filter($val);
                if(!$tempRow) unset($res[$key]);
            }
        }
        $numarr = array();
        for ($i=1;$i<=$classinfo->classNumber;$i++) {
            $numarr[] = $i;
        }
        if(count($res)-1!=count($numres)||$numarr!=$numres){
            //unlink($sourcefile);
            echojson(0,"",'讲次顺序与模版文件不符');
        }
        //判断字段是否一致
        $schedulecolumn_config = $this->config->item("scheduleFileColumn");		
        if($schedulecolumn_config!=$columnres){
            //unlink($sourcefile);
            echojson(0,"",'首行标题与模版文件不符');
        }
        unset($res[0]);
        foreach ($res as $key => $val) {
            $list[$key]['num'] = $val['num'];
            if(date('Ymd',strtotime($val['date']))==$val['date']){
                $list[$key]['date'] = $val['date'];
            }else{
                $list[$key]['date'] = "";
            }
            if($val['startTime']==""){
                $list[$key]['startTime']="";
            }else{
                if(date('H:i',strtotime($val['startTime']))==$val['startTime']){
                    $list[$key]['startTime'] = $val['startTime'];
                }else{
                    if(gmdate('H:i',intval(($val['startTime'])*3600*24+1))!="00:00"){
                        $list[$key]['startTime'] = gmdate('H:i',intval(($val['startTime'])*3600*24+1));
                    }else{
                        $list[$key]['startTime'] = "";
                    }
                }
            }
            if($val['endTime']==""){
                $list[$key]['endTime']="";
            }else{
                if(date('H:i',strtotime($val['endTime']))==$val['endTime']){
                    $list[$key]['endTime'] = $val['endTime'];
                }else{
                    if(gmdate('H:i',intval(($val['endTime'])*3600*24+1))!="00:00"){
                        $list[$key]['endTime'] = gmdate('H:i',intval(($val['endTime'])*3600*24+1));
                    }else{
                        $list[$key]['endTime'] = "";
                    }
                }
            }
            $list[$key]['teacherName'] =$val['teacherName'];
        }
        $teacherList = $this->class_model->getTeacherbyClassList($classId);
        if($teacherList==false) echojson('0','','数据异常，请确认该班级有老师');
        $countTeacher = count($teacherList);
        $excelNewArr = array();
        foreach ($teacherList as $keys => $vals) {
            $teacherArr[$vals->truthName]['truthName'] = $vals->truthName;
            $teacherArr[$vals->truthName]['teacherId'] = $vals->teacherId;
            $teacherArr[$vals->truthName]['nickname'] = $vals->nickname;
        }
        foreach ($teacherList as $keys => $vals) {
            $teacherNameArr[] = $vals->truthName;
        }
        $msgArr = array();
        //查询班级课程
        $LessonList = $this->class_model->getLessonByClass($classId);
        if(! $LessonList) echojson(0,'','异常操作');
        $scheduleList = $this->class_model->getScheduleListByClass($classId);
        $classInfo = $this->classtype_model->getCTByClassId($classId);
        if($classInfo==false) echojson(0,'','异常操作');
        $countList = count($scheduleList);
        $allNumArr = array();
        for ($i=1; $i<=$classInfo->classNumber; $i++) {
            $allNumArr[] = strval($i);
        }
        $readyNumArr = array();
        $newList = array();
        if(!empty($scheduleList)){
            foreach ($scheduleList as $key => $val) {
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
                    $newList[$i]['nickName']= "";
                    $newList[$i]['teacherId']= "";
                }
            }
        }
        $newList = arraysort($newList,'num');
        foreach ($list as $key => $val) {
            $excelNewArr[$key]['num'] = $val['num']; 
            $excelNewArr[$key]['lessonName'] = $LessonList[$key-1]->lessonName; 
            $excelNewArr[$key]['lessonId'] = $LessonList[$key-1]->id; 
            if($val['date']==''||$val['date']!=date('Ymd',strtotime($val['date']))){
                $excelNewArr[$key]['date'] = "信息无效"; 
            }else{
                $excelNewArr[$key]['date']= date('Y-m-d',strtotime($val['date']));
            }
            if($val['startTime']==''||$val['startTime']=='00:00'||$val['startTime']!=date('H:i',strtotime($val['startTime']))){
                $excelNewArr[$key]['startTime']= "信息无效"; 
            }else{
                $excelNewArr[$key]['startTime']= $val['startTime'];
            }
            if($val['endTime']==''||$val['endTime']=='00:00'||$val['endTime']!=date('H:i',strtotime($val['endTime']))||strtotime($val['endTime'])<strtotime($val['startTime'])||strtotime($val['endTime'])==strtotime($val['startTime'])){
                $excelNewArr[$key]['endTime'] = "信息无效"; 
                $excelNewArr[$key]['datetime'] = "信息无效"; 
            }else{
                $excelNewArr[$key]['endTime'] = $val['endTime'];
            }
            if(strtotime($val['date']." ".$val['startTime'])<time()||strtotime($val['date']." ".$val['endTime'])<time()){
                $excelNewArr[$key]['startime'] = "信息无效"; 
                $excelNewArr[$key]['endTime'] = "信息无效"; 
                $excelNewArr[$key]['datetime'] = "信息无效"; 
            }
            if($countTeacher==2){
                if($val['teacherName']==""){
                    $excelNewArr[$key]['teacherName'] = "信息无效"; 
                }else{
                    if(in_array($val['teacherName'],$teacherNameArr)){
                        $excelNewArr[$key]['teacherName'] = $val['teacherName']; 
                        $excelNewArr[$key]['teacherId'] = $teacherArr[$val['teacherName']]['teacherId']; 
                        if($teacherArr[$val['teacherName']]['nickname']!=""){
                            $excelNewArr[$key]['teacherName'] .= '('.$teacherArr[$val['teacherName']]['nickname'].')';
                        }
                        $excelNewArr[$key]['teacherUrl'] =  '/'.$this->url_config['teacherInfo'].'?teacherId='.$teacherArr[$val['teacherName']]['teacherId']; 
                    }else{
                        $excelNewArr[$key]['teacherName'] = "信息无效"; 
                        $excelNewArr[$key]['teacherUrl'] = ""; 
                    }
                }
            }else{
                if($val['teacherName']==""||in_array($val['teacherName'],$teacherNameArr)){
                    $teacherId = $teacherList[0]->teacherId;
                    $truthName = $teacherList[0]->truthName;
                    $nickname= $teacherList[0]->nickname;
                    $excelNewArr[$key]['teacherName'] = $truthName; 
                    if($nickname!=""&&$nickname!=$truthName){
                        $excelNewArr[$key]['teacherName'] .= '('.$nickname.')'; 
                    }
                    $excelNewArr[$key]['teacherUrl'] =  '/'.$this->url_config['teacherInfo'].'?teacherId='.$teacherId; 
                    $excelNewArr[$key]['teacherId'] =  $teacherId; 
                }else{
                    $excelNewArr[$key]['teacherName'] = "信息无效"; 
                    $excelNewArr[$key]['teacherUrl'] = ""; 
                    $excelNewArr[$key]['teacherId'] = ""; 
                }
            }
            if($excelNewArr[$key]['date']=='信息无效'||$excelNewArr[$key]['startTime']=='信息无效'||$excelNewArr[$key]['endTime']=='信息无效'){
                $excelNewArr[$key]['datetime'] = "信息无效"; 
            }else{
                $excelNewArr[$key]['datetime'] = $excelNewArr[$key]['date']." ".$excelNewArr[$key]['startTime'].'-'.$excelNewArr[$key]['endTime'];
            }
            foreach ($newList as $keyss => $valss) {
                if($valss['num']==$val['num']){
                    //判断是否已排课
                    if($valss['beginTime']!=""){
                        //若已排过课
                        $excelNewArr[$key]['datetime'] = $val['date']." ".$val['startTime'].'-'.$val['endTime'];
                        if(strtotime($val['date']." ".$val['startTime'])<time()){
                            if((strtotime($val['date']." ".$val['startTime'])==strtotime($valss['beginTime']))&&(strtotime($val['date']." ".$val['endTime'])==strtotime($valss['endTime']))){
                                if($val['teacherName']!=$valss['truthName']){
                                    $excelNewArr[$key]['datetime'] = "信息无效";
                                    $excelNewArr[$key]['teacherName'] = '信息无效';
                                    continue;
                                }else{
                                    $excelNewArr[$key]['teacherName'] = $val['teacherName']; 
                                    if($valss['nickName']!=""){
                                        $excelNewArr[$key]['teacherName'] .= '('.$valss['nickName'].')';
                                    }
                                    $excelNewArr[$key]['teacherId'] = $valss['teacherId']; 
                                    $excelNewArr[$key]['teacherUrl'] =  '/'.$this->url_config['teacherInfo'].'?teacherId='.$valss['teacherId']; 
                                }
                            }else{
                                $excelNewArr[$key]['datetime'] = "信息无效";
                            }
                        }
                    }
                }
            }
            if($val['date']==''&&$val['startTime']==''&&$val['endTime']==''&&$val['teacherName']==''){
                $msgArr[] = $val['num'];
                $excelNewArr[$key]['isupdate'] = "0";
            }else{
                if($excelNewArr[$key]['datetime']=='信息无效'||$excelNewArr[$key]['teacherName']=='信息无效'){
                    $msgArr[] = $val['num'];
                    $excelNewArr[$key]['isupdate'] = "0";
                }else{
                    $excelNewArr[$key]['isupdate'] = "1";
                }
            }
        }
        $data['list'] = array_values($excelNewArr);
        $data['checkMsg'] = $msgArr;
        $data['msg_count'] = count($msgArr);
        return $data; 
    }
}

