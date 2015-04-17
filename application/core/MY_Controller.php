<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *description:父类控制器
 *author:yanyalong
 *date:2014/11/04
 */
class MY_Controller extends CI_Controller{
	function __construct(){
		session_start();
		parent::__construct();
		$this->load->library('sm');
		$this->loadCommonUrl();
	}
	/**
	 *description:加载全局url地址
	 *author:yanyalong
	 *date:2014/11/05
	 */
	public function loadCommonUrl(){
		$this->config->load('common_url');
		$this->config->load('common_post');
		$this->config->load('common_view');
		$this->config->load('public');
		$this->url_config = $this->config->item('common_url');
		$this->post_config = $this->config->item('common_post');
		$this->view_config = $this->config->item('common_view');
		$this->common_public= $this->config->item('common_public');
		$this->left_menu_config= $this->common_public['leftMenu'];
		$this->sm->assign('url_config',$this->url_config);
		$this->sm->assign('post_config',$this->post_config);
		$this->sm->assign('view_config',$this->view_config);
		$this->sm->assign('static_url',STATIC_RUL);
		$this->sm->assign('site_url',SITE_URL);
		$this->sm->assign('static_version',STATIC_VERSION);
		$this->sm->assign('session_info',$_SESSION);
	}
}
