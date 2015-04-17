<?php /* Smarty version Smarty-3.1.18, created on 2015-03-05 11:53:17
         compiled from "/home/jishuai/wwwroot/OrgCenter/application/views/sign/index.html" */ ?>
<?php /*%%SmartyHeaderCode:157413450054f7d32d66b854-29826057%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '413744e6aae83652c220d345678ebd1f507a0d7e' => 
    array (
      0 => '/home/jishuai/wwwroot/OrgCenter/application/views/sign/index.html',
      1 => 1425527546,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157413450054f7d32d66b854-29826057',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'static_url' => 0,
    'static_version' => 0,
    'site_url' => 0,
    'optionSYear' => 0,
    'v' => 0,
    'syear' => 0,
    'optionSMonth' => 0,
    'smonth' => 0,
    'optionSDay' => 0,
    'sday' => 0,
    'eyear' => 0,
    'emonth' => 0,
    'eday' => 0,
    'issign' => 0,
    'classType' => 0,
    'classValue' => 0,
    'studentType' => 0,
    'studentValue' => 0,
    'downloadUrl' => 0,
    'info' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54f7d32db62736_03356207',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f7d32db62736_03356207')) {function content_54f7d32db62736_03356207($_smarty_tpl) {?><!DOCTYPE html>
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
/css/sign/style.css" />
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
        <div class="sign" id="moduleId" pagename="sign">
			<form id="signForm"/>
            <div class="topTitle">
                 <div class="search selectChoose">
                    <div>
                        <ul>
                            <li><span>
                            <select name="syear" class="chooseYear">
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optionSYear']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<option <?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['syear']->value) {?> selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
								<?php } ?>
							</select>
                            <select name="smonth" class="chooseMonth">
								<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optionSMonth']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>

								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['smonth']->value) {?><?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
 selected="selected" <?php ob_start();?><?php }?><?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
 value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
</option>
								<?php ob_start();?><?php } ?><?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>

							</select>
                            <select name="sday" class="chooseDay">
								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value=='--') {?><?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
 value="--">--</option>
								<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optionSDay']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>

								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['sday']->value) {?><?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
 value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
</option>
								<?php ob_start();?><?php } ?><?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>

							</select>
                        </span></li>
                            <li class="tips">至</li>
                            <li><span>
                            <select name="eyear" class="chooseYear">
								<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optionSYear']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>

								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['eyear']->value) {?><?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>
 value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
</option>
								<?php ob_start();?><?php } ?><?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>

							</select>
                            <select name="emonth" class="chooseMonth">
								<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optionSMonth']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>

								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['emonth']->value) {?><?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>
 value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>
</option>
								<?php ob_start();?><?php } ?><?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>

							</select>
                            <select name="eday"class="chooseDay">
								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value=='--') {?><?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>
 value="--">--</option>
								<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optionSDay']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>

								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['eday']->value) {?><?php $_tmp30=ob_get_clean();?><?php echo $_tmp30;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp31=ob_get_clean();?><?php echo $_tmp31;?>
 value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp32=ob_get_clean();?><?php echo $_tmp32;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
<?php $_tmp33=ob_get_clean();?><?php echo $_tmp33;?>
</option>
								<?php ob_start();?><?php } ?><?php $_tmp34=ob_get_clean();?><?php echo $_tmp34;?>

							</select>
                        </span></li>

                        </ul>
                        
                       
                      
                        <span class="signType">
                            <label>考勤</label>
                            <select name="issign">
								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['issign']->value==2) {?><?php $_tmp35=ob_get_clean();?><?php echo $_tmp35;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp36=ob_get_clean();?><?php echo $_tmp36;?>
 value="2">全部</option>
								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['issign']->value==0) {?><?php $_tmp37=ob_get_clean();?><?php echo $_tmp37;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp38=ob_get_clean();?><?php echo $_tmp38;?>
 value="0">缺勤</option>
								<option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['issign']->value==1) {?><?php $_tmp39=ob_get_clean();?><?php echo $_tmp39;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp40=ob_get_clean();?><?php echo $_tmp40;?>
 value="1">出勤</option>
							</select>
                        </span>
                    </div>
                    <div class="queryCondition">
                        <span>
						 <select name="classType">
							 <option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['classType']->value=='classCode') {?><?php $_tmp41=ob_get_clean();?><?php echo $_tmp41;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp42=ob_get_clean();?><?php echo $_tmp42;?>
 value="classCode">班级编码</option>
							 <option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['classType']->value=='className') {?><?php $_tmp43=ob_get_clean();?><?php echo $_tmp43;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp44=ob_get_clean();?><?php echo $_tmp44;?>
 value="className">班级名称</option>
						 </select>
                             <input type="text" name="classValue" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['classValue']->value;?>
<?php $_tmp45=ob_get_clean();?><?php echo $_tmp45;?>
"/>
                        </span>
                        <span>
                             <select name="studentType">
								 <option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['studentType']->value=='studentName') {?><?php $_tmp46=ob_get_clean();?><?php echo $_tmp46;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp47=ob_get_clean();?><?php echo $_tmp47;?>
 value="studentName">学员姓名</option>
								 <option <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['studentType']->value=='studentId') {?><?php $_tmp48=ob_get_clean();?><?php echo $_tmp48;?>
 selected="selected"<?php ob_start();?><?php }?><?php $_tmp49=ob_get_clean();?><?php echo $_tmp49;?>
 value="studentId">学员学号</option>
							 </select>
								 <input type="text" name="studentValue" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['studentValue']->value;?>
<?php $_tmp50=ob_get_clean();?><?php echo $_tmp50;?>
"/>
                        </span> 
                        <span>
                           <input type="submit" value="查询" class="submits yh comBlueBtn"> 
						   <a type="submit" href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['downloadUrl']->value;?>
<?php $_tmp51=ob_get_clean();?><?php echo $_tmp51;?>
" class="submits yh comBlueBtn import">导出到excel</a>
                        </span>
                       
                    </div>
                </div>
            </div>
			</form>

            <div class="conrtent">
                <div class="line"></div>
                <div class="comTable">
                    <table cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <th>学员学号</th>
                            <th>姓名</th>
                            <th class="w100">班级编码</th>
                            <th  class="w170">班级名称</th>
                            <th>点名日期</th>
                            <th>点名时间</th>
                            <th>考勤</th>
                            <th>成绩</th>
                            <th>任课</th>
                            <th>代课</th>
                            <th>家长</th>  
                            <th class="w100">联系方式</th>  
                        </tr>
						<tbody id="signtable">
		<?php ob_start();?><?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?><?php $_tmp52=ob_get_clean();?><?php echo $_tmp52;?>

		<tr siid="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->siid;?>
<?php $_tmp53=ob_get_clean();?><?php echo $_tmp53;?>
" lid="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->lesson_id;?>
<?php $_tmp54=ob_get_clean();?><?php echo $_tmp54;?>
" cid="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->cid;?>
<?php $_tmp55=ob_get_clean();?><?php echo $_tmp55;?>
">
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->school;?>
<?php $_tmp56=ob_get_clean();?><?php echo $_tmp56;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->truthName;?>
<?php $_tmp57=ob_get_clean();?><?php echo $_tmp57;?>
</td>
			<td class="w100"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->classCode;?>
<?php $_tmp58=ob_get_clean();?><?php echo $_tmp58;?>
</td>
			<td class="w170"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->className;?>
<?php $_tmp59=ob_get_clean();?><?php echo $_tmp59;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->subDate;?>
<?php $_tmp60=ob_get_clean();?><?php echo $_tmp60;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->subTime;?>
<?php $_tmp61=ob_get_clean();?><?php echo $_tmp61;?>
</td>
			<td><?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['value']->value->issign=='0') {?><?php $_tmp62=ob_get_clean();?><?php echo $_tmp62;?>
<font class="red"><?php ob_start();?><?php }?><?php $_tmp63=ob_get_clean();?><?php echo $_tmp63;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->signInfo;?>
<?php $_tmp64=ob_get_clean();?><?php echo $_tmp64;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->scoreInfo;?>
<?php $_tmp65=ob_get_clean();?><?php echo $_tmp65;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->teacher[0];?>
<?php $_tmp66=ob_get_clean();?><?php echo $_tmp66;?>
<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['value']->value->teacher[1]!='') {?><?php $_tmp67=ob_get_clean();?><?php echo $_tmp67;?>
</br><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->teacher[1];?>
<?php $_tmp68=ob_get_clean();?><?php echo $_tmp68;?>
<?php ob_start();?><?php }?><?php $_tmp69=ob_get_clean();?><?php echo $_tmp69;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->replaceInfo;?>
<?php $_tmp70=ob_get_clean();?><?php echo $_tmp70;?>
</td>
			<td><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->refInfo;?>
<?php $_tmp71=ob_get_clean();?><?php echo $_tmp71;?>
</td>
			<td class="w100"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['value']->value->parentTel1;?>
<?php $_tmp72=ob_get_clean();?><?php echo $_tmp72;?>
</td>
		</tr>
		<?php ob_start();?><?php } ?><?php $_tmp73=ob_get_clean();?><?php echo $_tmp73;?>

                                              
                        </tbody>
                    </table>
                </div>
                <p class="info">（本查询信息不包含漏点名班级）</p>
                <!-- 分页开始 -->
                <div class="page cf">
                    <div class="pageContent">
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
</body>
</html>
<?php }} ?>
