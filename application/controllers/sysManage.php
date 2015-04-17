<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class SysManage extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->checklogin();
		$this->institution = $_SESSION['institution'];
		$this->load->model('user_model');
        $this->sm->assign('menu_hover',$this->left_menu_config['sysManage']);
        loadLib('Operation_data');
    }
	//获取管理员列表
	public function adminlist(){
        safeFilter();
        $p = (isset($_REQUEST['p']) and $_REQUEST['p'] != '')?$_REQUEST['p']:'1';
		$row = 30;
		$data['user'] = $this->user_model->getAllUser($this->institution,$p,$row);
		$data['num'] = $this->user_model->getUserNum($this->institution)->num;
//		echojson(1,$data,'');
		$operation_data =new Operation_data(); 
		$operation_data->base_url = '/'.$this->url_config['sysManage'].'?';
		$operation_data->total_rows = $data['num'];
		$operation_data->per_page = $row;
		$operation_data->cur_page= $p;
		$data['page'] = $operation_data->show_page();
		$data['title'] = '管理员列表';
		//var_dump($data);exit;
		$this->sm->view('manage/adminlist',$data);
	}
}
