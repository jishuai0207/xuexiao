<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 13:01:58
         compiled from "application/views/include/left_menu.htm" */ ?>
<?php /*%%SmartyHeaderCode:1065252654f7e3469f0c13-70177202%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e9883127b9c264e5b623d2a3d560d11ef26f90b' => 
    array (
      0 => 'application/views/include/left_menu.htm',
      1 => 1425525858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1065252654f7e3469f0c13-70177202',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu_hover' => 0,
    'url_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7e346aecab6_08592931',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7e346aecab6_08592931')) {function content_54f7e346aecab6_08592931($_smarty_tpl) {?><div class="leftMenu fl" id="leftMenu">
    <ul>
        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='index') {?>
        <li class="homepage active">
            <?php } else { ?>
        <li class="homepage">
        <?php }?> 
            <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['index'];?>
">
                <span class="ico"></span>
                首页
            </a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='teacher') {?>
        <li class="teacher active">
            <?php } else { ?>
        <li class="teacher">
        <?php }?> 
        <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['teacherList'];?>
">
                <span class="ico"></span>
                老师
            </a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='class') {?>
        <li class="class active">
            <?php } else { ?>
        <li class="class">
        <?php }?> 
            <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classList'];?>
">
                <span class="ico"></span>
                班级
            </a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='student') {?>
        <li class="student active">
            <?php } else { ?>
        <li class="student">
        <?php }?> 
            <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['studentList'];?>
">
                <span class="ico"></span>
                学员
            </a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='classType') {?>
        <li class="classType active">
            <?php } else { ?>
        <li class="classType">
        <?php }?> 
            <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['classTypeList'];?>
">
                <span class="ico"></span>
                班型
            </a>
        </li>

        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='sign') {?>
        <li class="sign active">
            <?php } else { ?>
        <li class="sign">
        <?php }?> 
		<a href="/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['url_config']->value['sign'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
">
                <span class="ico"></span>
               出勤和成绩
            </a>
        </li>

        <?php if ($_smarty_tpl->tpl_vars['menu_hover']->value=='sysManage') {?>
        <li class="system active">
            <?php } else { ?>
        <li class="system">
        <?php }?> 
        <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['sysManage'];?>
">
                <span class="ico"></span>
                系统管理
            </a>
        </li>

    </ul>
</div>
<?php }} ?>
