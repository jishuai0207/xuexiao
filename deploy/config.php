<?php
//nginx配置
$domain = 'xuexiao.aixuexi.com';
$docroot ='/data/wwwroot/OrgCenter';
$fastcgi_pass = 'unix:/tmp/php-cgi.sock'; 
$access_log ='/wwwroot/logs/orgcenter.access.log main';
$error_log ='/wwwroot/logs/jigou.error.log';

//开发、正式环境替换
$indexFile = '../index.php';
$development = "define('ENVIRONMENT', 'development')";
$production = "define('ENVIRONMENT', 'production')";
$constantsFile = '../application/config/constants.php';
$debug = "define('STATIC_VERSION','debug')"; 
$online = "define('STATIC_VERSION','online')"; 



