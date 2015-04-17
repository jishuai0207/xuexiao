<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *description:登录验证父类控制器
 *author:yanyalong
 *date:2014/11/04
 */
class OrgCenter_Controller extends MY_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('cas');
		$this->cas->force_auth();
		$this->user = $this->cas->user()->userlogin;
		$this->config->load('cas');
		$this->cas_logout_url = $this->config->item('cas_logout_url');
		$this->logInit();
	}

	/**
	 * Description : 登录后等一写session进行处理
	 * Author      : jishuai
	 * Created Time: 2015-02-06 16:03
	 */
	public function logInit(){
		$this->config->load('cas');
		$this->cas_index = $this->config->item('cas_index');
		$this->load->model('teacher_model');
		$userInfo1 = $this->teacher_model->getTeaByTel($this->user);
		//echo $this->db->last_query();
		$userInfo2 = $this->teacher_model->getAdminByTel($this->user);
		//echo $this->db->last_query();
		//var_dump($userInfo1);var_dump($userInfo2);exit;
		if($userInfo1 && (!$userInfo2)){
			header("Location:".$this->cas_index);exit;
		}
		if($userInfo2){
			$_SESSION['insCode'] = $userInfo2->insCode;
			$_SESSION['insName'] = $userInfo2->insName;
			$_SESSION['user_id'] = $userInfo2->id;
			$_SESSION['institution'] = $userInfo2->institution;
			$_SESSION['realName'] = $userInfo2->truthName;
		}else{
			session_unset();
			header("Location:".$this->cas_logout_url);exit; 
		}
		
	}
	/**
	 *description:页面验证登录状态
	 *author:yanyalong
	 *date:2014/11/25
	 */
	public function checklogin(){
		$this->checkSession();
		$checkArray = array($this->url_config['login'],$this->url_config['forgetPass'],'','index.php','index.php/index');
		if(!isset($_SESSION['user_id'])||$_SESSION['user_id']==''){
			unset($_SESSION['insCode']);
			unset($_SESSION['insName']);
			unset($_SESSION['user_id']);
			unset($_SESSION['institution']);
			unset($_SESSION['realName']);
			if(!in_array($this->currentUrl,$checkArray)){
				header("Location:".$this->cas_logout_url);exit; 
			}
		}else{
			if(in_array($this->currentUrl,$checkArray)){
				header("Location:http://".$_SERVER['HTTP_HOST']."/index.php/index/home");
			}
		}
		if(isset($_SESSION['realName'])){
			$this->sm->assign('AdmintruthName',$_SESSION['realName']);
			$this->sm->assign('isLogin',1);
		}else
			$this->sm->assign('isLogin',0);
		$this->gaoSiInstitutionExecute();
	}
	//ajax验证登录状态
	public function ajaxChecklogin(){
		$this->checkSession();
		$checkArray = array($this->post_config['forgetPass'],$this->post_config['login']);
		if(!isset($_SESSION['user_id'])||$_SESSION['user_id']==''){
			unset($_SESSION['insCode']);
			unset($_SESSION['insName']);
			unset($_SESSION['user_id']);
			unset($_SESSION['institution']);
			unset($_SESSION['realName']);
			if(!in_array($this->currentUrl,$checkArray)){
				$data['url'] = '/'.$this->url_config['login']."?backurl=".$_SERVER['HTTP_REFERER'];
				echojson(-1,$data,'登录过期');
			}
		}
		$this->gaoSiInstitutionExecute();
	}
	/**
	 *description:session检查
	 *author:yanyalong
	 *date:2014/11/25
	 */
	public function checkSession(){
		/*
		   if(!isset($_SESSION['user_id'])){
		   $user_id = isset($_COOKIE['user_id'])?$_COOKIE['user_id']:'';
		   $realName= isset($_COOKIE['realName'])?$_COOKIE['realName']:'';
		   $institution = isset($_COOKIE['institution'])?$_COOKIE['institution']:'';
		   $insCode= isset($_COOKIE['insCode'])?$_COOKIE['insCode']:'';
		   $insName= isset($_COOKIE['insName'])?$_COOKIE['insName']:'';
		   $_SESSION['insCode'] = (isset($_SESSION['insCode'])&&$_SESSION['insCode']!='')?$_SESSION['insCode']:$insCode;
		   $_SESSION['insName'] = (isset($_SESSION['insName'])&&$_SESSION['insName']!='')?$_SESSION['insName']:$insName;
		   $_SESSION['user_id'] = (isset($_SESSION['user_id'])&&$_SESSION['user_id']!='')?$_SESSION['user_id']:$user_id;
		   $_SESSION['institution'] = (isset($_SESSION['institution'])&&$_SESSION['institution']!='')?$_SESSION['institution']:$institution;
		   $_SESSION['realName'] = (isset($_SESSION['realName'])&&$_SESSION['realName']!='')?$_SESSION['realName']:$realName;
		   }
		 */
		$currentUrlArr = explode('?',$_SERVER['REQUEST_URI']);
		$this->currentUrl = trim($currentUrlArr['0'],'/');
	}

	/**
	 *description:处理高思机构状态判断
	 *author:yanyalong
	 *date:2014/12/17
	 */
	public function gaoSiInstitutionExecute(){
		$url = ltrim($this->currentUrl,'index.php');
		$url = ltrim(trim($url),'/');
		//判断机构是否是高思官方机构
		if(isset($_SESSION['institution'])&&$_SESSION['institution'] =="24"){
			if(in_array($url,$this->common_public['gaoSiInstitution'])){
				header("Location:/".$this->url_config['noAuth']);exit; 
			}
			if(in_array($url,$this->common_public['gaoSiInstitutionAjax'])){
				$data['url'] = $_SERVER['HTTP_REFERER'];
				echojson(0,$data,'抱歉,您无权限进行此操作');
			}
		} 
	}
	/**
	 *description:加载全局url地址
	 *author:yanyalong
	 *date:2014/11/05
	 */
/*	public function loadCommonUrl(){
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
	}*/
}
