#!/usr/bin/env php
<?php
include dirname(__DIR__)."/config.php";
$index_str = file_get_contents($indexFile);
//替换模版变量内容
$index_str = str_replace($development,$production,$index_str);
file_put_contents($indexFile,$index_str);

$constants_str = file_get_contents($constantsFile);
//替换模版变量内容
$constants_str = str_replace($debug,$online,$constants_str);
file_put_contents($constantsFile,$constants_str);
