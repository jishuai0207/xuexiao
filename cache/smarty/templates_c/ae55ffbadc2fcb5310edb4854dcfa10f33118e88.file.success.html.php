<?php /* Smarty version Smarty-3.1.18, created on 2015-03-01 11:18:03
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/student/success.html" */ ?>
<?php /*%%SmartyHeaderCode:54438555054f284eb8930c5-40989349%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae55ffbadc2fcb5310edb4854dcfa10f33118e88' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/student/success.html',
      1 => 1423140600,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54438555054f284eb8930c5-40989349',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'student' => 0,
    'pass' => 0,
    'addClass' => 0,
    'continue' => 0,
    'all' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f284eb9919e4_38589656',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f284eb9919e4_38589656')) {function content_54f284eb9919e4_38589656($_smarty_tpl) {?><!DOCTYPE html>
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
/css/studentAdd/style.css" />
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
    	<div class="studentAdd studentAddSuccess" id="moduleId" pagename="studentAdd">
			<!--创建班级开始-->
			<div class="hd">
				<h2>录入成功</h2>
			</div>
			<div class="content">
				<!-- 创建成功开始 -->
				<div class="creatSuccess textAlign">
					<p>学员使用<em class="bold red">家长A手机号</em>或用户名<em class="bold red"><?php echo $_smarty_tpl->tpl_vars['student']->value;?>
</em>登录<br />初始密码：<em class="bold red"><?php echo $_smarty_tpl->tpl_vars['pass']->value;?>
</em></p>
					<a href="<?php echo $_smarty_tpl->tpl_vars['addClass']->value;?>
" class="comBlueBtn">将此学员加入新班级</a>
					<a href="<?php echo $_smarty_tpl->tpl_vars['continue']->value;?>
" class="comWhiteBtn">继续录入学员</a>
					<a href="<?php echo $_smarty_tpl->tpl_vars['all']->value;?>
" class="comWhiteBtn">查看所有学员</a>
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
