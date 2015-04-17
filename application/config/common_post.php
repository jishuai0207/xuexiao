<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *description:全局提交路径地址
 *author:yanyalong
 */
//登录
$config['common_post']['login'] = INLET.'post/login/index';
//退出登录
$config['common_post']['logout'] = INLET.'post/login/logout'; 
//找回、修改密码
$config['common_post']['forgetPass'] = INLET.'post/login/forgetpass';
//找回、修改密码发送短信
$config['common_post']['sendCode'] = INLET.'post/login/sendCode';
//老师修改密码
$config['common_post']['modifyPass'] = INLET.'post/teacher/modifyPass';
//创建班级
$config['common_post']['classCreate'] = INLET.'post/orgclass/create'; 
//删除班级
$config['common_post']['classDel'] = INLET.'post/orgclass/del'; 
//修改班级基本信息
$config['common_post']['classMod'] = INLET.'post/orgclass/modify'; 
//更换班级任课老师
$config['common_post']['changeTeacher'] = INLET.'post/orgclass/changeteacher'; 
//删除班级任课老师
$config['common_post']['delTeacher'] = INLET.'post/orgclass/delteacher'; 
//添加班级任课老师
$config['common_post']['addTeacher'] = INLET.'post/orgclass/addteacher'; 
//班级学员退班
$config['common_post']['studentLeaveClass'] = INLET.'post/orgclass/studentleave'; 
//班级学员转班
$config['common_post']['studentChangeClass'] = INLET.'post/orgclass/studentchange'; 
//班级学员添加
$config['common_post']['studentAddClass'] = INLET.'post/orgclass/studentadd'; 
//上传排课信息表第1步提交
$config['common_post']['scheduleUploadStep1'] = INLET.'post/schedule/uploadstep1'; 
//上传排课信息表第2步提交
$config['common_post']['scheduleUploadStep2'] = INLET.'post/schedule/uploadstep2'; 
//修改排课
$config['common_post']['scheduleMod'] = INLET.'post/schedule/modify'; 
//添加排课
$config['common_post']['scheduleAdd'] = INLET.'post/schedule/add'; 
//添加代课老师
$config['common_post']['scheduleReplaceTeacherAdd'] = INLET.'post/schedule/replaceteacheradd'; 
//更换代课老师
$config['common_post']['scheduleReplaceTeacherMod'] = INLET.'post/schedule/replaceteachermod'; 
//删除代课老师
$config['common_post']['scheduleReplaceTeacherDel'] = INLET.'post/schedule/replaceteacherdel'; 
//添加老师
$config['common_post']['teacherAdd'] = INLET.'post/teacher/add'; 
//修改老师信息
$config['common_post']['teacherMod'] = INLET.'post/teacher/modify'; 
//修改旧系统的密码的接口网址
$config['common_post']['modifyOldURL'] = 'http://123.57.133.25/manage-service';
//$config['common_post']['modifyOldURL'] = 'http://172.16.11.84:8080/manage.service';
//修改旧系统密码学员地址
$config['common_post']['modifyOldStu'] = '/synPwdService/synStudentPwd';
//修改旧系统密码教师地址
$config['common_post']['modifyOldTea'] = '/synPwdService/synTeacherPwd';

