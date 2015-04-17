<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Login extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->checklogin();
        //$this->get();
    }
    /**
     *description:忘记、重置密码页
     *author:yanyalong
     *date:2014/11/04
     */
    public function forgetpass(){
        $data['title'] = "重置密码";
        $data['session_info']['insName'] = "";
        $this->sm->view('login/forgetpass',$data);
    }
}

