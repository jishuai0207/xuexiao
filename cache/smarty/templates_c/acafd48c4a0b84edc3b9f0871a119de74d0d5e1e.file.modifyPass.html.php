<?php /* Smarty version Smarty-3.1.18, created on 2015-02-10 21:49:55
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/ucenter/modifyPass.html" */ ?>
<?php /*%%SmartyHeaderCode:73612378754da0c83e00f94-15363425%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'acafd48c4a0b84edc3b9f0871a119de74d0d5e1e' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/ucenter/modifyPass.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73612378754da0c83e00f94-15363425',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'post_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54da0c83edd931_00134593',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54da0c83edd931_00134593')) {function content_54da0c83edd931_00134593($_smarty_tpl) {?><!DOCTYPE html>
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
/css/modifyPass/style.css" />
<!-- 定义全局变量开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/var.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 定义全局变量结束 -->
</head>
<body>
<!-- 头部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 头部结束 -->
<!-- 主要内容开始 -->
<div id="moduleId" pagename="modifyPass" class="modifyPass">
	<div class="layout">
		<h2 class="title">重新设置密码</h2>
		<div class="cons">
			<!-- /index.php/post/login/sendCode
			       // $_REQUEST['telephone'] = '13371772618'; -->
			<form action="/<?php echo $_smarty_tpl->tpl_vars['post_config']->value['modifyPass'];?>
" class="FormResetPassword" method="post" onsubmit="return false;">
				<ul>
					<li class="cf">
						<span class="t fl">手机号：</span>
						<input type="text" class="cInput telephone fl" name="telephone" placeholder="创建账号时使用的手机号" value="" />
					</li>
					<li class="cf">
						<span class="t fl">短信验证码：</span>
						<input type="text" class="cInput capcode fl" name="code">
						<a href="javascript:void(0)" class="sendWord fl">发送短信验证码</a>
					</li>
					<li class="cf">
						<span class="t fl">设置新密码：</span>
						<input type="password" class="cInput setNewPassword fl" name="newPass" placeholder="6-16位，数字、字母或标点符号">
					</li>
					<li class="cf">
						<span class="t fl">再次输入新密码：</span>
						<input type="password" class="cInput setNewPasswordSec fl" name="reNewPass" placeholder="再次输入新密码">
					</li>
					<li>
						<input type="submit" class="submits comBlueBtn yh" value="提交" />
					</li>
				</ul>
			</form>
		</div>
	</div>
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
