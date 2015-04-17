<?php /* Smarty version Smarty-3.1.18, created on 2015-03-03 12:08:32
         compiled from "application/views/include/dialog_html/j_addStudent_dialog.htm" */ ?>
<?php /*%%SmartyHeaderCode:194933555454f533c0092eb2-27801214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9632a099c4c108494ea158805116f544ec68c53a' => 
    array (
      0 => 'application/views/include/dialog_html/j_addStudent_dialog.htm',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '194933555454f533c0092eb2-27801214',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gradelist' => 0,
    'val' => 0,
    'view_config' => 0,
    'studentList' => 0,
    'key' => 0,
    'vals' => 0,
    'url_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f533c017ead9_65108332',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f533c017ead9_65108332')) {function content_54f533c017ead9_65108332($_smarty_tpl) {?><div class="j_addStudent_dialog undis">
    <div class="classInfo cf">
        <!-- 内容开始 -->
        <div class="allStudent_beta cf">
            <!-- 全部学员开始 -->
            <div class="studentSelect fl">
                <span class="title">全部学员</span>
                <div class="studentArea">
                    <div class="hd">
                        <!-- <div class="slideUl gradeDiv fr posr">
                            <span class="t">全部年级</span>
                            <ul class="cf undis">
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['gradelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <li>
                                <a href="javascript:void(0);" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gradeId'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['gradeName'];?>
</a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div> -->
                        <div action="/<?php echo $_smarty_tpl->tpl_vars['view_config']->value['classAddStuList'];?>
" class="studentSelectSearchBox">
                            <input type="text" class="cInput studentSelectSearchBox fl" placeholder="学员姓名、编码" />
                            <a class="submits comBlueBtn fl">搜索</a>
                        </div>
                        <!--<a href="javascript:void(0);" class="blueText
                        allDatas fl">显示全部</a>-->
                    </div>
                    <div class="bd studentShows">
                        <!--<?php if ($_smarty_tpl->tpl_vars['studentList']->value!='') {?>
<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['studentList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                        <div class="box">
                            <span class="tit"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</span>
                            <ul>
                            <?php  $_smarty_tpl->tpl_vars['vals'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vals']->_loop = false;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vals']->key => $_smarty_tpl->tpl_vars['vals']->value) {
$_smarty_tpl->tpl_vars['vals']->_loop = true;
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['vals']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['vals']->value['isInThisClass']=='1') {?>
                                <li class="cf active">
<?php } else { ?>
                                <li class="cf" studentId = "<?php echo $_smarty_tpl->tpl_vars['vals']->value['studentId'];?>
">
<?php }?>
                                    <span class="name fl">
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['vals']->value['studentUrl'];?>
" class="blueText" target="_blank"><?php echo $_smarty_tpl->tpl_vars['vals']->value['studentName'];?>
</a>
                                    </span>
                                    <span class="code fl"><?php echo $_smarty_tpl->tpl_vars['vals']->value['studentCode'];?>
</span>
                                    <span class="grade fl"><?php echo $_smarty_tpl->tpl_vars['vals']->value['gradeName'];?>
</span>
                                    <a class="add fr" title="添加"></a>
                                </li>
<?php } ?>
                            </ul>
                        </div>
<?php } ?>
<?php }?>-->
                    </div>
                </div>
            </div>
            <!-- 全部学员结束 -->
            <div class="hasSeleted fr">
                <span class="title">已选择：<span class="red number">0</span>名学员</span>
                <div class="list">
                    <ul></ul>
                </div>
            </div>
        </div>
        <!-- 内容结束 -->
        <!-- 未录入信息开始 -->
        <div class="bottomTips">
            学员还未录入？<a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['studentAdd'];?>
" target="_blank"  class="blueText">去录入学员</a>
        </div>
        <!-- 未录入信息结束 -->
    </div>
</div>
<?php }} ?>
