<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("content-Type: text/html; charset=Utf-8");     
/**
 *description:短信发送工厂
 *author:yanyalong
 *date:2014/12/02
 */
class SmsFactory{
    public static function createObj($telephone,$contents,$token){
        $Sms = new Sms($telephone,$contents,$token);
        return $Sms->sendSms();
    }
}

/**
 *description:短信处理类
 *author:yanyalong
 *date:2014/12/02
 */
class Sms{
    private $telephone;
    private $contents;
    private $token;
    public function __construct($telephone,$contents,$token){
        $this->telephone = $telephone;
        $this->contents = $contents;
        $this->token = $token;
        $this->CI = &get_instance();
        $this->CI->config->load('public');
        $this->common_public = $this->CI->config->item('common_public');
    }
    /**
     *description:发送短信
     *author:yanyalong
     *date:2014/12/02
     */
    public function sendSms() {
        $sendFlag = false;
        foreach ($this->common_public['sendSms'] as $key => $val) {
            if($val['token']==$this->token){
                $sn = $val['sn']; 
                $pwd = strtoupper ( md5 ( $sn . $val['pwd'] ) ); 
                $sign = $val['sign']; 
                $sendFlag = true;
                break;
            } 
        }
        if($sendFlag==false) return false;
        $flag = 0;
        $hosts = array('sdk.entinfo.cn', 'sdk2.entinfo.cn');
        $idx = time() % 2;
        $host = $hosts[$idx];
        if(false == strstr($this->contents,$sign)) {
            $this->contents .= $sign;
            $argv = array (
                'sn' => $sn, // //替换成您自己的序列号
                'pwd' => $pwd, // 此处密码需要加密 加密方式为 md5(sn+password) 32位大写
                'mobile' => $this->telephone, // 手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
                'content' => iconv ( "UTF-8", "gb2312//IGNORE", $this->contents ), // 短信内容
                'ext' => '',
                'stime' => '', // 定时时间 格式为2011-6-29 11:09:21
                'rrid' => ''
            );
            $params = "";
            // 构造要post的字符串
            foreach ( $argv as $key => $value ) {
                if ($flag != 0) {
                    $params .= "&";
                    $flag = 1;
                }
                $params .= $key . "=";
                $params .= urlencode ( $value );
                $flag = 1;
            }
            $length = strlen ( $params );
            // 创建socket连接
            $fp = @fsockopen ( $host, 8060, $errno, $errstr, 10 );
            if($errstr) {
                print_r($errstr);
            }
            // 构造post请求的头
            $header = "POST /webservice.asmx/gxmt HTTP/1.1\r\n";
            $header .= "Host:" . $host . "\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . $length . "\r\n";
            $header .= "Connection: Close\r\n\r\n";
            // 添加post的字符串
            $header .= $params . "\r\n";
            // 发送post的数据
            fputs ( $fp, $header );
            $inheader = 1;
            while ( ! feof ( $fp ) ) {
                $line = fgets ( $fp, 1024 ); // 去除请求包的头只显示页面的返回数据
                if ($inheader && ($line == "\n" || $line == "\r\n")) {
                    $inheader = 0;
                }
                if ($inheader == 0) {
                }
            }
            fclose($fp);
            $line = str_replace ( "<string xmlns=\"http://tempuri.org/\">", "", $line );
            $line = str_replace ( "</string>", "", $line );
            $result = explode ( "-", $line );
            if (count ( $result ) > 1){
                $this->log4er('error',"发送失败  操作IP: ".$_SERVER["REMOTE_ADDR"].' 手机号:'.$this->telephone.' 发送内容:'.$this->contents);
                return false;
                //echo '发送失败返回值为:' . $line . '。请查看webservice返回值对照表';
            }else{
                $this->log4er('info',"发送成功  操作IP: ".$_SERVER["REMOTE_ADDR"].' 手机号:'.$this->telephone.' 发送内容:'.$this->contents);
                return true;
                //echo '发送成功 返回值为:' . $line;
            }
        }
    }
    /**
     *description:写入日志
     *author:yanyalong
     *param:errorLevel:info error debug warn fatal  errorMsg:日志内容
     *date:2015/02/02
     */
    public function log4er($errorLevel,$errorMsg){
        //加载Log4php类库
        loadLib("log4php/Logger");
        //初始化配置
        Logger::configure('application/config/log4php.properties');
        //获取日志类
        $this->logger = Logger::getLogger($_SERVER['REQUEST_URI']);
        //写入日志
        $this->logger->$errorLevel($errorMsg);
    }
}

