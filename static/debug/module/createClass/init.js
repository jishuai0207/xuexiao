define(function(require,exports){
	//创建班级前端验证
	require('module/createClass/creatForm');
	// 请求添加老师
	require('module/createClass/addTeacher');
	// 请求学科、年级、班型联动
	require('module/createClass/three');
	//日期处理
	require('module/common/date').init();
})
