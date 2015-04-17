<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Login extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('institution_model');
    }
    /**
     *description:登录提交
     *author:yanyalong
     *date:2014/11/04
     */
    public function index(){
        $this->ajaxChecklogin();
        safeFilter();
        $usercode= isset($_REQUEST['usercode'])?$_REQUEST['usercode']:echojson(0,'','请输入您的账号');
        $password= isset($_REQUEST['password'])?$_REQUEST['password']:echojson(0,'','请输入您的密码');
        $remeberme= (isset($_REQUEST['remeberme'])&&$_REQUEST['remeberme']=='on')?'1':'';
        $backurl = (isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!='')?$_SERVER['HTTP_REFERER']:"";
        $url = '/'.$this->url_config['index'];
        if($backurl!=""){
            $backUrlArr = explode('backurl=',$backurl);
            if(count($backUrlArr)>1) $url = $backUrlArr[1];
        }
        $res = $this->user_model->getUserInfoByLogin($usercode,md5($password));
        if($res!=false){
            if($res->status=='0'||$res->teacherStatus=='0')
                echojson(0,'',"抱歉，该账号已被暂时停用 如有疑问请联系客服".$this->common_public['service']['airlines']);
            $InstitutionInfo  = $this->institution_model->get($res->institution);
            if($InstitutionInfo==false) echojson(0,'',"账号或密码错误  提示：1. 请检查帐号拼写，是否输入有误2. 若您忘记密码，请找回密码"); 
            if($InstitutionInfo->status==0) echojson(0,'',"您所属的".$InstitutionInfo->insName."已被暂时停用如有疑问请联系客服".$this->common_public['service']['airlines']); 
            session_unset();
            if($remeberme== '1'){	
                setcookie("user_id",$res->id,time()+3600*24*7,'/	');
                setcookie("realName",$res->realName,time()+3600*24*7,'/');
                setcookie("institution",$res->institution,time()+3600*24*7,'/');
                setcookie("insCode",$InstitutionInfo->insCode,time()+3600*24*7,'/');
                setcookie("insName",$InstitutionInfo->insName,time()+3600*24*7,'/');
            }
            $_SESSION['user_id'] = $res->id;
            $_SESSION['realName'] = $res->realName;
            $_SESSION['institution'] = $res->institution;
            $_SESSION['insCode'] = $InstitutionInfo->insCode;
            $_SESSION['insName'] = $InstitutionInfo->insName;
            $data['url'] = $url;
            echojson(1,$data,"登录成功");
        }else{
            echojson(0,'',"账号或密码错误");
        }
    }
    /**
     *description:忘记、重置密码提交
     *author:yanyalong
     *date:2014/11/04
     */
    public function forgetpass(){
        $this->ajaxChecklogin();
        $telephone= (isset($_REQUEST['telephone'])&&$_REQUEST['telephone']!="")?$_REQUEST['telephone']:echojson(0,"","请输入手机号");
        $code= (isset($_REQUEST['code'])&&trim($_REQUEST['code'])!='')?$_REQUEST['code']:echojson(0,"","短信验证码不能为空");
        $newPass= (isset($_REQUEST['newPass'])&&trim($_REQUEST['reNewPass'])!="")?$_REQUEST['newPass']:echojson(0,"","新密码不能为空");
        $reNewPass= (isset($_REQUEST['reNewPass'])&&trim($_REQUEST['reNewPass'])!="")?$_REQUEST['reNewPass']:echojson(0,"","重复新密码不能为空");
        if(strlen($newPass)<6||strlen($newPass)>16) echojson(0,"","密码必须为6-16位的数字、字母或标点符号");
        if(strlen($code)!=6)
            echojson(0,"","验证码格式不正确"); 
        if(isset($_SESSION['forgetTelephonePassCode'])&&is_array($_SESSION['forgetTelephonePassCode'])&&in_array($code,$_SESSION['forgetTelephonePassCode']))
            echojson(0,"","验证码已过期，请重新发送验证码"); 
        if(!isset($_SESSION['forgetTelephoneCode'])||!in_array($code,$_SESSION['forgetTelephoneCode']))
            echojson(0,"","验证码不正确"); 
        if($newPass!=$reNewPass) echojson(0,"","两次输入的密码不一致");
        if(!checkTel($telephone)){
            echojson(0,"","手机号格式不正确");
        }
        $this->db->where('telephone',$telephone);
        $res = $this->db->update('User', array('passWord'=>md5($newPass)));
        if($res==false) echojson(0,"","修改失败");
		$code = $this->db->query('select teacherCode from Teacher where telphone = '.$telephone)->row()->teacherCode;
		$postData = array('code'=>$code,'password'=>md5($newPass));
		$data['oldModify'] = $this->modifyOldPwd($postData);
		$data['postData'] = $postData;
        if($res==false) echojson(0,"","修改失败");
        $url ='/'.$this->url_config['login'];
        $data['url'] = $url;
        unset($_SESSION['forgetTelephoneCode']);
        unset($_SESSION['forgetPasslastTime']);
        echojson(1,$data,'修改成功');
    }

    /**
 	* Description : 修改旧系统的密码
 	* Author      : jishuai
 	* Created Time: 2015-01-23 17:21
	*/
	private function modifyOldPwd ($data){
		$url = $this->post_config['modifyOldURL'].$this->post_config['modifyOldTea'];
		return curl_post_data($url,http_build_query($data));
	}
    /**
     *description:发送短信接口
     *author:yanyalong
     *date:2014/12/02
     */
    public function sendSms(){
        $telephone= isset($_REQUEST['telephone'])?$_REQUEST['telephone']:"";
        $content = isset($_REQUEST['content'])?$_REQUEST['content']:"";
        $token = isset($_REQUEST['token'])?$_REQUEST['token']:"";
        if(!checkTel($telephone)) echojson(0,"","手机号格式不正确");
        if($content=="") echojson(0,"","发送内容不能为空");
        $flag = false;
        foreach ($this->common_public['sendSms'] as $key => $val) {
            if($val['token']==$token){
                $flag = true;
                break;
            }
        }
        if($flag==false) echojson(0,"","token错误");
        loadLib("sendSms");
        $sendFlag = SmsFactory::createObj($telephone,$content,$token);
        if($sendFlag==true) echojson(1,"","发送成功");
        else echojson(0,"","发送失败");
    }
    /**
     *description:找回密码短信发送
     *author:yanyalong
     *date:2014/11/09
     */
	 public function sendCode(){
        $telephone= isset($_REQUEST['telephone'])?$_REQUEST['telephone']:"";
        if((isset($_SESSION['telephone'])&&($_SESSION['telephone']!=$telephone))){
            unset($_SESSION['forgetPasslastTime']);
            unset($_SESSION['telephone']);
            unset($_SESSION['forgetTelephoneCode']);
            unset($_SESSION['forgetTelephonePassCode']);
        }
        if(isset($_SESSION['forgetTelephoneCode'])&&!empty($_SESSION['forgetTelephoneCode'])&&isset($_SESSION['forgetPasslastTime'])&&($_SESSION['forgetPasslastTime']+180)<time()){
            foreach ($_SESSION['forgetTelephoneCode'] as $key => $val) {
                $_SESSION['forgetTelephonePassCode'] = $val;
            }
            unset($_SESSION['forgetTelephoneCode']);
        }
        if(isset($_SESSION['forgetPasslastTime'])){
            if(($_SESSION['forgetPasslastTime']+60)>time()){
                echojson(1,"","发送成功");
            }
        }
        if(!isset($_SESSION['forgetTelephoneCode'])) $_SESSION['forgetTelephoneCode'] = array();
        if(!isset($_SESSION['forgetTelephonePassCode'])) $_SESSION['forgetTelephonePassCode'] = array();
        if($telephone!=$_SESSION)
            if($telephone=="") {
                unset($_SESSION['forgetTelephoneCode']);
                unset($_SESSION['forgetPasslastTime']);
                echojson(0,"","请输入手机号");
            }
        if(!preg_match('/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/',$telephone)){
            unset($_SESSION['forgetTelephoneCode']);
            unset($_SESSION['forgetPasslastTime']);
            echojson(0,"","手机号格式不正确");
        }
        $_SESSION['forgetPasslastTime'] = time();
        $_SESSION['telephone'] = $telephone;
        //验证是否存在此帐号
        $userInfo = $this->user_model->getUserInfoByLogin($telephone);
        if($userInfo==false) {
            unset($_SESSION['forgetTelephoneCode']);
            unset($_SESSION['forgetPasslastTime']);
            echojson(0,"","不存在此手机号相关的帐号");
        }
        $code = rand(100000,999999);
        $content = "验证码是".$code."，请确认是您本人发起，有问题请联系400-898-1009";
        $flag = false;
        foreach ($this->common_public['sendSms'] as $key => $val) {
            if($key == 'orgCenter'){
                $token = $val['token'];
                $flag = true;
                break;
            }
        }
        if($flag == false){
            unset($_SESSION['forgetTelephoneCode']);
            unset($_SESSION['forgetPasslastTime']);
            echojson(0,"","token不正确");
        }
        loadLib("sendSms");
        $sendFlag = SmsFactory::createObj($telephone,$content,$token);
        if($sendFlag==true){
            $_SESSION['forgetTelephoneCode'][] = $code;
            if(count($_SESSION['forgetTelephoneCode'])>2){
                $_SESSION['forgetTelephonePassCode'] = array_shift($_SESSION['forgetTelephoneCode']);
            }
            echojson(1,"","发送成功");
        }else{
            unset($_SESSION['forgetTelephoneCode']);
            unset($_SESSION['forgetPasslastTime']);
            echojson(0,"","发送失败");
        }

    }
	
	    /**
     *description:退出登录
     *author:yanyalong
     *date:2015/01/14
     */
    public function logout(){
		$this->load->library('cas');
        $cas_logout_url = $this->config->item('cas_logout_url');
		$this->cas->logout();
        session_unset();
		$_COOKIE['PHPSESSID'] = '';
        header("Location:".$cas_logout_url);exit;
    }
    /**
     *description:cas退出后请求。用来解决单点退出的问题
     *author:yanyalong
     *date:2015/02/06
     */
    public function casLogout(){
        session_unset();
    }
    /**
     *description:退出登录
     *author:yanyalong
     *date:2014/11/04
     */
	/*
    public function logout(){
        safeFilter();
        setcookie("user_id",'',time()-3600,'/	');
        setcookie("realName",'',time()-3600,'/');
        setcookie("institution",'',time()-3600,'/');
        setcookie("insCode",'',time()-3600,'/');
        setcookie("insName",'',time()-3600,'/');
        session_unset();
        header("Location:/".$this->url_config['login']);exit;
    }	
	 */
}

