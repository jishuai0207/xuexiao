<?php /* Smarty version Smarty-3.1.18, created on 2015-03-04 19:02:08
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/classtype/index.html" */ ?>
<?php /*%%SmartyHeaderCode:113649095354f6e63099e781-38365187%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f0210b407bec84a4d20037a70e278e0d73c9b73' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/classtype/index.html',
      1 => 1425282307,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113649095354f6e63099e781-38365187',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'url' => 0,
    'grade' => 0,
    'cgrade' => 0,
    'k' => 0,
    'v' => 0,
    'total' => 0,
    'classTypeList' => 0,
    'value' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f6e630c21d44_39446311',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f6e630c21d44_39446311')) {function content_54f6e630c21d44_39446311($_smarty_tpl) {?><!DOCTYPE html>
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
/css/classtype/style.css" />
<!-- 定义全局变量开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/var.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 定义全局变量结束 -->
</head>
<body>
<!-- 头部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 头部结束 -->
<!-- 主要内容开始 -->
<div class="wrap layout" id="moduleId" pagename="classType">
    <!-- 右侧开始 -->
    <div class="mainContent comBg fr" id="mainContent">
        <div class="classtype" id="moduleId" pagename="">
            <div class="topTitle">
                <h2 class="titles">我的班型</h2>
                <!-- 搜索开始 -->
                <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['post'];?>
" class="searchBox cf">
                    <select name="grade" id="" class="fl">
                        <option value="">全部年级</option>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['grade']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<?php if ($_smarty_tpl->tpl_vars['cgrade']->value==$_smarty_tpl->tpl_vars['k']->value) {?>
						<option selected="selected" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
						<?php } else { ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
						<?php }?>
						<?php } ?>
                    </select>
                    <input type="submit" class="submits comBlueBtn yh fl" value="筛选" />
                </form>
                <!-- 搜索结束 -->
            </div>
            <!-- 主要区域开始 -->
            <div class="classTypeList">
                <div class="hd">
                    <span class="fr">
						<?php if ($_smarty_tpl->tpl_vars['total']->value!=0) {?>
						共<em><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</em>个班型
						<?php }?>
                    </span>
                </div>
                <div class="bd">
                    <ul class="titleUl cf">
                        <li class="types">自定义名称</li>
                        <li class="code">初始名称</li>
                        <li class="subject">学科</li>
                        <li class="grade">年级</li>
                        <li class="period">学期</li>
                        <li class="status">状态</li>
                        <li class="currentClassNum">当前班级</li>
                        <li class="historyClassNum">历史班级</li>
                    </ul>
					<?php if ($_smarty_tpl->tpl_vars['classTypeList']->value!=false) {?>
					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['classTypeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                    <ul class="contentUl cf">
                        <li class="types">
                            <div class="typesEdit">
                                <div class="editName"><span class="typeName"><?php echo $_smarty_tpl->tpl_vars['value']->value['custom'];?>
</span><a class="fblue editBtn" href="javascript:void(0)">【修改】</a></div>
                                <div class="editNameHidden">
                                    <input value="<?php echo $_smarty_tpl->tpl_vars['value']->value['custom'];?>
" name="typeName" maxlength="20"/>
									<div><a class="sureEdit" typecode="<?php echo $_smarty_tpl->tpl_vars['value']->value['code'];?>
" href="javascript:void(0)">确定</a>
                                         <a class="fblue cancleEdit" href="javascript:void(0)">取消</a></div>
                                </div>
                                <div class="typesCode grey">班型编码：<?php echo $_smarty_tpl->tpl_vars['value']->value['code'];?>
</div>
                            </div>
                        </li>
                        <li class="code"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</li>
                        
                        <li class="subject"><?php echo $_smarty_tpl->tpl_vars['value']->value['sname'];?>
</li>
                        <li class="grade"><?php echo $_smarty_tpl->tpl_vars['value']->value['gname'];?>
</li>
                        <li class="periodArea">
                            <div class="periodAreaList">
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value']->value['period']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                <ul class="cf">
                                    <li class="period"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</li>
                                    <li class="status"><?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
</li>
                                    <li class="currentClassNum">
                                    <?php if ($_smarty_tpl->tpl_vars['v']->value['cur']!='0') {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['curUrl'];?>
" target="_blank" class="blueText"><?php echo $_smarty_tpl->tpl_vars['v']->value['cur'];?>
</a>
                                        <?php } else { ?>
                                        <?php echo $_smarty_tpl->tpl_vars['v']->value['cur'];?>

                                        <?php }?>
                                    </li>
                                    <li class="historyClassNum">
                                    <?php if ($_smarty_tpl->tpl_vars['v']->value['his']!='0') {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['hisUrl'];?>
" target="_blank" class="blueText"><?php echo $_smarty_tpl->tpl_vars['v']->value['his'];?>
</a>
                                        <?php } else { ?>
                                        <?php echo $_smarty_tpl->tpl_vars['v']->value['his'];?>

                                        <?php }?>
                                    </li>
                                </ul>
								<?php } ?>
                            </div>
                        </li>
                    </ul>
					<?php } ?>
				<?php } else { ?>
					<li>没有班型信息</li>
				<?php }?>
                </div>
				<!-- 分页开始 -->
				<div class="page cf">
					<div class="pageContent">
								<?php echo $_smarty_tpl->tpl_vars['page']->value;?>

					</div>
				</div>
            </div>
            <!-- 主要区域结束 -->
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
