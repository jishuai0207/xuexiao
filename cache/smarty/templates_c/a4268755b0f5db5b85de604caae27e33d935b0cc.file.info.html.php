<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 10:46:15
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/teacher/info.html" */ ?>
<?php /*%%SmartyHeaderCode:92971143854f7c377416975-40621909%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4268755b0f5db5b85de604caae27e33d935b0cc' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/teacher/info.html',
      1 => 1425179594,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92971143854f7c377416975-40621909',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'info' => 0,
    'modify' => 0,
    'off' => 0,
    'teacherId' => 0,
    'on' => 0,
    'total' => 0,
    'current' => 0,
    'part' => 0,
    'history' => 0,
    'all' => 0,
    'classList' => 0,
    'v' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7c3776f5844_67356443',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7c3776f5844_67356443')) {function content_54f7c3776f5844_67356443($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>老师详细页面</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/teacherInfo/style.css" />
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
    	<div class="teacherInfo" id="moduleId" pagename="teacherInfo">
    		<div class="topTitle cf">
				<div class="headImg fl">
					<img src="<?php echo $_smarty_tpl->tpl_vars['info']->value->path;?>
" alt="">
				</div>
				<div class="text fl">
					<h2>
						<?php echo $_smarty_tpl->tpl_vars['info']->value->truthName;?>

						<span class="red"><?php echo $_smarty_tpl->tpl_vars['info']->value->inJob;?>
<?php echo $_smarty_tpl->tpl_vars['info']->value->status;?>
</span>
					</h2>
					<ul class="cf">
						<li>
							<span class="t fl">老师编码：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->teacherCode;?>

						</li>
						<li>
							<span class="t fl">性别：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->sex;?>

						</li>
						<li>
							<span class="t fl">手机：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->telphone;?>

						</li>
						<li>
							<a title="<?php echo $_smarty_tpl->tpl_vars['info']->value->userName;?>
" class="t fl ahoverNormal">用户名：<?php echo $_smarty_tpl->tpl_vars['info']->value->subuserName;?>
</a>
						</li>
						<li>
							<a title="<?php echo $_smarty_tpl->tpl_vars['info']->value->email;?>
" class="t fl ahoverNormal">邮箱：<?php echo $_smarty_tpl->tpl_vars['info']->value->subemail;?>
</a>
						</li>
						<li>
							<span class="t fl">宣传姓名：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->nickname;?>

						</li>
						<li>
							<span class="t fl">出生年月：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->birthday;?>

						</li>
						<li>
							<span class="t fl">录入时间：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->createTime;?>

						</li>
						<li>
							<span class="t fl">学科：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->subjects;?>

						</li>
						<li>
							<span class="t fl">全职/兼职：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->position;?>

						</li>
						<li>
							<span class="t fl">身份证号：</span>
							<?php echo $_smarty_tpl->tpl_vars['info']->value->idCard;?>

						</li>
					</ul>
				</div>
				<div class="ctrl fl">
					<ul>
						<?php if ($_smarty_tpl->tpl_vars['info']->value->ifmodify==1) {?>
						<li>
							<a href="<?php echo $_smarty_tpl->tpl_vars['modify']->value;?>
" class="comWhiteBtn">修改基本信息</a>
						</li>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['info']->value->inJob=='') {?>
						<li>
							<a href="javascript:void(0)" url="<?php echo $_smarty_tpl->tpl_vars['off']->value;?>
" teacherId="<?php echo $_smarty_tpl->tpl_vars['teacherId']->value;?>
" class="comWhiteBtn leaveOff">离职登记</a>
						</li>
						<?php } else { ?>
						<li>
							<a href="javascript:void(0)" url="<?php echo $_smarty_tpl->tpl_vars['on']->value;?>
" teacherId="<?php echo $_smarty_tpl->tpl_vars['teacherId']->value;?>
" class="comWhiteBtn leaveOn">入职登记</a>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>
			<!-- 班级列表开始 -->
			<div class="teacherClassLists">
				<h2 class="classTitle">任课班级</h2>
				<div class="hd">
					<span class="fr">
						共<span class="red"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>个班级
					</span>
					<a href="<?php echo $_smarty_tpl->tpl_vars['current']->value;?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['part']->value=='c') {?>active<?php }?>">目前班级</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['history']->value;?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['part']->value=='h') {?>active<?php }?>">历史班级</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['all']->value;?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['part']->value=='a') {?>active<?php }?>">全部班级</a>
				</div>
				<div class="bd">
					<div class="comTable">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th>班级</th>
								<th>学员数</th>
								<th>班级起止时间</th>
								<th>加入班级时间</th>
							</tr>
							<?php if ($_smarty_tpl->tpl_vars['classList']->value!=false) {?>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['classList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr>
								<td>
									<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['classUrl'];?>
" class="blueText"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
								</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['stuNum'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['beginTime'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['endTime'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['joinTime'];?>
</td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr><td>没有任课班级</td></tr>
							<?php }?>
						</table>
					</div>
				</div>
				<!-- 分页开始 -->
				<div class="page cf">
					<div class="pageContent">
								<?php echo $_smarty_tpl->tpl_vars['page']->value;?>

					</div>
				</div>
				<!-- 分页结束 -->
			</div>
			<!-- 班级列表结束 -->
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
