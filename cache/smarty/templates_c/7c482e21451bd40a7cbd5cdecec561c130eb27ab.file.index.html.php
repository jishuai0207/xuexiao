<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 13:01:58
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/student/index.html" */ ?>
<?php /*%%SmartyHeaderCode:203726098454f7e34661ade5-29156657%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c482e21451bd40a7cbd5cdecec561c130eb27ab' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/student/index.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203726098454f7e34661ade5-29156657',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'url' => 0,
    'grades' => 0,
    'key' => 0,
    'grade' => 0,
    'v' => 0,
    'search' => 0,
    'studentNum' => 0,
    'loginNum' => 0,
    'hasclass' => 0,
    'order' => 0,
    'studentList' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7e346942403_57858241',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7e346942403_57858241')) {function content_54f7e346942403_57858241($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>学员列表页面</title>
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/studentList/style.css" />
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
    	<div class="studentList" id="moduleId" pagename="studentList">
    		<div class="topTitle">
				<!-- 录入区域开始 -->
				<div class="tii cf">
					<div class="fl">
						<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['add'];?>
" class="comBlueBtn fl" target="_blank">录入学员</a>
					</div>
					<div class="fl slideUl posr">
						<span class="comBlueBtn">批量录入学员</span>
						<ul class="undis">
							<li>
								<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['download'];?>
">下载信息表模版</a>
							</li>
							<li>
								<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['upload'];?>
" target="_blank">上传信息表</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- 录入区域结束 -->
				<!-- 搜索区域开始 -->
				<div class="search cf">
					<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['post'];?>
" class="formSearchStudent">
					<div class="selectInfo fr">
						<select name="grade" id="" class="fl">
							<option value="">全部年级</option>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['grades']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
							<?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['grade']->value) {?>
							<option selected="selected" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
							<?php } else { ?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
							<?php }?>
							<?php } ?>
						</select>
						<input type="submit" value="筛选" class="submits yh comBlueBtn fl">
					</div>
						<span class="t fl">搜索学员：</span>
						<input type="text" name="keywords" class="keywords cInput fl" placeholder="学员编码、学员姓名、原学号" value="<?php echo $_smarty_tpl->tpl_vars['search']->value;?>
"/>
						<input type="submit" value="搜索学员" class="submits yh comBlueBtn fl">
					</form>
				</div>
				<!-- 搜索区域结束 -->
			</div>
			<!-- 学员列表开始 -->
			<div class="studentLists">
				<div class="hd">
					<span class="fr">
						共<span class="red"><?php echo $_smarty_tpl->tpl_vars['studentNum']->value;?>
</span>个学员,<span class="red"><?php echo $_smarty_tpl->tpl_vars['loginNum']->value;?>
</span>个登录过
					</span>
					<?php if ($_smarty_tpl->tpl_vars['search']->value=='') {?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['all'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['hasclass']->value==2) {?>active<?php }?>">全部学员</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['has'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['hasclass']->value==1) {?>active<?php }?>">有课学员</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['no'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['hasclass']->value==0) {?>active<?php }?>">无课学员</a>
					<?php }?>
				</div>
				<div class="bd">
					<div class="comTable studentDataList">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th>姓名</th>
								<th>性别</th>
								<th>在校年级</th>
								<th>目前班级数</th>
								<th><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['cUrl'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['order']->value=='ca') {?>icoUp<?php } elseif ($_smarty_tpl->tpl_vars['order']->value=='cd') {?>icoDown<?php }?>">录入时间</a></th>
								<th><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['lUrl'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['order']->value=='la') {?>icoUp<?php } elseif ($_smarty_tpl->tpl_vars['order']->value=='ld') {?>icoDown<?php }?>">最近登录时间</a></th>
								<th></th>
							</tr>
						<?php if ($_smarty_tpl->tpl_vars['studentList']->value!=false) {?>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['studentList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<tr>
								<td>
									<div class="himg cf">
									<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['infoUrl'];?>
" class="blueText" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['path'];?>
" alt="" class="fl"></a>
										<ul class="fl text">
											<li>
												<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['infoUrl'];?>
" class="blueText" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
											</li>
											<li class="grey">
												编码：<?php echo $_smarty_tpl->tpl_vars['v']->value['unicode'];?>

											</li>
											<li class="grey">
												原学号：<?php echo $_smarty_tpl->tpl_vars['v']->value['code'];?>

											</li>
										</ul>
									</div>
								</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['sex'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['gname'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['classNum'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['creatTime'];?>
</td>
								<td><span <?php if ($_smarty_tpl->tpl_vars['v']->value['islogin']==0) {?>class="red"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['loginTime'];?>
</span></td>
								<td>
									<ul class="ctrl">
										<li>
											<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['infoUrl'];?>
" class="blueText" target="_blank">班级管理</a>
										</li>
										<li>
											<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['modifyUrl'];?>
" class="blueText" target="_blank">修改基本信息</a>
										</li>
										<li>
											<a href="javascript:void(0);" url="<?php echo $_smarty_tpl->tpl_vars['v']->value['resetUrl'];?>
" class="blueText resetPassword">重置密码</a>
										</li>
									</ul>
								</td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr><td>没有找到符合条件的学员</td></tr>
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
			<!-- 学员列表结束 -->
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
