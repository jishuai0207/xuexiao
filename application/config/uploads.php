<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *上传功能相关配置信息,可根据不同需求配置不同数组信息
 */

//全局配置格式
//$config['avatar']['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/avator/';
//$config['avatar']['1']= '/uploads/common/stuavatar120_120.jpg';
//$config['avatar']['2']= '/uploads/common/stuavatar80_80.jpg';
//$config['avatar']['allowed_types'] = 'jpg|jpeg|png';
//$config['avatar']['max_size'] = '5120';
//$config['avatar']['min_width']  = '120';
//$config['avatar']['min_height']  = '120';
//$config['avatar']['file_name']  = md5(date('Y-m-d-h-i-s',time())."-".rand(999,99999)).'.jpg';
//$config['avatar']['thumb_size_1_x'] = "200";
//$config['avatar']['thumb_size_1_y'] = "200";
//$config['avatar']['thumb_size_2_x'] ="80";
//$config['avatar']['thumb_size_2_y'] ="80";
//$config['avatar']['true_path']= $_SERVER['DOCUMENT_ROOT'].'/uploads/avatar/';
//$config['avatar']['relative_path']= '/uploads/avatar/';
//$config['avatar']['overwrite']  = true;

//排课文件上传配置
$config['schedule']['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
$config['schedule']['1']= '/uploads/common/stuavatar120_120.jpg';
$config['schedule']['2']= '/uploads/common/stuavatar80_80.jpg';
$config['schedule']['allowed_types'] = 'xlsx';
$config['schedule']['max_size'] = '5120';
$config['schedule']['file_name']  = md5(date('Y-m-d-h-i-s',time())."-".rand(999,99999)).'.xlsx';
$config['schedule']['true_path']= $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
$config['schedule']['relative_path']= '/uploads/temp/';
$config['schedule']['overwrite']  = true;
//排课文件标题配置
$config['scheduleFileColumn']['0']  = '讲次（必填）';
$config['scheduleFileColumn']['1']  = '上课日期（必填）（例：20040103）';
$config['scheduleFileColumn']['2']  = '上课时间（必填）（例：9:05）';
$config['scheduleFileColumn']['3']  = '下课时间（必填）';
$config['scheduleFileColumn']['4']  = '任课老师真实姓名（班级有两个任课老师时必须填写）';


//老师信息上传文件配置
$config['teacher']['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
$config['teacher']['allowed_types'] = 'xlsx';
$config['teacher']['max_size'] = '5120';
$config['teacher']['file_name']  = md5(date('Y-m-d-h-i-s',time())."-".rand(999,99999)).'.xlsx';
$config['teacher']['true_path']= $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
$config['teacher']['relative_path']= '/uploads/temp/';
$config['teacher']['overwrite']  = true;
//老师上传excel文件标题配置
$config['titlet'][0] = '真实姓名（必填）';
$config['titlet'][1] = '宣传姓名';
$config['titlet'][2] = '手机（必填）';
$config['titlet'][3] = '学科1（必填）';
$config['titlet'][4] = '学科2';
$config['titlet'][5] = '学科3';
$config['titlet'][6] = '性别（男；女）';
$config['titlet'][7] = '邮箱';
$config['titlet'][8] = '身份证号';
$config['titlet'][9] = '出生年月（例如：198801）';
$config['titlet'][10] = '全职/兼职';
$config['titlet'][11] = '在职/离职';


//学员信息上传文件配置
$config['student']['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
$config['student']['allowed_types'] = 'xlsx';
$config['student']['max_size'] = '5120';
$config['student']['file_name']  = md5(date('Y-m-d-h-i-s',time())."-".rand(999,99999)).'.xlsx'; 
$config['student']['true_path']= $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
$config['student']['relative_path']= '/uploads/temp/';
$config['student']['overwrite']  = true;
//学员上传excel文件标题配置
$config['titles'][0] = '姓名（必填）';
$config['titles'][1] = '学校年级（必填）（例：七年级）';
$config['titles'][2] = '家长A手机(必填）';
$config['titles'][3] = '家长A关系（母亲；父亲；其他）';
$config['titles'][4] = '家长B手机';
$config['titles'][5] = '家长B关系（母亲；父亲；其他）';
$config['titles'][6] = '原学号';
$config['titles'][7] = '性别（男；女）';
$config['titles'][8] = '出生年月（例：200205）';
$config['titles'][9] = '所在学校';

//班级学员上传excel文件标题配置
$config['titlecs'][0] = '学员姓名（必填）';
$config['titlecs'][1] = '家长A手机号（必填）';

//考勤excel文件标题配置
$config['sign'][0] = '学员学号';
$config['sign'][1] = '学员姓名';
$config['sign'][2] = '班级编码';
$config['sign'][3] = '班级名称';
$config['sign'][4] = '点名日期';
$config['sign'][5] = '点名时间';
$config['sign'][6] = '考勤';
$config['sign'][7] = '成绩';
$config['sign'][8] = '任课老师';
$config['sign'][9] = '代课老师';
$config['sign'][10] = '家长关系';
$config['sign'][11] = '家长联系方式';
$config['sign_path']= $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';

//nginx环境excel文件下载路径配置
//$ngxSendFileMap = array(
     //array($_SERVER['DOCUMENT_ROOT'].'/uploads/temp/', '//'),
     //array('/data/wwwroot/eap/Scan/',  '/Scan/'),
     //array('/data/wwwroot/eap/Jianli/', '/Jianli/'),
 //);

