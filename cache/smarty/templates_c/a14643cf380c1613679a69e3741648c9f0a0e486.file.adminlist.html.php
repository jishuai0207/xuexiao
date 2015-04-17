<?php /* Smarty version Smarty-3.1.18, created on 2015-03-04 19:02:11
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/manage/adminlist.html" */ ?>
<?php /*%%SmartyHeaderCode:201508844154f6e63303a4a1-65463652%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a14643cf380c1613679a69e3741648c9f0a0e486' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/manage/adminlist.html',
      1 => 1423484840,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '201508844154f6e63303a4a1-65463652',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'user' => 0,
    'v' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f6e63318c857_67312702',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f6e63318c857_67312702')) {function content_54f6e63318c857_67312702($_smarty_tpl) {?><!DOCTYPE html>
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
/css/adminList/style.css" />
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
        <div class="adminList" id="moduleId" pagename="adminList">
            <div class="conrtent">
                <div class="comTable">
                    <table cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <th>管理员</th>
                            <th>用户名</th>
                            <th>创建时间</th>
                        </tr>
						<?php if ($_smarty_tpl->tpl_vars['user']->value!=false) {?>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['user']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <tr>
							<td><?php echo $_smarty_tpl->tpl_vars['v']->value->truthName;?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['v']->value->userName;?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['v']->value->createTime;?>
</td>
                        </tr>
					<?php } ?>
					<?php } else { ?>
					<tr><td>没有管理员</td></tr>
					<?php }?>
                    </table>
                </div>
                <p class="info">添加管理员请联系爱学习客服400-898-1009</p>
                <!-- 分页开始 -->
                <div class="page cf">
                    <div class="pageContent">
					<?php echo $_smarty_tpl->tpl_vars['page']->value;?>

                    </div>
                </div>
                <!-- 分页结束 -->
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
