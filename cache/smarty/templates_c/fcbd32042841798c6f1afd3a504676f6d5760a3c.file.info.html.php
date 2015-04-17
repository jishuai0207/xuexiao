<?php /* Smarty version Smarty-3.1.18, created on 2015-03-03 12:08:31
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/orgclass/info.html" */ ?>
<?php /*%%SmartyHeaderCode:186899530854f533bf9fbfd9-44675114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcbd32042841798c6f1afd3a504676f6d5760a3c' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/orgclass/info.html',
      1 => 1425008699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186899530854f533bf9fbfd9-44675114',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'classId' => 0,
    'info' => 0,
    'pageType' => 0,
    'teacherList' => 0,
    'val' => 0,
    'count_teacher' => 0,
    'key' => 0,
    'url_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f533bfdf81b7_35189417',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f533bfdf81b7_35189417')) {function content_54f533bfdf81b7_35189417($_smarty_tpl) {?><!DOCTYPE html>
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
/css/classInfo/style.css" />
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
    	<div class="classInfo" id="moduleId" pagename="classInfo" classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
">
    		<div class="topTitle">
				<!-- 班级信息开始 -->
				<div class="info">
					<h2>
                    	<span id="className"><?php echo $_smarty_tpl->tpl_vars['info']->value['className'];?>
</span>
						<span>【<?php echo $_smarty_tpl->tpl_vars['info']->value['classStatusDesc'];?>
】</span>
					</h2>
					<div class="bd cf">
						<ul class="fl">
							<li>班级编码：<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
</li>
							<li>课节数：<?php echo $_smarty_tpl->tpl_vars['info']->value['classNumber'];?>
</li>
							<li>当前学员：<span id="studentNums"><?php echo $_smarty_tpl->tpl_vars['info']->value['studentNumber'];?>
</span>人</li>
							<li>授课地点: <span id="place" place="<?php echo $_smarty_tpl->tpl_vars['info']->value['place'];?>
"><?php if ($_smarty_tpl->tpl_vars['info']->value['place']!='') {?><?php echo $_smarty_tpl->tpl_vars['info']->value['place'];?>
<?php } else { ?>--<?php }?></span></li>
							<li>年级学科：<?php echo $_smarty_tpl->tpl_vars['info']->value['gradeName'];?>
<?php echo $_smarty_tpl->tpl_vars['info']->value['subjectName'];?>
</li>
							<li>起止时间：<?php echo $_smarty_tpl->tpl_vars['info']->value['beginTime'];?>
至<?php echo $_smarty_tpl->tpl_vars['info']->value['endTime'];?>
</li>
							<li>班型：<?php echo $_smarty_tpl->tpl_vars['info']->value['classTypeName'];?>
-<?php echo $_smarty_tpl->tpl_vars['info']->value['classTypePeriodName'];?>
</li>
							<li>授课时段：<?php echo $_smarty_tpl->tpl_vars['info']->value['day'];?>
 <?php echo $_smarty_tpl->tpl_vars['info']->value['beginTimeSlot'];?>
至<?php echo $_smarty_tpl->tpl_vars['info']->value['endTimeSlot'];?>
</li>
							<li>创建时间：<?php echo $_smarty_tpl->tpl_vars['info']->value['createTime'];?>
</li>
						</ul>
<?php if ($_smarty_tpl->tpl_vars['info']->value['classStatus']==0) {?>
						<p class="fl">
							<a href="javascript:void(0)" class="comWhiteBtn j_modifyBaseInfo" pageType="<?php echo $_smarty_tpl->tpl_vars['pageType']->value;?>
">修改基本信息</a>
							<a href="javascript:void(0)" class="blueText j_delClassInfo" classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
">删除班级</a>
						</p>
<?php }?>
					</div>
					<div class="ft ctrlArea" id="currentTeacherRule">
						<ul class="fl">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['teacherList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
							<li class="cf">
<?php if ($_smarty_tpl->tpl_vars['info']->value['classStatus']==0) {?>
								<span class="ml fr">
                                    <a href="javascript:void(0)" teacherIdOld="<?php echo $_smarty_tpl->tpl_vars['val']->value->teacherId;?>
" secheduleNum="<?php echo $_smarty_tpl->tpl_vars['val']->value->secheduleNum;?>
" pageType="<?php echo $_smarty_tpl->tpl_vars['pageType']->value;?>
" class="blueText changeClass">更换</a> 
                            <?php if ($_smarty_tpl->tpl_vars['count_teacher']->value>1) {?> 
									|<a href="javascript:void(0)" class="blueText delTeacher" classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" teacherId="<?php echo $_smarty_tpl->tpl_vars['val']->value->teacherId;?>
" pageType="<?php echo $_smarty_tpl->tpl_vars['pageType']->value;?>
">删除</a>
                            <?php }?>
								</span>
<?php }?>
								<span class="teacherRule">任课老师<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</span>：<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value->teacherUrl;?>
" class="blueText teacherNowName"><?php echo $_smarty_tpl->tpl_vars['val']->value->truthName;?>
</a>
							</li>
                            <?php } ?>
						</ul>
						<?php if ($_smarty_tpl->tpl_vars['count_teacher']->value<2&&$_smarty_tpl->tpl_vars['info']->value['classStatus']==0) {?>
						<p class="fr">
							<a href="javascript:void(0)"  classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" class="comWhiteBtn j_addTeacher fl" pageType="<?php echo $_smarty_tpl->tpl_vars['pageType']->value;?>
">添加老师</a>
						</p>
						<?php }?>
					</div>
				</div>
				<!-- 班级信息结束 -->
			</div>
			<!-- 学员列表开始 -->
			<div class="studentLists" classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" classStatus="<?php echo $_smarty_tpl->tpl_vars['info']->value['classStatus'];?>
">
				<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='student') {?>
				<div class="hd" id="currentStudent">
					<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classInfo'];?>
?classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
#currentStudent"  class="blueText active">当前学员</a>
					<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classInfo'];?>
?classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
&pageType=schedule#currentSchedule" class="blueText">讲次列表</a>
				</div>
				<div class="bd">
					<!-- 添加学员区域开始 -->
					<div class="ti cf">
						<div class="fr">
							共<span class="red"><?php echo $_smarty_tpl->tpl_vars['info']->value['studentNumber'];?>
</span>个学员,<span class="red"><?php echo $_smarty_tpl->tpl_vars['info']->value['stuLogNum'];?>
</span>个登陆过
						</div>
<?php if ($_smarty_tpl->tpl_vars['info']->value['classStatus']==0) {?>
						<div class="fl">
							<a href="javascript:void(0)" classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" class="comBlueBtn fl j_addStudent">添加学员</a>
							<div class="fl slideUl posr">
								<span class="comBlueBtn">批量录入学员</span>
								<ul class="undis">
									<li>
									<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classStuDownload'];?>
?classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
">下载信息表模版</a>
									</li>
									<li>
										<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classStuUpload'];?>
?classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" target="_blank">上传信息表</a>
									</li>
								</ul>
							</div>
						</div>
<?php }?>
					</div>
					<!-- 添加学员区域结束 -->
					<!-- 学员列表开始 -->
					<div class="comTable currentStudentShows">
						
					</div>
					<!-- 学员列表结束 -->
				</div>
				<!-- 分页开始 -->
				<div class="page cf">
					<div class="pageContent">
						
					</div>
				</div>
				<!-- 分页结束 -->
				<?php } else { ?>
				<div class="hd" id="currentSchedule">
					<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classInfo'];?>
?classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
&pageType=student" class="blueText">当前学员</a>
					<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classInfo'];?>
?classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
&pageType=schedule" class="blueText active active2">讲次列表</a>
				</div>
				<div class="bd">
					<!-- 批量排课区域开始 -->
					<div class="ti cf">
						<span class="fr">
							共<span class="red"><?php echo $_smarty_tpl->tpl_vars['info']->value['classNumber'];?>
</span>节课
						</span>
					</div>
					<!-- 批量排课区域结束 -->
					<!-- 课表列表开始 -->
					<div class="comTable currentScheduleShows">
						
					</div>
					<!-- 课表列表结束 -->
				</div>
				<!-- 分页开始 -->
				<div class="page cf">
					<div class="pageContent">
						
					</div>
				</div>
				<!-- 分页结束 -->
				<?php }?>
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
<!-- <div style="height:1000px">aa</div> -->
<!-- 底部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 底部结束 -->
<!-- js引入开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/js.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--js引入结束-->
<!-- 添加学员弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_addStudent_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 添加学员弹出层样式结束 -->
<!-- 添加老师弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_addTeacher_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 添加老师弹出层样式结束 -->
<!-- 修改基本信息弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_modifyBaseInfo_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 修改基本信息弹出层样式结束 -->
<!-- 转班弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_classList_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 转班弹出层样式结束 -->
<!-- 排课弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_startSchedule_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 排课弹出层样式结束 -->

</body>
</html>
<?php }} ?>
