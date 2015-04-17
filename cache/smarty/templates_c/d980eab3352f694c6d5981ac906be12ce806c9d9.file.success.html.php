<?php /* Smarty version Smarty-3.1.18, created on 2015-02-11 17:49:09
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/teacher/success.html" */ ?>
<?php /*%%SmartyHeaderCode:186371074554db2595e8c646-68628742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd980eab3352f694c6d5981ac906be12ce806c9d9' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/teacher/success.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186371074554db2595e8c646-68628742',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'pass' => 0,
    'continue' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54db2595efea38_15589984',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54db2595efea38_15589984')) {function content_54db2595efea38_15589984($_smarty_tpl) {?><!DOCTYPE html>
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
/css/teacherAdd/style.css" />
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
    	<div class="teacherAdd teacherAddSuccess" id="moduleId" pagename="teacherAdd">
			<!--创建班级开始-->
			<div class="hd">
				<h2>录入成功</h2>
			</div>
			<div class="content">
				<!-- 创建成功开始 -->
				<div class="creatSuccess textAlign">
					<p>老师凭所录入<em class="bold red">手机号</em>即可登录，初始密码：<em class="bold red"><?php echo $_smarty_tpl->tpl_vars['pass']->value;?>
</em></p>
					<a href="<?php echo $_smarty_tpl->tpl_vars['continue']->value;?>
" class="comBlueBtn">继续录入老师</a>
					<a href="<?php echo $_smarty_tpl->tpl_vars['list']->value;?>
" class="comBlueBtn">回到老师列表</a>
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
