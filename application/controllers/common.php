<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Common extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->checklogin();
        $this->config->load('public');
        $this->public_config = $this->config->item('studentInfo');
        $this->sm->assign('menu_hover',$this->left_menu_config['index']);
    }
    /**
     *description:全局无权限跳转页
     *author:yanyalong
     *date:2014/12/17
     */
    public function noauth(){
        $data['title'] = "抱歉,您无权限进行此操作";
        $this->sm->view('common/noAuth',$data);  
    }
}

