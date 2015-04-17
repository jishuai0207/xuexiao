<?php /* Smarty version Smarty-3.1.18, created on 2015-03-01 11:17:42
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/student/add.html" */ ?>
<?php /*%%SmartyHeaderCode:198197297554f284d66e6ae8-45558898%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd522fac407c658d7b1511a82acd24f48a426cb6' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/student/add.html',
      1 => 1423138883,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198197297554f284d66e6ae8-45558898',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'postUrl' => 0,
    'grade' => 0,
    'v' => 0,
    'year' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f284d6812928_38279871',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f284d6812928_38279871')) {function content_54f284d6812928_38279871($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>录入学员</title>
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
    	<div class="studentAdd" id="moduleId" pagename="studentAdd">
    		<div class="hd">
				<h2>录入学员</h2>
			</div>
			<div class="content">
				<form action="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
" method="post" class="formInputStudent" onsubmit="return false;">
					<ul class="pd">
						<li class="posr cf">
							<span class="t fl"><em class="red">*</em>姓名：</span>
							<input name="truthName" type="text" class="cInput username fl" />
							<span class="grey fl">汉字或英文,最多4个汉字或40个字符</span>
						</li>
						<li class="posr cf">
							<span class="t fl"><em class="red">*</em>在校年级：</span>
							<select name="grade" id="" class="fl">
								<option value="">请选择</option>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['grade']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
								<?php } ?>
							</select>
							<p class="fl">
								每年9月1日系统会自动将所有学员年级升一级。如果个别学员情况不同，您可以单个修改。
							</p>
						</li>
						<li class="posr cf">
							<span class="t fl">家长A：</span>
							<div class="greyBg fl">
								<ul class="seculs">
									<li class="posr cf">
										<span class="t fl"><em class="red">*</em>手机号：</span>
										<input type="text" name="parentTel1" class="cInput username fl" />
									</li>
									<li class="posr cf">
										<span class="t fl"><em class="red"></em>关系：</span>
										<select name="parent1ref" id="" class="fl">
											<option value="">请选择</option>
											<option value="父亲">父亲</option>
											<option value="母亲">母亲</option>
											<option value="其他">其他</option>
										</select>
									</li>
								</ul>
								<a href="javascript:void(0)" class="blueText addParents">添加家长</a>
							</div>
						</li>
						<li class="posr cf addParentsUl undis">
							<span class="t fl">家长B：</span>
							<div class="greyBg fl">
								<ul class="seculs">
									<li class="posr cf">
										<span class="t fl">手机号：</span>
										<input type="text" name="parentTel2" class="cInput username fl" />
									</li>
									<li class="posr cf">
										<span class="t fl">关系：</span>
										<select name="parent2ref" id="" class="fl">
											<option value="">请选择</option>
											<option value="父亲">父亲</option>
											<option value="母亲">母亲</option>
											<option value="其他">其他</option>
										</select>
									</li>
								</ul>
								<a href="javascript:void(0)" class="blueText delParents">删除家长B</a>
							</div>
						</li>
						<li class="posr cf">
							<span class="t fl"><em class="red"></em>原学号：</span>
							<input name="schoolCode" type="text" class="cInput username fl" placeholder="输入学员在您机构的学号" />
						</li>
						<li class="posr cf">
							<span class="t fl">性别：</span>
							<label class="fl">
								<input type="radio" name="sex" value="1" class="fl sex">男
							</label>
							<label class="fl">
								<input type="radio" name="sex" value="0" class="fl sex">女
							</label>
						</li>
						<li class="posr cf">
							<span class="t fl">出生年月：</span>
							<select name="year" id="" class="fl yearSelect">
								<option value="">请选择年</option>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['year']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
								<?php } ?>
							</select>
							<select name="month" id="" class="fl monthSelect">
								<option value="">请选择月</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</li>
						<li class="posr cf">
							<span class="t fl"><em class="red"></em>所在学校：</span>
							<input type="text" name="school" class="cInput username fl" />
						</li>
						<li>
							<div class="subm">
								<input type="submit" value="录入" class="comBlueBtn yh submitDiv">
							</div>
						</li>
					</ul>
				</form>
			</div>
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
