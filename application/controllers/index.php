<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Index extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->checklogin();
        $this->config->load('public');
        $this->public_config = $this->config->item('studentInfo');
        $this->sm->assign('menu_hover',$this->left_menu_config['index']);
    }
    /**
     *description:登录页
     *author:yanyalong
     *date:2014/11/04
     */
    public function index(){
        $data['backurl'] = (isset($_REQUEST['backurl']) and $_REQUEST['backurl'] != '')?$_REQUEST['backurl']:'';
        $data['title'] = "登录";
        $this->sm->view('login/index',$data);  
    }
    /**
     *description:首页
     *author:yanyalong
     *date:2014/10/30
     */
    public function home(){
        $data['title'] = "首页";
        $data['studentAdd'] = '/'.$this->url_config['studentAdd'];
        $data['studentList'] = '/'.$this->url_config['studentList'];
        $data['classList'] ='/'.$this->url_config['classList'];
        $data['teacherList'] = '/'.$this->url_config['teacherList'];
        $this->sm->view('index/index',$data);  
    }
    /**
     *description:测试连接池
     *author:yanyalong
     *date:2014/11/13
     */
    //public function test(){
        //loadLib('dataPool');
        //$dataPool = new DatePool();
        //$arr = $dataPool->infoFromPool(1);
            //echo "<pre>";var_dump($arr);exit;
    //}
}
