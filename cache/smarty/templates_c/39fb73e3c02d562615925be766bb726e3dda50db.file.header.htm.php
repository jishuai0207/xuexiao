<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 13:01:58
         compiled from "application/views/include/header.htm" */ ?>
<?php /*%%SmartyHeaderCode:58882784754f7e346984dd7-74372036%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39fb73e3c02d562615925be766bb726e3dda50db' => 
    array (
      0 => 'application/views/include/header.htm',
      1 => 1423645203,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58882784754f7e346984dd7-74372036',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url_config' => 0,
    'isLogin' => 0,
    'AdmintruthName' => 0,
    'post_config' => 0,
    'session_info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7e3469eb332_36696053',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7e3469eb332_36696053')) {function content_54f7e3469eb332_36696053($_smarty_tpl) {?><script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?4e3ef1f2db9d0ec691a65a63b4faac5e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<div class="header layout">
    <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['index'];?>
" class="logo fl">机构管理中心</a>
    <div class="info fr">
        <?php if ($_smarty_tpl->tpl_vars['isLogin']->value==1) {?>
        <div class="headerSlidown fr posr">
            <span class="title"><?php echo $_smarty_tpl->tpl_vars['AdmintruthName']->value;?>
</span>
            <ul class="undis">
				<!--
                <li>
                    <a href="/<?php echo $_smarty_tpl->tpl_vars['url_config']->value['modifyPass'];?>
" target="_blank">修改密码</a>
                </li>
				-->
                <li>
                    <a href="/<?php echo $_smarty_tpl->tpl_vars['post_config']->value['logout'];?>
">退出</a>
                </li>
            </ul>
        </div>
        <?php }?>
        <p class="fr">
            客服电话：400-898-1009
        </p>
		<span class="orgNames fr"><?php if (isset($_smarty_tpl->tpl_vars['session_info']->value['insName'])) {?><?php echo $_smarty_tpl->tpl_vars['session_info']->value['insName'];?>
<?php }?></span>
        </div>
    </div>
<?php }} ?>
