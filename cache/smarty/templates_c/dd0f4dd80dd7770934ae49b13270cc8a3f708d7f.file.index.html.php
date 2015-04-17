<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 13:01:55
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/login/index.html" */ ?>
<?php /*%%SmartyHeaderCode:68828305254f7e3438230f9-68622949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd0f4dd80dd7770934ae49b13270cc8a3f708d7f' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/login/index.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68828305254f7e3438230f9-68622949',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'backurl' => 0,
    'post_config' => 0,
    'url_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7e3438f07d5_30173669',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7e3438f07d5_30173669')) {function content_54f7e3438f07d5_30173669($_smarty_tpl) {?><!DOCTYPE html>
<html class="loginBg">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/login/style.css" />
<!-- 定义全局变量开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/var.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 定义全局变量结束 -->
</head>
<body>
<!-- 头部开始 -->

<!-- 头部结束 -->
<!-- 主要内容开始 -->
<div id="moduleId" pagename="login" class="login">
	<div class="layout">
		<h1>高思 高度决定视野,思想创造未来</h1>
	</div>
	<div class="con">
		<div class="layout">
			<div class="logins fr">
				<h2>机构用户登录</h2>
				<?php if ($_smarty_tpl->tpl_vars['backurl']->value!='') {?>
                    <p class="outInfo">登录已过期!,请重新登录。</p>
                <?php }?>
				<form action="/<?php echo $_smarty_tpl->tpl_vars['post_config']->value['login'];?>
" class="formLogin" method="post" onsubmit="return false">
					<ul>
						<li>
							<input type="text" name="usercode" value="" class="text username yh" placeholder="手机号" />
						</li>
						<li>
							<input type="password" name="password" value="" class="text password yh" placeholder="密码" />
						</li>
						<li class="i cf">
							<label class="fl">
								<input type="checkbox" checked='checked' name='remeberme' />下次自动登录
							</label>
							<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['forgetPass'];?>
"  target="_blank" class="fegot fr">忘记密码？</a>
						</li>
						<li class="s">
							<input type="submit" class="submits yh" value="登录" />
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
	<!-- tel开始 -->
	<div class="tels">
		<div class="layout">
			<p class="tel fr">
				客服400-012-33
			</p>
		</div>
	</div>
	<!-- tel结束 -->
</div>
<!-- 主要内容结束 -->
<!-- js引入开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/js.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--js引入结束-->
</body>
</html>
<?php }} ?>
