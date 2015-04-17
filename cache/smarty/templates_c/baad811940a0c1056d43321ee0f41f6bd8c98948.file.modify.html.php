<?php /* Smarty version Smarty-3.1.18, created on 2015-02-27 18:57:38
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/teacher/modify.html" */ ?>
<?php /*%%SmartyHeaderCode:97188731754f04da27a1042-13062949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'baad811940a0c1056d43321ee0f41f6bd8c98948' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/teacher/modify.html',
      1 => 1423647850,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97188731754f04da27a1042-13062949',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'post_config' => 0,
    'teacherId' => 0,
    'truthName' => 0,
    'sort' => 0,
    'nickname' => 0,
    'telphone' => 0,
    'subject' => 0,
    'v' => 0,
    'inJob' => 0,
    'val' => 0,
    'sex' => 0,
    'email' => 0,
    'idCard' => 0,
    'birthday_year' => 0,
    'birthday_month' => 0,
    'position' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f04da2aef297_10491739',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f04da2aef297_10491739')) {function content_54f04da2aef297_10491739($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<title>修改老师信息</title>
<link rel="shortcut icon" href=" /favicon.ico" />
<link rel="stylesheet" type="text/css" href="/<?php echo $_smarty_tpl->tpl_vars['static_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['static_version']->value;?>
/css/teacherAdd/style.css" />
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
        <div class="teacherAdd" id="moduleId" pagename="teacherAdd">
            <div class="hd">
                <h2>修改老师信息</h2>
            </div>
            <div class="content">
                <form action="/<?php echo $_smarty_tpl->tpl_vars['post_config']->value['teacherMod'];?>
" method="post" class="formInputTeacher formModifyTeacher" onsubmit="return false;" teacherId="<?php echo $_smarty_tpl->tpl_vars['teacherId']->value;?>
">
                    <ul class="pd">
                        <li class="posr cf">
                            <span class="t fl"><em class="red">*</em>真实姓名：</span>
                            <input name="truthName" type="text" class="cInput username fl" value="<?php echo $_smarty_tpl->tpl_vars['truthName']->value;?>
" />
                            <p class="grey">汉字或英文，最多4个汉字或40个英文字母</p>
                        </li>
						<!--
                        <li class="posr cf">
                            <span class="t fl"><em class="red">*</em>姓名拼音：</span>
                            <input type="text" name="sort" class="cInput username fl"  value="<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
" />
                            <p class="grey">如“王小明”的全拼为“wangxiaoming”</p>
                        </li>
						-->
                        <li class="posr cf">
                            <span class="t fl"><em class="red"></em>宣传姓名：</span>
                            <input type="text" name="nickName" class="cInput username fl" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
"  />
                            <p class="grey">老师不便透露真名时填写。如果填写，家长和学员将只看到此姓名</p>
                        </li>
                        <li class="posr cf">
                            <span class="t fl"><em class="red">*</em>手机：</span>
                            <input name="telphone" type="text" class="cInput mobile fl"  value="<?php echo $_smarty_tpl->tpl_vars['telphone']->value;?>
" />
                        </li>
                        <li class="cf subject">
                            <span class="t fl"><em class="red">*</em>学科：</span>
                            <ul class="subjectli fl">
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['subject']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <li>
<?php if ($_smarty_tpl->tpl_vars['v']->value['isselect']==1) {?>
                                <a href="javascript:void(0);" class="active" subjectId="<?php echo $_smarty_tpl->tpl_vars['v']->value['subjectId'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['subjectName'];?>
</a>
<?php } else { ?>
                                <a href="javascript:void(0);" subjectId="<?php echo $_smarty_tpl->tpl_vars['v']->value['subjectId'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['subjectName'];?>
</a>
<?php }?>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>

                        <!--<li class="posr cf">
                            <span class="t fl"><em class="red"></em>在职/离职：</span>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['inJob']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <label class="fl">
<?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <input type="radio" name="injob" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" checked class="fl sex"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>

<?php } else { ?>
                                <input type="radio" name="injob" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" class="fl sex"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>

<?php }?>
                            </label>
                                <?php } ?>
						</li> -->
                        <li class="posr cf">
                            <span class="t fl">性别：</span>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <label class="fl">
<?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <input type="radio" name="sex" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" checked class="fl sex"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>

<?php } else { ?>
                                <input type="radio" name="sex" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" class="fl sex"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>

<?php }?>
                            </label>
                            <?php } ?>
                        </li>
                        <li class="posr cf">
                            <span class="t fl"><em class="red"></em>邮箱：</span>
                            <input type="text" name="email" class="cInput email fl"  value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
"/>
                        </li>
                        <li class="posr cf">
                            <span class="t fl">身份证号：</span>
                            <input type="text" name="idCard" class="cInput sfz fl" value="<?php echo $_smarty_tpl->tpl_vars['idCard']->value;?>
"/>
                        </li>
                        <li class="posr cf">
                            <span class="t fl">出生年月：</span>
                            <select name="year" id="" class="fl yearSelect">
                                <option value="">请选择年</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['birthday_year']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['year'];?>
" selected="selected" ><?php echo $_smarty_tpl->tpl_vars['val']->value['year'];?>
</option>
<?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['year'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['year'];?>
</option>
<?php }?>
                                <?php } ?>
                            </select>
                            <select name="month" id="" class="fl monthSelect">
                                <option value="">请选择月</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['birthday_month']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['month'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['val']->value['month'];?>
</option>
<?php } else { ?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['month'];?>
" ><?php echo $_smarty_tpl->tpl_vars['val']->value['month'];?>
</option>
<?php }?>
                                <?php } ?>
                            </select>
                        </li>
                        <li class="posr cf">
                            <span class="t fl">全职/兼职：</span>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <label class="fl">
<?php if ($_smarty_tpl->tpl_vars['val']->value['isselect']==1) {?>
                                <input type="radio" checked name="position" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" class="fl sex"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>

<?php } else { ?>
                                <input type="radio" name="position" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" class="fl sex"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>

<?php }?>
                            </label>
                                <?php } ?>
                        </li>
                        <li>
                            <div class="subm">
                                <input type="submit" value="提交" class="comBlueBtn yh submitDiv">
                            </div>
                        </li>
                    </ul>
                </form>
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
