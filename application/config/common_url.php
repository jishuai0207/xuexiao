<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *description:全局url路径地址
 *author:yanyalong
 */
//登录
$config['common_url']['login'] = INLET.'index/index';
//找回密码
$config['common_url']['forgetPass'] = INLET.'login/forgetpass';
//老师修改密码
$config['common_url']['modifyPass'] = INLET.'teacher/modifyPass';
//首页---over
$config['common_url']['index'] = INLET.'index/home';
//创建班级---over
$config['common_url']['classCreate'] = INLET.'orgclass/create'; 
//创建班级成功---over
$config['common_url']['classCreateSuccess'] = INLET.'orgclass/createsuccess'; 
//班级列表页---over
$config['common_url']['classList'] = INLET.'orgclass/index'; 
//班级详情页---over
$config['common_url']['classInfo'] = INLET.'orgclass/info'; 
//上传课表页---over
$config['common_url']['scheduleUpload'] = INLET.'schedule/upload'; 
//上传课表操作地址---over
$config['common_url']['scheduleDoUpload'] = INLET.'schedule/doupload'; 
//上传课表第二页---over
$config['common_url']['classScheduleStep2'] = INLET.'schedule/check'; 
//上传课表成功页---over
$config['common_url']['classScheduleSuccess'] = INLET.'schedule/success'; 
//教师列表---over
$config['common_url']['teacherList'] = INLET.'teacher/index'; 
//录入老师
$config['common_url']['teacherAdd'] = INLET.'teacher/add'; 
//录入老师提交地址
$config['common_url']['teacherAddPost'] = INLET.'post/teacher/add'; 
//修改老师基本信息
$config['common_url']['teacherModify'] = INLET.'teacher/modify'; 
//老师详情---over
$config['common_url']['teacherInfo'] = INLET.'teacher/info'; 
//上传教师列表
$config['common_url']['teacherUpload'] = INLET.'teacher/upload'; 
//老师离职
$config['common_url']['teacherLeaveJob'] = INLET.'teacher/leavejob'; 
//老师入职
$config['common_url']['teacherOnJob'] = INLET.'teacher/onjob'; 
//上传教师列表结果
$config['common_url']['teacherUploadRes'] = INLET.'teacher/uploadRes'; 
//学员列表
$config['common_url']['studentList'] = INLET.'student/index'; 
//修改学员提交地址
$config['common_url']['studentModifyPost'] = INLET.'post/student/modify'; 
//录入学员
$config['common_url']['studentAdd'] = INLET.'student/add'; 
//录入学员提交地址
$config['common_url']['studentAddPost'] = INLET.'post/student/add'; 
//学员详情
$config['common_url']['studentInfo'] = INLET.'student/info'; 
//学员上传
$config['common_url']['studentUpload'] = INLET.'student/upload'; 
//学员上传录入
$config['common_url']['studentUploadEnter'] = INLET.'student/doinsert'; 
//学员上传录入成功页
$config['common_url']['studentEnterSucc'] = INLET.'student/enterSucc'; 
//学员修改
$config['common_url']['studentModify'] = INLET.'student/modify'; 
//重置学员密码
$config['common_url']['studentReset'] = INLET.'student/resetpwd'; 
//学员退学
$config['common_url']['studentLeave'] = INLET.'student/leave'; 
//班型列表
$config['common_url']['classTypeList'] = INLET.'classtype/index'; 
//管理员列表
$config['common_url']['sysManage'] = INLET.'sysManage/adminlist';
//录入老师成功页
$config['common_url']['teacherAddSuccess'] = INLET.'teacher/success';
//上传学员成功页
$config['common_url']['studentStep2'] = INLET.'student/uploadstep1';
//上传老师成功页
$config['common_url']['teacherStep2'] = INLET.'teacher/uploadstep1';
//上传老师成功页
$config['common_url']['teacherEnterSucc'] = INLET.'teacher/enterSucc';
//教师上传录入
$config['common_url']['teacherUploadEnter'] = INLET.'teacher/doinsert'; 
//教师上传录入
$config['common_url']['teacherErrorAjax'] = INLET.'teacher/checkStep2';
//教师下载
$config['common_url']['teacherdownload'] = INLET.'teacher/download'; 
//全局无权限跳转页
$config['common_url']['noAuth'] = INLET.'common/noauth';
//下载班级学员模板
$config['common_url']['classStuDownload'] = INLET.'orgclass/download';
//上传班级学员页面
$config['common_url']['classStuUpload'] = INLET.'orgclass/upload';
//处理上传班级学员(第一步)
$config['common_url']['classStuDoUpload'] = INLET.'orgclass/doupload';
//上传班级学员录入
$config['common_url']['classStuUploadEnter'] = INLET.'orgclass/doinsert';
//显示错误信息页面
$config['common_url']['classStuShowErr'] = INLET.'orgclass/uploadstep1';
//上传老师成功页
$config['common_url']['classStuEnterSucc'] = INLET.'orgclass/enterSucc';
//考勤页面
$config['common_url']['sign'] = INLET.'sign/index';
