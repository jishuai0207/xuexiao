<?php /* Smarty version Smarty-3.1.18, created on 2015-02-12 12:01:52
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/teacher/upload.html" */ ?>
<?php /*%%SmartyHeaderCode:36033062854dc25b008ce82-71651698%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27bc6ce0b8dd29f3d7db3e08efa5eb87eb4806ae' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/teacher/upload.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36033062854dc25b008ce82-71651698',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'step' => 0,
    'fileMd5' => 0,
    'status' => 0,
    'isup' => 0,
    'upUrl' => 0,
    'url_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54dc25b019b899_40393610',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54dc25b019b899_40393610')) {function content_54dc25b019b899_40393610($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>上传老师信息表</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/uploadTeacherInfo/style.css" />
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
    	<div class="uploadTeacherInfo" id="moduleId" teacherFile='teacherFile' pagename="uploadTeacherInfo"  step='<?php echo $_smarty_tpl->tpl_vars['step']->value;?>
' filemd5='<?php echo $_smarty_tpl->tpl_vars['fileMd5']->value;?>
' status='<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
'  isup='<?php echo $_smarty_tpl->tpl_vars['isup']->value;?>
'>
    		<div class="hd">
				<h2>上传老师信息表</h2>
			</div>
			<div class="content">
				<div class="step1">
					<div class="up">
						<form action="<?php echo $_smarty_tpl->tpl_vars['upUrl']->value;?>
" method="post" enctype="multipart/form-data">
							<input id="File1" runat="server" name="UpLoadFile" type="file" />
							<input type="submit" name="Button1" class="yh comWhiteBtn" value="上传" id="Button1" />
						</form>
					</div>
					<div class="inMsg">
						
					</div>
					<a href="javascript:void(0)" class="comBlueBtn undis cancelClick">下一步</a>
					<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['teacherStep2'];?>
?&fileMd5=<?php echo $_smarty_tpl->tpl_vars['fileMd5']->value;?>
" class="comBlueBtn undis nextBlueBtn">下一步</a>
				</div>
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
