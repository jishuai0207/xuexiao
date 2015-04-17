<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
loadParentController("OrgCenter_Controller");
class Teacher extends OrgCenter_Controller{
    public function __construct(){
        parent::__construct();
        $this->config->load('public');
        $this->load->model('teacher_model');
        $this->load->model('user_model');
        $this->load->model('teacher_subject_model');
        $this->ajaxChecklogin();
    }

    /**
     *description:录入老师提交
     *author:yanyalong
     *date:2014/12/04
     */
    public function add(){
        safeFilter();
        $truthName= (isset($_REQUEST['truthName'])&&trim($_REQUEST['truthName'])!="")?$_REQUEST['truthName']:echojson(0,'','请填写真实姓名');
        if(!checkName($truthName)) echojson(0,"","真实姓名最多4个汉字或40个英文");
        //$sort= (isset($_REQUEST['sort'])&&trim($_REQUEST['sort'])!="")?$_REQUEST['sort']:echojson(0,'','请输入姓名全拼');
        //if(!preg_match("/^[A-Za-z\s]{1,40}$/",$sort)) echojson(0,'','姓名全拼最多40个英文字符');
        if(!checkName($truthName)) echojson(0,"","真实姓名最多4个汉字或40个英文");
        $nickname= (isset($_REQUEST['nickName'])&&trim($_REQUEST['nickName'])!="")?$_REQUEST['nickName']:"";
        if(checkUtf8Len($nickname,15)==false) echojson(0,"","宣传姓名最多15个汉字或30个英文");
        $telephone= (isset($_REQUEST['telphone'])&&$_REQUEST['telphone']!="")?trim($_REQUEST['telphone']):echojson(0,'','请填写手机号');
        if(strlen($telephone)<11){
            echojson(0,'','所填写手机号不足11位');
        }
        //验证手机号重复性
        $userInfoByTel = $this->user_model->getInfoByTel($telephone);
        if($userInfoByTel!=false) echojson(0,"","手机号已经注册");
        if(!preg_match('/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}|17[0-9]{1}[0-9]{8}$/',$telephone)){
            echojson(0,"","手机号格式不正确");
        }
        $subject = (isset($_REQUEST['subject'])&&!empty($_REQUEST['subject']))?$_REQUEST['subject']:echojson(0,'','请至少选择一个学科');
        $inJob= (isset($_REQUEST['inJob'])&&in_array($_REQUEST['inJob'],array(0,1)))?$_REQUEST['inJob']:echojson(0,'','请选择在职状态');
        $sex= (isset($_REQUEST['sex'])&&in_array($_REQUEST['sex'],array(0,1)))?$_REQUEST['sex']:'';
        if($sex=="") $sex = null;
        $email= (isset($_REQUEST['email'])&&$_REQUEST['email']!="")?$_REQUEST['email']:"";
        //验证邮箱重复性
        $userInfoEmail = $this->user_model->getInfoByEmail($email);
        if($email!=""&&$userInfoEmail!=false) echojson(0,"","已有老师注册过相同的邮箱地址");
        if($email!=""&&(!preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i',$email)))
            echojson(0,"","请输入正确格式的邮箱");
        if($email=="") $email = $telephone."@gaosiedu.com";
        $idCard= (isset($_REQUEST['idCard'])&&$_REQUEST['idCard']!="")?$_REQUEST['idCard']:"";
        if($idCard!=""&&(!preg_match('/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i',$idCard)))
            echojson(0,"","请输入正确格式的身份证号");
        $year= (isset($_REQUEST['year'])&&$_REQUEST['year']!="")?$_REQUEST['year']:"";
        $month= (isset($_REQUEST['month'])&&$_REQUEST['month']!="")?$_REQUEST['month']:"";
        //出生年
        $birthday_year = array();
        $currentYear = date('Y');
        $maxYear = $currentYear-85;
        $minYear = $currentYear-15;
        for ($i=$maxYear;$i<=$minYear; $i++) {
            $birthday_year[] = $i;
        }
        //出生月
        $birthday_month = array();
        for ($i=1; $i<=12; $i++) {
            $birthday_month[] = $i;
        }
        if($year=="") $month = "";
        if($month=="") $year= "";
        if(($year!=""&&!in_array($year,$birthday_year))||($month!=""&&!in_array($month,$birthday_month)))  echojson(0,'','异常操作');
        $position = (isset($_REQUEST['position'])&&in_array($_REQUEST['position'],array(0,1)))?$_REQUEST['position']:echojson(0,'','请选择兼职、全职状态');
        $birthday = ($year!="")?$year.'-'.$month:"";
        //插入老师表
        $teacherData= array(
            'truthName' => $truthName,
            'nickname' => $nickname,
            'sex' => $sex,
            'isAdmin' => 0,
            'status' => 1,
            'capacity' => 1,
            'position' => $position,
            'inJob' => $inJob,
            'institution' => $_SESSION['institution'],
            'idCard' => $idCard,
            'telphone' => $telephone,
            'birthday' => $birthday,
            'email' => $email,
            'path' => "",
            'workNumber' => ""
        );
        $teacherId= $this->teacher_model->insert($teacherData);
        $this->db->where('id',$teacherId);
        $this->db->update('Teacher', array('teacherCode'=>objEncode($teacherId,'T')));
        //插入老师表
        $public_config = $this->config->item('common_public');
        $userData= array(
            'userName' => $email,
            'passWord' => md5($public_config['teacherInfo']['initPass']),
            'realName' => $truthName,
            'status' => 1,
            'sex' => $sex,
            'telephone' => $telephone,
            'createTime' => date('Y-m-d H:i:s'),
            'lastUpdate' => null
        );
        $this->user_model->insert($userData);
        //关联学科
        foreach ($subject as $key => $val) {
            $teacherSubjectDate = array(
                'teacherId' => $teacherId,
                'subjectId' => $val
            );
            $this->teacher_subject_model->insert($teacherSubjectDate);
        }
        $data['url'] = '/'.$this->url_config['teacherAddSuccess']."?teacherId=".$teacherId;
        echojson(1,$data);
    }

    /**
     *description:修改老师信息提交
     *author:yanyalong
     *date:2014/12/04
     */
    public function modify(){
        safeFilter();
        $truthName= (isset($_REQUEST['truthName'])&&trim($_REQUEST['truthName'])!="")?$_REQUEST['truthName']:echojson(0,'','请填写真实姓名');
        if(!checkName($truthName)) echojson(0,"","真实姓名最多4个汉字或40个英文");
        //$sort= (isset($_REQUEST['sort'])&&trim($_REQUEST['sort'])!="")?$_REQUEST['sort']:echojson(0,'','姓名拼音不能为空');
        //if(!preg_match("/^[A-Za-z\s]{1,40}$/",$sort)) echojson(0,'','姓名拼音最多40个纯字母文字');
        $nickname= (isset($_REQUEST['nickName'])&&trim($_REQUEST['nickName'])!="")?$_REQUEST['nickName']:"";
		if($nickname){
			if(!checkName($nickname)) echojson(0,"","宣传姓名最多4个汉字或40个英文");
		}
        $telephone= (isset($_REQUEST['telphone'])&&$_REQUEST['telphone']!="")?trim($_REQUEST['telphone']):echojson(0,'','请填写手机号');
        $teacherId= (isset($_REQUEST['teacherId'])&&trim($_REQUEST['teacherId'])!="")?$_REQUEST['teacherId']:echojson(0,'','操作异常');
        //获取老师基本信息
        $teacherInfo = $this->teacher_model->get($teacherId);
        //验证手机号重复性
        $userInfoByTel = $this->user_model->getInfoByTel($telephone);
        if($teacherInfo->telphone!=$telephone&&$userInfoByTel!=false) echojson(0,"","手机号已经注册");
        if(!preg_match('/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/',$telephone)){
            echojson(0,"","手机号格式错误");
        }
        $subject = (isset($_REQUEST['subject'])&&!empty($_REQUEST['subject']))?$_REQUEST['subject']:echojson(0,'','请至少选择一个学科');
        $sex= (isset($_REQUEST['sex'])&&in_array($_REQUEST['sex'],array(0,1)))?$_REQUEST['sex']:"";
        if($sex=="") $sex = null;
        $email= (isset($_REQUEST['email'])&&$_REQUEST['email']!="")?$_REQUEST['email']:"";
        //验证邮箱重复性
        $userInfoEmail = $this->user_model->getInfoByEmail($email);
        if($email!=""&&$teacherInfo->email!=$email&&$userInfoEmail!=false) echojson(0,"","已有老师注册过相同的邮箱地址");
        if($email!=""&&(!preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i',$email)))
            echojson(0,"","邮箱格式错误");
        if($email=="") $email = $telephone."@gaosiedu.com";
        $idCard= (isset($_REQUEST['idCard'])&&$_REQUEST['idCard']!="")?$_REQUEST['idCard']:"";
        if($idCard!=""&&(!preg_match('/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i',$idCard)))
            echojson(0,"","身份证号格式错误");
        $year= (isset($_REQUEST['year'])&&$_REQUEST['year']!="")?$_REQUEST['year']:"";
        $month= (isset($_REQUEST['month'])&&$_REQUEST['month']!="")?$_REQUEST['month']:"";
        //出生年
        $birthday_year = array();
        $currentYear = date('Y');
        $maxYear = $currentYear-85;
        $minYear = $currentYear-15;
        for ($i=$minYear;$i>=$maxYear;$i--) {
            $birthday_year[] = $i;
        }
        //出生月
        $birthday_month = array();
        for ($i=1; $i<=12; $i++) {
            $birthday_month[] = $i;
        }
        if($year=="") $month = "";
        if($month=="") $year= "";
        if(($year!=""&&!in_array($year,$birthday_year))||($month!=""&&!in_array($month,$birthday_month)))  echojson(0,'','异常操作');
        $position = (isset($_REQUEST['position'])&&in_array($_REQUEST['position'],array(0,1)))?$_REQUEST['position']:"1"; 
        //获取老师用户信息
        $userInfo  = $this->user_model->getInfoByTel($teacherInfo->telphone);
        if($userInfo==false)  echojson(0,'','数据异常');
        //更新老师表
        $teacherData= array(
            'truthName' => $truthName,
            'nickname' => $nickname,
            'sex' => $sex,
            'position' => $position,
            'idCard' => $idCard,
            'telphone' => $telephone,
            'birthday' => $year.'-'.$month,
            'email' => $email,
            'path' => "",
        );
        //更新老师表
        $this->db->where('id',$teacherId);
        $this->db->update('Teacher', $teacherData);
        $public_config = $this->config->item('common_public');
        $userData = array(
            'userName' => $email,
            'realName' => $truthName,
            'sex' => $sex,
            'telephone' => $telephone,
            'lastUpdate' => date("Y-m-d H:i:s")
        );
        $this->db->where('id',$userInfo->id);
        $this->db->update('User',$userData);
        //更新老师学科关联表
        //查询老师原有学科
        $subjectListOld = $this->teacher_subject_model->getByTeacherId($teacherId);
        $subjectArrOld = array();
        foreach ($subjectListOld as $key => $val) {
            $subjectArrOld[] = $val->subjectId;
        }
        //判断学科是否做修改
        sort($subjectArrOld);
        sort($subject);
        if($subjectArrOld!=$subject){
            //做修改则删除原所有关联
            $this->teacher_subject_model->delSubjectByTeacher($teacherId);
            //重新插入新关联
            foreach ($subject as $key => $val) {
                $teacherSubjectDate = array(
                    'teacherId' => $teacherId,
                    'subjectId' => $val
                );
                $this->teacher_subject_model->insert($teacherSubjectDate);
            }
        }
        $data['teacherInfoUrl'] = '/'.$this->url_config['teacherInfo']."?teacherId=".$teacherId;
        $data['teacherListUrl'] = '/'.$this->url_config['teacherList'];
        echojson(1,$data,"修改成功");
    }
    /**
     *description:修改密码
     *author:yanyalong
     *date:2014/11/22
     */
    public function modifyPass(){
        $telephone= (isset($_REQUEST['telephone'])&&$_REQUEST['telephone']!="")?$_REQUEST['telephone']:echojson(0,"","手机号不能为空");
        $code= (isset($_REQUEST['code'])&&trim($_REQUEST['code'])!='')?$_REQUEST['code']:echojson(0,"","短信验证码不能为空");
        $newPass= (isset($_REQUEST['newPass'])&&trim($_REQUEST['reNewPass'])!="")?$_REQUEST['newPass']:echojson(0,"","新密码不能为空");
        $reNewPass= (isset($_REQUEST['reNewPass'])&&trim($_REQUEST['reNewPass'])!="")?$_REQUEST['reNewPass']:echojson(0,"","重复新密码不能为空");

        if(strlen($code)!=6)
            echojson(0,"","验证码格式不正确"); 
        if(isset($_SESSION['forgetTelephonePassCode'])&&is_array($_SESSION['forgetTelephonePassCode'])&&in_array($code,$_SESSION['forgetTelephonePassCode']))
            echojson(0,"","验证码已过期，请重新发送验证码"); 
        if(!isset($_SESSION['forgetTelephoneCode'])||!in_array($code,$_SESSION['forgetTelephoneCode']))
            echojson(0,"","验证码不正确"); 
        if($newPass!=$reNewPass) echojson(0,"","新密码和重复新密码不同");
        if(!preg_match('/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/',$telephone)){
            echojson(0,"","手机号格式错误");
        }
        $this->db->where('telephone',$telephone);
        $res = $this->db->update('User', array('passWord'=>md5($newPass)));
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
}
