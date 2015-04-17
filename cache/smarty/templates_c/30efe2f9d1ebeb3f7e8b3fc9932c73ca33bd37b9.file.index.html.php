<?php /* Smarty version Smarty-3.1.18, created on 2015-03-04 19:02:12
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/orgclass/index.html" */ ?>
<?php /*%%SmartyHeaderCode:35549707754f6e634d08518-72378115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30efe2f9d1ebeb3f7e8b3fc9932c73ca33bd37b9' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/orgclass/index.html',
      1 => 1425009002,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '35549707754f6e634d08518-72378115',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    '_p' => 0,
    '_teacher' => 0,
    '_gradeId' => 0,
    '_classTypeCode' => 0,
    '_classTypePeriod' => 0,
    '_isEnd' => 0,
    '_keywords' => 0,
    'ClassTypeInfo' => 0,
    'createClass' => 0,
    'url_config' => 0,
    'grade' => 0,
    'val' => 0,
    'teacher' => 0,
    'classTypeCodeList' => 0,
    'classTypePeriodArr' => 0,
    'key' => 0,
    'count' => 0,
    'classlist' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f6e6352cbb17_40135399',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f6e6352cbb17_40135399')) {function content_54f6e6352cbb17_40135399($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>班级列表</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/classList/style.css" />
<!-- 定义全局变量开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/var.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 定义全局变量结束 -->
</head>
<body>
<!-- 隐藏域开始 -->
<input type="hidden" name="_p" value="<?php echo $_smarty_tpl->tpl_vars['_p']->value;?>
">
<input type="hidden" name="_teacher" value="<?php echo $_smarty_tpl->tpl_vars['_teacher']->value;?>
">
<input type="hidden" name="_gradeId" value="<?php echo $_smarty_tpl->tpl_vars['_gradeId']->value;?>
">
<input type="hidden" name="_classTypeCode" value="<?php echo $_smarty_tpl->tpl_vars['_classTypeCode']->value;?>
">
<input type="hidden" name="_classTypePeriod" value="<?php echo $_smarty_tpl->tpl_vars['_classTypePeriod']->value;?>
">
<input type="hidden" name="_isEnd" value="<?php echo $_smarty_tpl->tpl_vars['_isEnd']->value;?>
">
<input type="hidden" name="_keywords" value="<?php echo $_smarty_tpl->tpl_vars['_keywords']->value;?>
">
<!-- 隐藏域结束 -->
<!-- 头部开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 头部结束 -->
<!-- 主要内容开始 -->
<div class="wrap layout">
    <!-- 右侧开始 -->
    <div class="mainContent comBg fr" id="mainContent">
        <div class="classList" id="moduleId" pagename="classList">
            <div class="topTitle">
                <!-- 班型名称开始 -->
                <?php if ($_smarty_tpl->tpl_vars['ClassTypeInfo']->value!='') {?>
                <div class="tips"><?php echo $_smarty_tpl->tpl_vars['ClassTypeInfo']->value;?>
</div>
                <?php }?>
                <!-- 班型名称结束 -->
                <!-- 创建班级按钮开始 -->
                <div class="creatBtn">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['createClass']->value;?>
" target="_blank"  class="comBlueBtn">创建班级</a>
                </div>
                <!-- 创建班级按钮结束 -->
                <!-- 搜索班级开始 -->
                <div class="searchBox cf">
                    <!-- 左侧搜索班级开始 -->
                    <div class="searchBoxLeft fl">
                        <form method='post' action="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classList'];?>
" class="formSearchClass">
                            <span class="t fl">搜索班级：</span>
                            <input type="text" class="cInput fl" name='keywords' value="<?php echo $_smarty_tpl->tpl_vars['_keywords']->value;?>
" placeholder="班级编码/名称、老师真名/宣传姓名" />
                            <input type="submit" class="submits yh comBlueBtn fl" value="搜索" />
                        </form>
                    </div>
                    <!-- 左侧搜索班级结束 -->
                    <!-- 班级筛选开始 -->
                    <div class="selectList fr">
                        <form method='post' class="formSearchClassList">
                            <select name="gradeId" id="grade" class="fl">
                                <option value="">全部年级</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['grade']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['grade_id'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['val']->value['grade_name'];?>
</option>
                                <?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['grade_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['grade_name'];?>
</option>
                                <?php }?>
                                <?php } ?>
                            </select>
                            <select name="teacherId" id="teacher" class="fl">
                                <option value="">全部老师</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['teacher']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['teacherId'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['val']->value['truthName'];?>
</option>
                                <?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['teacherId'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['truthName'];?>
</option>
                                <?php }?>
                                <?php } ?>
                            </select>
                            <select name="classTypeCode" id="classType" class="fl">
                                <option value="">全部班型</option>
<?php if ($_smarty_tpl->tpl_vars['classTypeCodeList']->value!='') {?>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['classTypeCodeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['classTypeCode'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['val']->value['classTypeName'];?>
</option>
                                <?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['classTypeCode'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['classTypeName'];?>
</option>
                                <?php }?>
                                <?php } ?>
<?php }?>
                            </select>
                            <select name="classTypePeriod" id="classTypePeriod" class="fl">
                                <option value="">全部学期</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['classTypePeriodArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['val']->value['periodName'];?>
</option>
                                <?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['periodName'];?>
</option>
                                <?php }?>
                                <?php } ?>
                            </select>
                            <input type="submit" class="submits yh comBlueBtn fl" value="筛选" />
                        </form>
                    </div>
                    <!-- 班级筛选结束 -->
                </div>
                <!-- 搜索班级结束 -->
            </div>
            <!-- 班级列表开始 -->
            <div class="classLists">
                <div class="hd">
                    <?php if ($_smarty_tpl->tpl_vars['_keywords']->value=='') {?>
                    <span class="fl">
                        <a href="javascript:void(0)" data-id="0">未结课班级</a> | 
                        <a href="javascript:void(0)" data-id="1">已结课班级</a> | 
                        <a href="javascript:void(0)" data-id="2">全部班级</a>
                    </span>
                    <?php }?>
                    <span class="fr">
                        共
                        <em class="red"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</em>
                        个班级
                    </span>
                </div>
                <div class="bd">
                    <ul class="tableTitle cf">
                        <li class="className">班级名称</li>
                        <li class="teacher">任课老师</li>
                        <li class="grade">年级/学科</li>
                        <li class="period">课节数(已排课)</li>
                        <li class="student">总学员(已登录)</li>
                        <li class="time">创建时间</li>
                        <li class="ctrl"></li>
                    </ul>
                    <ul class="tabContent">
                        <?php if ($_smarty_tpl->tpl_vars['classlist']->value!=false) {?>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['classlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                        <input type="hidden" name="classId" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['classId'];?>
"/>
                        <li class="cf">
                        <div class="box fl">
                            <div class="secUl cf">
                                <ul>
                                    <li class="className">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
" class="blueText" target="_blank" ><?php echo $_smarty_tpl->tpl_vars['val']->value['className'];?>
</a>
                                    </li>
                                    <li class="teacher">
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['teacher'];?>

                                    </li>
                                    <li class="grade">
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['gradeName'];?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['Subject'];?>

                                    </li>
                                    <li class="period">
                                    <span >
<?php if ($_smarty_tpl->tpl_vars['val']->value['allLessonNum']!=$_smarty_tpl->tpl_vars['val']->value['readyLessonNum']) {?>
<a class="red" href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
&pageType=schedule#currentSchedule">
<?php } else { ?>
<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
">
<?php }?>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['allLessonNum'];?>
(<?php echo $_smarty_tpl->tpl_vars['val']->value['readyLessonNum'];?>
)</a>

                                    </span>
                                    </li>
                                    <li class="student">
<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
#currentStudent"><?php echo $_smarty_tpl->tpl_vars['val']->value['studentNumber'];?>
(<?php echo $_smarty_tpl->tpl_vars['val']->value['loginNum'];?>
)</a>
                                    </li>
                                    <li class="time">
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['createTime'];?>

                                    </li>
                                </ul>
                            </div>
                            <p class="tips">

                            编码:<?php echo $_smarty_tpl->tpl_vars['val']->value['classId'];?>

                            状态:<?php echo $_smarty_tpl->tpl_vars['val']->value['classEndStatus'];?>

                            <span class="ml">班型：<?php echo $_smarty_tpl->tpl_vars['val']->value['classTypeName'];?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['periodTitle'];?>
</span>
                            </p>
                        </div>
<?php if ($_smarty_tpl->tpl_vars['val']->value['ClassStatus']==0) {?>
                        <div class="ctrlList fr">         
                            <ul>
                                <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
#currentStudent" target="_blank"  class="blueText">学员管理</a>
                                </li>
                                <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
&pageType=schedule#currentSchedule"  target="_blank" class="blueText">代课管理</a>
                                </li>
                                <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['classUrl'];?>
#currentTeacherRule" target="_blank"  class="blueText">任课老师管理</a>
                                </li>
                                <li>
                                <a href="javascript:void(0)" class="blueText j_modifyBaseInfo" place="<?php echo $_smarty_tpl->tpl_vars['val']->value['place'];?>
" classid="<?php echo $_smarty_tpl->tpl_vars['val']->value['classId'];?>
">修改基本信息</a>
                                </li>
                            </ul>
                        </div>
<?php }?>
                        </li>
<?php } ?>
<?php } else { ?>
<p class="alignCenter">未找到班级信息</p>
<?php }?>
                    </ul>
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
<!-- 修改基本信息弹出层样式开始 -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['site_url']->value)."/include/dialog_html/j_modifyBaseInfo_dialog.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- 修改基本信息弹出层样式结束 -->
</body>
</html>
<?php }} ?>
