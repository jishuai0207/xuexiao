define(function(require,exports){
	// 获取上传后的数据
	if($("#moduleId").attr('check')){
		seajs.use('module/uploadOrgClassInfo/getJson');
	};
	// 上传成功后返回数据
	if($("#moduleId").attr('scheduleFile')){
		seajs.use('module/uploadOrgClassInfo/scheduleFile');
	};
	
	// 录入信息
	require('module/uploadOrgClassInfo/entry');
})
