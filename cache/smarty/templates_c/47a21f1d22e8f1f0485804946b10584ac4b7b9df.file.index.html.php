<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 10:46:13
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/teacher/index.html" */ ?>
<?php /*%%SmartyHeaderCode:32983573254f7c375b69a35-77957497%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47a21f1d22e8f1f0485804946b10584ac4b7b9df' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/teacher/index.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32983573254f7c375b69a35-77957497',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'keywords' => 0,
    'injob' => 0,
    'add' => 0,
    'download' => 0,
    'upload' => 0,
    'postUrl' => 0,
    'total' => 0,
    'inJobUrl' => 0,
    'outJobUrl' => 0,
    'allJobUrl' => 0,
    'teacherList' => 0,
    'value' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7c375e21237_30023849',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7c375e21237_30023849')) {function content_54f7c375e21237_30023849($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>老师列表页面</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/teacherList/style.css" />
<!-- 定义全局变量开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/var.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 定义全局变量结束 -->
</head>
<body>
<input type="hidden" name="_keywords" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"/>
<input type="hidden" name="_inJob" value="<?php echo $_smarty_tpl->tpl_vars['injob']->value;?>
"/>
<!-- 头部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 头部结束 -->
<!-- 主要内容开始 -->
<div class="wrap layout">
    <!-- 右侧开始 -->
    <div class="mainContent comBg fr" id="mainContent">
    	<div class="teacherList" id="moduleId" pagename="teacherList">
    		<div class="topTitle">
				<!-- 录入区域开始 -->
				<div class="tii cf">
					<div class="fl">
						<a href="<?php echo $_smarty_tpl->tpl_vars['add']->value;?>
" class="comBlueBtn fl" target="_blank">录入老师</a>
					</div>
					<div class="fl slideUl posr">
						<span class="comBlueBtn">批量录入老师</span>
						<ul class="undis">
							<li>
								<a href="<?php echo $_smarty_tpl->tpl_vars['download']->value;?>
">下载信息表模版</a>
							</li>
							<li>
							<a href="<?php echo $_smarty_tpl->tpl_vars['upload']->value;?>
" target="_blank">上传信息表</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- 录入区域结束 -->
				<!-- 搜索区域开始 -->
				<div class="search cf">
					<form action="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
" method="get" class="formSearchTeacher">
						<span class="t fl">搜索老师：</span>
						<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" name="keywords" class="keywords cInput fl" placeholder="真实姓名、宣传姓名、老师编码" />
						<input type="submit" value="搜索老师" class="submits yh comBlueBtn fl">
					</form>
				</div>
				<!-- 搜索区域结束 -->
			</div>
			<!-- 老师列表开始 -->
			<div class="teacherLists">
				<div class="hd">
					<span class="fr">
						共<span class="red"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>个老师
					</span>
					<?php if ($_smarty_tpl->tpl_vars['keywords']->value=='') {?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['inJobUrl']->value;?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['injob']->value==1) {?>active<?php }?>">在职老师</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['outJobUrl']->value;?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['injob']->value==0) {?>active<?php }?>">离职老师</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['allJobUrl']->value;?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['injob']->value==2) {?>active<?php }?>">全部老师</a>
					<?php }?>
				</div>
				<div class="bd">
					<div class="comTable teacherDataList">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th>姓名<span class="grey">(括号内为宣传姓名)</span></th>
								<th width="250">学科</th>
								<th>目前任课班级数</th>
								<th>录入时间</th>
								<th></th>
						</tr>
						<?php if ($_smarty_tpl->tpl_vars['teacherList']->value!=false) {?>
						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['teacherList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
						<tr>
							<td>
								<div class="himg cf">
									<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['infoUrl'];?>
" class="blueText"><img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['path'];?>
" alt="" class="fl" target="_blank"></a>
									<ul class="fl text">
										<li>
										<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['infoUrl'];?>
" class="blueText" target="_blank"><?php echo $_smarty_tpl->tpl_vars['value']->value['truthName'];?>
</a>
										<span class="tips"><?php echo $_smarty_tpl->tpl_vars['value']->value['nickName'];?>
</span>
										<span class="red"><?php if ($_smarty_tpl->tpl_vars['value']->value['status']==0) {?>【已禁用】<?php }?></span>
										</li>
										<li class="grey">编码：<?php echo $_smarty_tpl->tpl_vars['value']->value['teacherCode'];?>
</li>
										<li class="grey">状态：<?php echo $_smarty_tpl->tpl_vars['value']->value['inJob'];?>
</li>
									</ul>
							</div>
						</td>
						<td><?php echo $_smarty_tpl->tpl_vars['value']->value['subject'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['value']->value['class'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['value']->value['createTime'];?>
</td>
						<td>
							<ul class="ctrl">
								<li>
								<?php if ($_smarty_tpl->tpl_vars['value']->value['inJobNum']!=0&&$_smarty_tpl->tpl_vars['value']->value['status']!=0) {?>
									<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['modifyUrl'];?>
" class="blueText" target="_blank">修改基本信息</a>
								<?php }?>
								</li>
								<li>
								<a href="javascript:void(0)" url="<?php echo $_smarty_tpl->tpl_vars['value']->value['actionUrl'];?>
" teacherId="<?php echo $_smarty_tpl->tpl_vars['value']->value['teacherId'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['value']->value['action']=='入职登记') {?> leaveOn<?php } else { ?> leaveOff<?php }?>"><?php echo $_smarty_tpl->tpl_vars['value']->value['action'];?>
</a>
								</li>
							</ul>
						</td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr><td>没有找到符合条件的老师</td></tr>
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
			<!-- 老师列表结束 -->
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
