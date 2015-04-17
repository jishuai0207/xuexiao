define(function(require,exports){
	// 请求当前学员 渲染页面
	require('module/classInfo/currentStudent');
	// 批量排课下拉菜单
	require('module/classInfo/slideDown');
	// 请求当前课表 渲染页面
	require('module/classInfo/currentSchedule');
	// 课表页面弹出层
	require('module/classInfo/scheduleDialog').init();
	// 请求退班和转班弹出层
	require('module/classInfo/classCtrl').init();
	// 请求添加学员弹出层
	require('module/classInfo/addStudent');
	// 请求修改基本信息弹出层
	require('module/classInfo/modifyBaseInfo');
	// 请求删除班级弹出层
	require('module/classInfo/delClassInfo');
	// 请求添加老师弹出层
	require('module/classInfo/addTeacher');
	// 请求更换老师弹出层
	require('module/classInfo/changeTeacher');
	// 删除老师
	require('module/classInfo/delTeacher');
	// 下载模版方法
	require('module/classInfo/downloadTemplate');
	// 锚点方法
	// require('module/classInfo/point');
	// 上传信息表
	require('module/classInfo/uploadTemplate');
	//日期处理
	require('module/common/date').init();
	
	

})


