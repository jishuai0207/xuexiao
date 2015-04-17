#!/usr/bin/env php
<?php
include dirname(__DIR__)."/config.php";
$nginx_str = file_get_contents(dirname(__DIR__).'/vhost/nginx.conf.tpl');
//替换模版变量内容
$nginx_str = str_replace('{domain}',$domain,$nginx_str);
$nginx_str = str_replace('{docroot}',$docroot,$nginx_str);
$nginx_str = str_replace('{fastcgi_pass}',$fastcgi_pass,$nginx_str);
$nginx_str = str_replace('{access_log}',$access_log,$nginx_str);
$nginx_str = str_replace('{error_log}',$error_log,$nginx_str);

//如果存在配置文件则删除重建
if(file_exists('../OrgCenter.conf')){
    unlink('../OrgCenter.conf');
}
file_put_contents('../OrgCenter.conf',$nginx_str);

