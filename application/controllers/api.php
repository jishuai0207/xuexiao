<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends MY_Controller{
    public function __construct(){
        parent::__construct();
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
}

