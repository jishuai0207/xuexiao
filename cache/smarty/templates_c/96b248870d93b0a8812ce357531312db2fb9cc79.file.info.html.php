<?php /* Smarty version Smarty-3.1.18, created on 2015-03-04 19:53:39
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/student/info.html" */ ?>
<?php /*%%SmartyHeaderCode:34307487954f6f243cfda67-07597310%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96b248870d93b0a8812ce357531312db2fb9cc79' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/student/info.html',
      1 => 1423638375,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34307487954f6f243cfda67-07597310',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'info' => 0,
    'url' => 0,
    'studentId' => 0,
    'type' => 0,
    'class' => 0,
    'v' => 0,
    'v1' => 0,
    'k1' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f6f2440b4201_06951674',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f6f2440b4201_06951674')) {function content_54f6f2440b4201_06951674($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>学员详情</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/studentInfos/style.css" />
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
    	<div class="studentInfos" id="moduleId" pagename="studentInfos">
    		<div class="topTitle">
    			<!--主要信息开始-->
    			<div class="studentInfo cf posr">
    				<p class="hsImg fl">
    					<img src="<?php echo $_smarty_tpl->tpl_vars['info']->value['path'];?>
" class="fl" />
    				</p>
    				<div class="text fl">
    					<h2 class="studentName"><?php echo $_smarty_tpl->tpl_vars['info']->value['truthName'];?>
</h2>
    					<ul>
    						<li>
    							<span class="t fl">学员编码：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['code'];?>

    						</li>
    						<li>
    							<span class="t fl">家长A：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['parentA'];?>

    						</li>
    						<li>
    							<span class="t fl">用户名：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>

    						</li>
    						<li>
    							<span class="t fl">原学号：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['studentCode'];?>

    						</li>
							<?php if ($_smarty_tpl->tpl_vars['info']->value['parentB']!='') {?>
    						<li>
    							<span class="t fl">家长B：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['parentB'];?>

    						</li>
							<?php }?>
    						<li>
    							<span class="t fl">性别：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['sex'];?>

    						</li>
    						<li>
    							<span class="t fl">录入时间：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['creatTime'];?>

    						</li>
    						<li>
    							<span class="t fl">出生年月：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['birthday'];?>

    						</li>
    						<li>
    							<span class="t fl">在校年级：</span>
    							<?php echo $_smarty_tpl->tpl_vars['info']->value['gradeName'];?>

    						</li>
                            <li class="long">
                                <span class="t fl">所在学校：</span>
                                <?php echo $_smarty_tpl->tpl_vars['info']->value['school'];?>

                            </li>
    					</ul>
    				</div>
    				<div class="actions">
    					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['modify'];?>
" class="modifyBases comWhiteBtn">修改基本信息</a>
    					<a href="javascript:void(0)" url="<?php echo $_smarty_tpl->tpl_vars['url']->value['reset'];?>
" class="resetPassword comWhiteBtn">重置密码</a>
    				</div>
    			</div>
    			<!--主要信息结束-->
    		</div>
			<div class="classLists" studentid="<?php echo $_smarty_tpl->tpl_vars['studentId']->value;?>
">
                <div class="joinClass">
                    <a href="javascript:void(0)" class="comBlueBtn joinNewClass">加入新班级</a>
                </div>
				<div class="hd">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['curr'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['type']->value=='1') {?> active<?php }?>">目前班级</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['his'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['type']->value=='0') {?> active<?php }?>">历史班级</a> | 
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['all'];?>
" class="blueText <?php if ($_smarty_tpl->tpl_vars['type']->value=='all') {?> active<?php }?>">全部班级</a>
				</div>
				<div class="comTable">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<th>班级</th>
							<th>老师</th>
							<th>班级起止时间</th>
							<th>加入班级时间</th>
							<th></th>
						</tr>
						<?php if ($_smarty_tpl->tpl_vars['class']->value!=false) {?>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['class']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
						<tr>
							<td>
								<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['classUrl'];?>
" class="blueText studentClassName"><?php echo $_smarty_tpl->tpl_vars['v']->value['className'];?>
</a>
							</td>
							<td>
								<?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_smarty_tpl->tpl_vars['k1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['v']->value['teacher']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value) {
$_smarty_tpl->tpl_vars['v1']->_loop = true;
 $_smarty_tpl->tpl_vars['k1']->value = $_smarty_tpl->tpl_vars['v1']->key;
?>
								<?php if ($_smarty_tpl->tpl_vars['v1']->value!=null) {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['v1']->value['teacherUrl'];?>
" class="blueText"><?php echo $_smarty_tpl->tpl_vars['v1']->value['truthName'];?>
</a><?php if ($_smarty_tpl->tpl_vars['v']->value['teacherCount']==2) {?><?php if ($_smarty_tpl->tpl_vars['k1']->value==0) {?>、<?php }?><?php }?>
								<?php }?>
								<?php } ?>
							</td>
							<td>
						<?php echo $_smarty_tpl->tpl_vars['v']->value['beginTime'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['endTime'];?>

							</td>
							<td>
								<?php echo $_smarty_tpl->tpl_vars['v']->value['joinTime'];?>

							</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['v']->value['current']==1) {?>
								<a href="javascript:void(0)" studentid="<?php echo $_smarty_tpl->tpl_vars['studentId']->value;?>
" classid="<?php echo $_smarty_tpl->tpl_vars['v']->value['classId'];?>
" class="blueText quiteClass">退班</a>
								<?php }?>
							</td>
						</tr>
					<?php } ?>
					<?php } else { ?>
					<tr><td>没有加入任何班级</td></tr>
					<?php }?>
					</table>
				</div>
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
<!-- 转班弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_classList_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 转班弹出层样式结束 -->
</body>
</html>
<?php }} ?>
