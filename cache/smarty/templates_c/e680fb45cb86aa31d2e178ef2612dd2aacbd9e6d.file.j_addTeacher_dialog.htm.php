<?php /* Smarty version Smarty-3.1.18, created on 2015-03-03 12:08:32
         compiled from "application/views/include/dialog_html/j_addTeacher_dialog.htm" */ ?>
<?php /*%%SmartyHeaderCode:182625025754f533c0186c68-59766285%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e680fb45cb86aa31d2e178ef2612dd2aacbd9e6d' => 
    array (
      0 => 'application/views/include/dialog_html/j_addTeacher_dialog.htm',
      1 => 1423137837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182625025754f533c0186c68-59766285',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subjectTeacher' => 0,
    'key' => 0,
    'val' => 0,
    'vals' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f533c01fd844_77535200',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f533c01fd844_77535200')) {function content_54f533c01fd844_77535200($_smarty_tpl) {?><div class="j_addTeacher_dialog undis">
	<div class="classInfo cf">
		<div class="teacherSelect">
			<div class="teacherArea">
				<!-- 更换班级需要的显示内容开始 -->
				<ul class="changeClassBox">
					<li class="tit undis">
						<span class="teacherRule"></span>
						<span class="bold teacherOldName"></span>
						更换为
						<span class="teacherNewName">未选择</span>	
					</li>
					<li class="red undis">
						更换后，<span class="bold teacherOldName"></span>在本班还未进行的<em class="nums">0</em>节课的任课老师也将自动替换。
					</li>
				</ul>
				<!-- 更换班级需要的显示内容结束 -->
				<div class="hd">
					<div class="teacherSelectSearchBox">
						<input type="text" class="cInput fl" placeholder="老师真实姓名、宣传姓名、ID" />
						<a href="javascript:void(0)" class="submits fl comBlueBtn">搜索</a>
					</div>
					<a href="javascript:void(0);" class="blueText allDatas fl">显示全部</a>
				</div>
				<div class="bd teacherShows">
  <!-- <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['subjectTeacher']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
							<li class="cf">
								<span class="radio fl">
									<em name="teacherId" class="emRadio" value="<?php echo $_smarty_tpl->tpl_vars['vals']->value['teacherId'];?>
"></em>
								</span>
								<span class="name fl">
									<a href="<?php echo $_smarty_tpl->tpl_vars['vals']->value['teacherinfourl'];?>
" class="blueText" target='_blank'><?php echo $_smarty_tpl->tpl_vars['vals']->value['truthName'];?>
</a>
								</span>
								<span class="code fl">编码：<?php echo $_smarty_tpl->tpl_vars['vals']->value['teacherCode'];?>
</span>
								<span class="img ">
									<img src="<?php echo $_smarty_tpl->tpl_vars['vals']->value['path'];?>
" alt="">
								</span>
							</li>
							<?php } ?>
						</ul>
					</div>
<?php } ?> -->
				</div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
