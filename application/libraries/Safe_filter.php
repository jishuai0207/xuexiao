<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("content-Type: text/html; charset=Utf-8");     
/*=============================================================================
#     FileName: Safe_filter.php
#         Desc: 安全组件,预防get,post,cookie传入数据的sql注入 
=============================================================================*/

class SafeFactory{
	public static function createObj(){
		new Safe_filter();
	}
}

SafeFactory::createObj();

Class Safe_filter
{
	private $getfilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

	private $postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

	private $cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";



	public function __construct() 
	{
		//set_error_handler("customError",E_ERROR);
		foreach($_GET as $key=>$value)
		{
			$this->stopattack($key,$value,$this->getfilter);
		}

		foreach($_POST as $key=>$value)
		{
			$this->stopattack($key,$value,$this->postfilter);
		}

		foreach($_COOKIE as $key=>$value)
		{
			$this->stopattack($key,$value,$this->cookiefilter);
		}
	}

	function stopattack($StrFiltKey,$StrFiltValue,$ArrFiltReq)
	{  
		if(is_array($StrFiltValue))
		{
			$StrFiltValue=implode($StrFiltValue);
		}  
		if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)!=0)
		{   
			$this->savelog("<meta http-equiv='content-type' content='text/html;charset=utf-8'>"."<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
			print "非法提交!";
			exit();
		}      
	}  

	function savelog($logs)
	{
		$toppath=$_SERVER["DOCUMENT_ROOT"]."/cache/safe_filter/".date("YmdHis").".html";
		$Ts=fopen($toppath,"a+");
		fputs($Ts,$logs."\r\n");
		fclose($Ts);
	}

}
