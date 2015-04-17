<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class  Index extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("class_model");
        loadLib('Operation_data');
        $this->ajaxChecklogin();
    }
    /**
     *description:今日课程
     *author:yanyalong
     *date:2014/11/04
     */
    public function index(){
        $page = isset($_REQUEST['p'])?$_REQUEST['p']:'1';
        $row = 30;
        $res = $this->class_model->classTodayLesson($_SESSION['institution'],$page,$row);
        if($res==false) echojson(0,"","今日没有课程");
        foreach ($res['list'] as $key => $val) {
            $todaylist[$key]['classurl'] = '/'.$this->url_config['classInfo']."?classId=".$val->classId;
            $todaylist[$key]['className'] = $val->className;
            $todaylist[$key]['scheduleTime'] = date('Y-m-d H:i',strtotime($val->beginTime))."-".date('H:i',strtotime($val->endTime));
            $todaylist[$key]['teacherTruethName'] = $val->teacherTruethName;
            $todaylist[$key]['TeacherNickname'] = ($val->TeacherNickname!=""&&$val->TeacherNickname!=$val->teacherTruethName)?"(".$val->TeacherNickname.")":"";
            $todaylist[$key]['replaceTeacherTruthName'] = ($val->replaceTeacherTruthName!=null)?$val->replaceTeacherTruthName:"无";
        }
        $data['today_list']  = $todaylist;
        $operation_data =new Operation_data(); 
        $operation_data->base_url = $this->view_config['todaySchedule'];
        $operation_data->total_rows = $res['count'];
        $operation_data->per_page = $row;
        $operation_data->cur_page= $page;
        $data['page'] = $operation_data->show_page_ajax();
        echojson(1,$data);
    }
}

