<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 13:01:55
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/index/index.html" */ ?>
<?php /*%%SmartyHeaderCode:22810265654f7e343aad218-96470165%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79852219b2df1b2ec61db49c51739caa5cbcc916' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/index/index.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22810265654f7e343aad218-96470165',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'studentAdd' => 0,
    'studentList' => 0,
    'classList' => 0,
    'teacherList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7e343ba1633_67197263',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7e343ba1633_67197263')) {function content_54f7e343ba1633_67197263($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/homepage/style.css" />
<!-- 定义全局变量开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/var.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 定义全局变量结束 -->
</head>
<body>
<!-- 头部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 头部结束 -->
<!-- 主要内容开始 -->
<div class="wrap layout">
    <!-- 右侧开始 -->
    <div class="mainContent comBg fr" id="mainContent">
        <div class="homepage" id="moduleId" pagename="homepage">
            <!--首页右侧快捷菜单开始-->
            <div class="quickLinks cf">
                <ul>
                    <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['studentAdd']->value;?>
" target="_blank" class="add">录入学员</a>
                    </li>
                    <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['studentList']->value;?>
" target="_blank"  class="student">学员管理</a>
                    </li>
                    <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['classList']->value;?>
" target="_blank"  class="class">班级管理</a>
                    </li>
                    <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['teacherList']->value;?>
" target="_blank"  class="teacher">老师管理</a>
                    </li>
                </ul>
            </div>
            <!--首页右侧快捷菜单结束-->
            <!--今日课程开始-->
            <div class="todayClass">
                <div class="hd">
                    <h2>今日课程</h2>
                </div>
                <div class="bd">
                    <!-- 数据列表开始 -->
                    <div class="comTable homepageDataList"></div>
                    <!-- 数据列表结束 -->
                    <!-- 分页开始 -->
                    <div class="page cf">
                        <div class="pageContent">
                            
                        </div>
                    </div>
                    <!-- 分页结束 -->
                </div>
            </div>
            <!--今日课程结束-->
        </div>
    </div>
    <!-- 右侧结束 -->
    <!-- 左侧导航开始 -->
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/left_menu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!-- 左侧导航结束 -->
</div>
<!-- 主要内容结束 -->
<!-- 底部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 底部结束 -->
<!-- js引入开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/js.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--js引入结束-->
</body>
</html>
<?php }} ?>
