<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *description:全局交互数据路径地址
 *author:yanyalong
 */
//首页今日课程
$config['common_view']['todaySchedule'] = INLET.'view/index/todayschedule';
//班级列表数据
$config['common_view']['classList'] = INLET.'view/orgclass/index';
//修改班级基本信息
$config['common_view']['classInfoMod'] = INLET.'view/orgclass/modify';
//创建班级的班型选择
$config['common_view']['gradeSubjectCT'] = INLET.'view/orgclass/gradesubject';
//添加任课老师选项列表
$config['common_view']['classTeacherAdd'] = INLET.'view/orgclass/teacheradd';
//编辑任课老师选项列表
$config['common_view']['classTeacherMod'] = INLET.'view/orgclass/teachermodify';
//班级当前学员
$config['common_view']['classCurrentStudent'] = INLET.'view/orgclass/currentstudent';
//下载班级学员帐号密码
$config['common_view']['classStuDownload'] = INLET.'view/orgclass/studownload';
//添加学员选择列表
$config['common_view']['classAddStuList'] = INLET.'view/orgclass/addstulist';
//班级课表
$config['common_view']['classSchedule'] = INLET.'view/orgclass/schedule';
//添加排课
$config['common_view']['scheduleAdd'] = INLET.'view/schedule/add';
//修改排课
$config['common_view']['scheduleMod'] = INLET.'view/schedule/modify';
//添加课节排课代课老师
$config['common_view']['scheduleRplaceTeacherAdd'] = INLET.'view/schedule/replaceteacheradd';
//修改课节排课代课老师
$config['common_view']['scheduleRplaceTeacherMod'] = INLET.'view/schedule/replaceteachermod';
//下载排课信息
$config['common_view']['scheduleDownload'] = INLET.'view/schedule/download';
//读取并下载排课信息
$config['common_view']['Scheduledownloadfile'] = INLET.'view/schedule/downloadfile';
//获取年级列表
$config['common_view']['gradeList'] = INLET.'view/orgclass/getgrade';
//转班弹窗数据
$config['common_view']['strudentChangeClass'] = INLET.'view/orgclass/studentchange';

//教师列表
$config['common_view']['teacherList'] = INLET.'view/teacher/list';
//学员列表
$config['common_view']['studentList'] = INLET.'view/student/list';
//教师班级列表
$config['common_view']['teacherClass'] = INLET.'view/teacher/classinfo';

