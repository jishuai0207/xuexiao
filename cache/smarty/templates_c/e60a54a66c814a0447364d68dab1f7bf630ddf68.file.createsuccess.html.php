<?php /* Smarty version Smarty-3.1.18, created on 2015-03-01 10:51:04
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/orgclass/createsuccess.html" */ ?>
<?php /*%%SmartyHeaderCode:19432463054f27e98260b38-50876680%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e60a54a66c814a0447364d68dab1f7bf630ddf68' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/orgclass/createsuccess.html',
      1 => 1423562234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19432463054f27e98260b38-50876680',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'addStudentUrl' => 0,
    'classinfourl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f27e983448a7_40513968',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f27e983448a7_40513968')) {function content_54f27e983448a7_40513968($_smarty_tpl) {?><!DOCTYPE html>
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
/css/createClass/style.css" />
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
    	<div class="createClass createClassSuccess" id="moduleId" pagename="createClass">
			<!--创建班级开始-->
			<div class="hd">
				<h2>创建班级成功</h2>
			</div>
			<div class="content">
				<!-- 创建成功开始 -->
				<div class="creatSuccess">
					<span class="">您现在可以给该班级：</span>
			        <a href="<?php echo $_smarty_tpl->tpl_vars['addStudentUrl']->value;?>
#currentStudent" class="comBlueBtn">添加学员</a>
					<!--	<a href="<?php echo $_smarty_tpl->tpl_vars['classinfourl']->value;?>
&pageType=schedule#currentSchedule" class="comBlueBtn">排课</a> -->
				</div>
				<!-- 创建成功结束 -->
			</div>
			<!--创建班级结束-->
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
