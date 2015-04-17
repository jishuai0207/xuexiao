define(function(require,exports){
	// 加载教师列表的ajax数据
	// require('module/teacherList/ajax_list').truePage();
	// 搜索老师表单验证
	require('module/teacherList/search');
	// 批量录入老师下拉菜单
	require('module/teacherList/slidown');
	// 离职登记
	require('module/common/leaveOn');
})