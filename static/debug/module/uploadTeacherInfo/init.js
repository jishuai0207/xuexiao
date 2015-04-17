define(function(require,exports){
	// 获取上传后的数据
	if($("#moduleId").attr('check')){
		seajs.use('module/uploadTeacherInfo/getJson');
	};
	// 上传成功后返回数据
	if($("#moduleId").attr('teacherFile')){
		seajs.use('module/uploadTeacherInfo/teacherFile');
	};
	
	// 录入信息
	require('module/uploadTeacherInfo/entry');
})
