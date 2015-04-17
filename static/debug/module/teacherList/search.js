define(function(require,exports){
	var _p = $('input[name="_p"]').val(),
		_inJob = $('input[name="_inJob"]').val(),
		_keywords = $('input[name="_keywords"]').val();

	if(_keywords == ''){_inJob = '1'};

	var _url = '/index.php/teacher/index?p=1&injob='+_inJob+'&keywords='+_keywords;
	$('.formSearchTeacher').attr('action',_url);
})
