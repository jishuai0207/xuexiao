<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Classtype extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->checklogin();
        $this->config->load('public');
        $this->public_config = $this->config->item('studentInfo');
		$this->load->model('classtype_model');
		$this->classtype = $this->classtype_model;
        $this->sm->assign('menu_hover',$this->left_menu_config['classType']);
        loadLib('Operation_data');
    }
    public function index(){
        safeFilter();
        $p = (isset($_REQUEST['p']) and $_REQUEST['p'] != '')?$_REQUEST['p']:'1';
        $grade = (isset($_REQUEST['grade']) and $_REQUEST['grade'] != '')?$_REQUEST['grade']:'';
		$row = 10;
		$CTListArr = $this->classtype->getClassTypeList($_SESSION['institution'],$grade,$p,$row);
		$customName = array();
		if($CTListArr){
			$CTList = '(';
			foreach($CTListArr as $v){
				$CTList .= $v->ctid.',';
			}
			$CTList = rtrim($CTList,',');
			$CTList .= ')';
			$info = $this->classtype->getInfoByList($_SESSION['institution'],$CTList);
			$customName = $this->classtype->getCustomByList($CTList,$_SESSION['institution']);
		}else{
			$info = array();
		}
		if($customName){
			foreach($customName as $v){
				$custom[$v->code] = $v->classTypeName;
			}
		}
		$total = $this->classtype->getNumOfCT($_SESSION['institution'],$grade);
		$grades = $this->classtype->getAllGrade();
		foreach($grades as $k=>$v){
			$g[$v->grade] = $v->name;
		}
		$classtype = array();
		if($info){
			foreach($info as $v){
				$classtype[$v->code]['code'] = $v->code;
				$classtype[$v->code]['name'] = $v->name;
				$classtype[$v->code]['sname'] = $v->sname;
				$classtype[$v->code]['gname'] = $v->gname;
				$classtype[$v->code]['custom'] = $custom[$v->code]?$custom[$v->code]:$v->name;
				switch($v->period){
					case '1':
						$classtype[$v->code]['period'][$v->period]['name'] = '春'; 
						break;
					case '2':
						$classtype[$v->code]['period'][$v->period]['name'] = '暑'; 
						break;
					case '3':
						$classtype[$v->code]['period'][$v->period]['name'] = '秋'; 
						break;
					case '4':
						$classtype[$v->code]['period'][$v->period]['name'] = '寒'; 
						break;
					default:
						break;
				}
				$classtype[$v->code]['period'][$v->period]['cur'] = $v->currNum?$v->currNum:'0'; 
				$classtype[$v->code]['period'][$v->period]['status'] = $v->status == '1'?'可用':'禁用'; 
				$classtype[$v->code]['period'][$v->period]['curUrl'] = '/'.$this->url_config['classList'].'?ctId='.$v->ctid.'&isEnd=0'; 
				$classtype[$v->code]['period'][$v->period]['his'] = $v->hisNum?$v->hisNum:'0'; 
				$classtype[$v->code]['period'][$v->period]['hisUrl'] = '/'.$this->url_config['classList'].'?ctId='.$v->ctid.'&isEnd=1'; 

			}
		}
		//var_dump($classtype);exit;
		$data['grade'] = $g; 
		$data['cgrade'] = $grade; 
		$data['classTypeList'] = $classtype;
		$data['total'] = $total;

		$operation_data =new Operation_data(); 
		$operation_data->base_url = '/'.$this->url_config['classTypeList'].'?grade='.$grade;
		$operation_data->total_rows = $total;
		$operation_data->per_page = $row;
		$operation_data->cur_page= $p;
		$data['page'] = $operation_data->show_page();
		
		$data['url']['post'] = '/'.$this->url_config['classTypeList'].'?grade='.$grade;
		$data['title'] = '班型列表';

		$this->sm->view('classtype/index',$data);
	}

    /**
 	* Description : 发送自定义班型名称的接口
 	* Author      : jishuai
 	* Created Time: 2015-02-10 13:38
	*/
	public function setCustomTypeName(){
        $classTypeName = (isset($_REQUEST['classTypeName']) and $_REQUEST['classTypeName'] != '')?$_REQUEST['classTypeName']:'';
        $typeCode = (isset($_REQUEST['typeCode']) and $_REQUEST['typeCode'] != '')?$_REQUEST['typeCode']:'';
		if(mb_strlen($classTypeName)>20 or mb_strlen($classTypeName) < 1) echojson(0,'','名称为1~20个字符');
		$this->load->model("institution_classtype_model");
		$res = $this->institution_classtype_model->setNameByCode($classTypeName,$typeCode,$_SESSION['institution']);
		if($res){
			echojson(1,'','添加成功');
		}else{
			echojson(0,'','添加失败');
		}
	}
}

