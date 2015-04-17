<?php /* Smarty version Smarty-3.1.18, created on 2015-02-12 12:01:53
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/teacher/check.html" */ ?>
<?php /*%%SmartyHeaderCode:41925284054dc25b1312be0-94079343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70af2fe6fcabc4f732b0ed1d1e453591afcd802e' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/teacher/check.html',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41925284054dc25b1312be0-94079343',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'fileMd5' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54dc25b13ffb90_62527874',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54dc25b13ffb90_62527874')) {function content_54dc25b13ffb90_62527874($_smarty_tpl) {?><!DOCTYPE html>
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
    	<div class="uploadTeacherInfo" id="moduleId" check="check" filemd5="<?php echo $_smarty_tpl->tpl_vars['fileMd5']->value;?>
" pagename="uploadTeacherInfo">
    		<div class="hd">
				<h2>上传老师信息表</h2>
			</div>
			<div class="content">
				<!-- 上传第二步开始 -->
				<div class="step2">
					<!-- 老师信息条数开始 -->
					<div class="studentInfos">
						<div class="hd">
							<span class="fr grey">上传文件：老师信息表</span>
							老师信息条数
						</div>
						<div class="bd">
							总数：<span id="total"></span>
							<span class="s">正常：<em id="normal"></em></span>
							有问题：<em class="red" id="errNum"></em>
						</div>
					</div>
					<!-- 老师信息条数结束 -->
					<!-- 有问题资源开始 -->
					<div class="problems">
						<div class="hd">
							<span class="fl">
								以下老师信息可能存在问题
							</span>
							<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['back'];?>
" class="comBlueBtn">返回上一步,重新上传文件</a>
						</div>
						<div class="comTable wrongAreaList">
							
						</div>
						<!-- 分页开始 -->
						<div class="page cf">
							<div class="pageContent">
								
							</div>
						</div>
						<!-- 分页结束 -->
					</div>
					<!-- 有问题资源结束 -->
					<!-- 提交区域开始 -->
					<div class="entryBox">
						<a href="javascript:void(0)" class="comBlueBtn subs">确定</a>
						<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['back'];?>
" class="comWhiteBtn">上一步</a>
					</div>
					<!-- 提交区域结束 -->
				</div>
				<!-- 上传第二部结束 -->
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
