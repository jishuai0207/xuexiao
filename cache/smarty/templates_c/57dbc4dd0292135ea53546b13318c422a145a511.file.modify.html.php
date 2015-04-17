<?php /* Smarty version Smarty-3.1.18, created on 2015-03-02 15:45:29
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/student/modify.html" */ ?>
<?php /*%%SmartyHeaderCode:144478550854f415190c3577-37177107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57dbc4dd0292135ea53546b13318c422a145a511' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/student/modify.html',
      1 => 1423645033,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144478550854f415190c3577-37177107',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'postUrl' => 0,
    'student' => 0,
    'grade' => 0,
    'v' => 0,
    'year' => 0,
    'birthday' => 0,
    'month' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f415193687d8_72539501',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f415193687d8_72539501')) {function content_54f415193687d8_72539501($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>修改学员信息</title>
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
				<h2>修改学员信息</h2>
			</div>
			<div class="content">
				<form action="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
" method="post" class="formInputStudent" onsubmit="return false;">
							<input type="hidden" name="studentId" value="<?php echo $_smarty_tpl->tpl_vars['student']->value->id;?>
"/>
					<ul class="pd">
						<li class="posr cf">
							<span class="t fl"><em class="red">*</em>姓名：</span>
							<input name="truthName" type="text" value="<?php echo $_smarty_tpl->tpl_vars['student']->value->truthName;?>
" class="cInput username fl" />
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
								<option <?php if ($_smarty_tpl->tpl_vars['student']->value->grade==$_smarty_tpl->tpl_vars['v']->value['id']) {?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
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
									<li class="posr cf">
										<span class="t fl"><em class="red">*</em>手机号：</span>
										<input type="text" name="parentTel1" class="cInput username fl" value="<?php echo $_smarty_tpl->tpl_vars['student']->value->parentTel1;?>
"/>
									</li>
									<li class="posr cf">
										<span class="t fl"><em class="red"></em>关系：</span>
										<select name="parent1ref" id="" class="fl">
											<option value="">请选择</option>
											<option <?php if ($_smarty_tpl->tpl_vars['student']->value->parent1ref=='父亲') {?> selected="selected" <?php }?> value="父亲">父亲</option>
											<option <?php if ($_smarty_tpl->tpl_vars['student']->value->parent1ref=='母亲') {?> selected="selected" <?php }?> value="母亲">母亲</option>
											<option <?php if ($_smarty_tpl->tpl_vars['student']->value->parent1ref=='其他') {?> selected="selected" <?php }?> value="其他">其他</option>
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
										<input type="text" name="parentTel2" class="cInput username fl" value="<?php echo $_smarty_tpl->tpl_vars['student']->value->parentTel2;?>
"/>
									</li>
									<li class="posr cf">
										<span class="t fl">关系：</span>
										<select name="parent2ref" id="" class="fl">
											<option value="">请选择</option>
											<option <?php if ($_smarty_tpl->tpl_vars['student']->value->parent2ref=='父亲') {?> selected="selected" <?php }?> value="父亲">父亲</option>
											<option <?php if ($_smarty_tpl->tpl_vars['student']->value->parent2ref=='母亲') {?> selected="selected" <?php }?> value="母亲">母亲</option>
											<option <?php if ($_smarty_tpl->tpl_vars['student']->value->parent2ref=='其他') {?> selected="selected" <?php }?> value="其他">其他</option>
										</select>
									</li>
								</ul>
								<a href="javascript:void(0)" class="blueText delParents">删除家长B</a>
							</div>
						</li>
						<li class="posr cf">
							<span class="t fl"><em class="red"></em>原学号：</span>
							<input name="schoolCode" type="text" class="cInput username fl" placeholder="输入学员在您机构的学号" value="<?php echo $_smarty_tpl->tpl_vars['student']->value->studentCode;?>
"/>
						</li>
						<li class="posr cf">
							<span class="t fl">性别：</span>
							<label class="fl">
								<input type="radio" name="sex" <?php if ($_smarty_tpl->tpl_vars['student']->value->sex=='1') {?> checked="selected" <?php }?> value="1" class="fl sex">男
							</label>
							<label class="fl">
								<input type="radio" name="sex" <?php if ($_smarty_tpl->tpl_vars['student']->value->sex=='0') {?> checked="checked" <?php }?> value="0" class="fl sex">女
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
" <?php if ($_smarty_tpl->tpl_vars['birthday']->value['year']==$_smarty_tpl->tpl_vars['v']->value) {?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
								<?php } ?>
							</select>
							<select name="month" id="" class="fl monthSelect">
								<option value="">请选择月</option>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['birthday']->value['month']==$_smarty_tpl->tpl_vars['v']->value) {?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
								<?php } ?>
							</select>
						</li>
						<li class="posr cf">
							<span class="t fl"><em class="red"></em>所在学校：</span>
							<input type="text" name="school" class="cInput username fl" value="<?php echo $_smarty_tpl->tpl_vars['student']->value->school;?>
"/>
						</li>
						<li>
							<div class="subm">
								<input type="submit" value="修改" class="comBlueBtn yh submitDiv">
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
