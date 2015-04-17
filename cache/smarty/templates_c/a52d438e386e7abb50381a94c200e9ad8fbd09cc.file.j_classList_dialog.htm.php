<?php /* Smarty version Smarty-3.1.18, created on 2015-03-04 19:53:40
         compiled from "application/views/include/dialog_html/j_classList_dialog.htm" */ ?>
<?php /*%%SmartyHeaderCode:21720320954f6f2442892c6-60765562%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a52d438e386e7abb50381a94c200e9ad8fbd09cc' => 
    array (
      0 => 'application/views/include/dialog_html/j_classList_dialog.htm',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21720320954f6f2442892c6-60765562',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'classId' => 0,
    'gradelist' => 0,
    'val' => 0,
    'subjectlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f6f2442f4a44_66366189',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f6f2442f4a44_66366189')) {function content_54f6f2442f4a44_66366189($_smarty_tpl) {?><div class="j_classList_dialog undis">
    <div class="j_classList_dialog cf" classid="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" studentId="">
        <!-- 搜索加筛选项开始 -->
        <div class="hd">
            <!-- 筛选开始 -->
            <span class="screen fr">
                <select name="" id="" class="grades fr">
                    <option value="">全部年级</option>
                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['gradelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gradeId'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['gradeName'];?>
</option>
                <?php } ?>
                </select>
                <select name="" id="" class="subjects fr">
                    <option value="">全部科目</option>
                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['subjectlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['subjectId'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['subjectName'];?>
</option>
                <?php } ?>
                </select>
            </span>
            <!-- 筛选结束 -->
            <!-- 搜索开始 -->
            <span class="fl searchClass">
                <input type="text" class="in cInput fl" placeholder="任课老师姓名、班级编码" />
                <a href="javascript:void(0);" class="comBlueBtn fl submits">搜索</a>
                <a href="javascript:void(0);" class="fl allDatas blueText">显示全部</a>
            </span>
            <!-- 搜索结束 -->
        </div>
        <!-- 搜索加筛选项结束 -->
        <!-- 搜索信息列表开始 -->
        <div class="bd">
            <ul class="title cf">
                <li class="radio fl">radio</li>
                <li class="name fl">班级名称</li>
                <li class="code fl">班级编码</li>
                <li class="teacher fl">任课老师</li>
                <li class="subject fl">年级科目</li>
                <li class="studentNumber fl">学员数</li>
            </ul>
            <div class="cons classListShows">

            </div>
        </div>
        <!-- 搜索信息列表结束 -->
    </div>
</div>
<?php }} ?>
