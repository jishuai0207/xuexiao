<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *description:全局参数通用配置
 *author:yanyalong
 *date:2014/11/04
 */
//学员基本信息
$config['common_public']['studentInfo']['initPass'] = '123456';
$config['common_public']['studentInfo']['codePrefix'] = 'S';
$config['common_public']['studentInfo']['codeBase'] = '0000000';
//老师初始密码信息
$config['common_public']['teacherInfo']['initPass'] = '123456';
$config['common_public']['teacherInfo']['codePrefix'] = 'T';
$config['common_public']['teacherInfo']['codeBase'] = '0000000';
//班级初始密码信息
$config['common_public']['classInfo']['codePrefix'] = 'C';
$config['common_public']['classInfo']['codeBase'] = '0000000';
//班型学期配置
$config['common_public']['classTypePeriod']['1'] = '春季班';
$config['common_public']['classTypePeriod']['2'] = '暑假班';
$config['common_public']['classTypePeriod']['3'] = '秋季班';
$config['common_public']['classTypePeriod']['4'] = '寒假班';

//默认头像地址
$config['common_public']['default_avatar']['200'] = 'http://image.aixuexi.com/default.jpg';
$config['common_public']['default_avatar']['120'] = 'http://image.aixuexi.com/default.jpg';

//左侧菜单样式加载配置
$config['common_public']['leftMenu']['index'] = 'index';
$config['common_public']['leftMenu']['teacher'] = 'teacher';
$config['common_public']['leftMenu']['class'] = 'class';
$config['common_public']['leftMenu']['student'] = 'student';
$config['common_public']['leftMenu']['classType'] = 'classType';
$config['common_public']['leftMenu']['sysManage'] = 'sysManage';

//java组短信验证码接口(临时变量)
$config['common_public']['sendSms']['java']['token'] = 'efb0f3ac1dd33d7267fba10e618ab1de';
$config['common_public']['sendSms']['java']['sn'] = 'DXX-ANG-010-00015';
$config['common_public']['sendSms']['java']['pwd'] = '7@bffb@4';
$config['common_public']['sendSms']['java']['sign'] = '【高思教育】';
//机构管理系统找回密码短信验证码
$config['common_public']['sendSms']['orgCenter']['token'] = '50411758798f11294a9c27de6c37b4e9';
$config['common_public']['sendSms']['orgCenter']['sn'] = 'DXX-ANG-010-00015';
$config['common_public']['sendSms']['orgCenter']['pwd'] = '7@bffb@4';
$config['common_public']['sendSms']['orgCenter']['sign'] = '【高思教育】';

//客服信息
$config['common_public']['service']['airlines'] = '400-898-1009';

//高思官方url禁止操作配置
$config['common_public']['gaoSiInstitution'] = array(
    'orgclass/create',
    'orgclass/createsuccess',
    'schedule/upload',
    'schedule/doupload',
    'schedule/check',
    'schedule/success',
    'teacher/add',
    'teacher/modify',
    'teacher/upload',
    'teacher/uploadRes',
    'student/add',
    'student/upload',
    'student/doinsert',
    'student/enterSucc',
    'student/modify',
    'student/leave',
    'teacher/success',
    'student/uploadstep1',
    'teacher/uploadstep1',
    'teacher/enterSucc',
    'teacher/doinsert',
    'teacher/checkStep2',
	'teacher/download',
	'orgclass/upload'
);
//高思官方ajax禁止操作配置
$config['common_public']['gaoSiInstitutionAjax'] = array(
    'post/student/add',
    'post/student/modify',
    'post/teacher/add',
    'teacher/leavejob',
    'teacher/onjob',
    'post/orgclass/create',
    'post/orgclass/del',
    'post/orgclass/modify',
    'post/orgclass/changeteacher',
    'post/orgclass/delteacher',
    'post/orgclass/addteacher',
    'post/orgclass/studentleave',
    'post/orgclass/studentchange',
    'post/orgclass/studentadd',
    'post/schedule/uploadstep1',
    'post/schedule/uploadstep2',
    'post/schedule/modify',
    'post/schedule/add',
    'post/schedule/replaceteacheradd',
    'post/schedule/replaceteachermod',
    'post/schedule/replaceteacherdel',
    'post/student/leaveClass', 
    'post/teacher/add',
    'post/teacher/modify',
    'view/orgclass/modify',
    'view/orgclass/teacheradd',
    'view/orgclass/teachermodify',
    'view/orgclass/addstulist',
    'view/schedule/replaceteacheradd',
    'view/schedule/replaceteachermod',
    'view/schedule/download',
    'view/schedule/downloadfile',
    'student/resetpwd',
    'view/orgclass/studentchange'
);

