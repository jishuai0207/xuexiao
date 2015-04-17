define(function(require,exports){
	var _p = $('input[name="_p"]').val(),
		_isEnd = $('input[name="_isEnd"]').val(),
		_keywords = $('input[name="_keywords"]').val();

	if(_keywords != ''){_isEnd = '2'};

	var _url = '/index.php/orgclass/index?p=1&isEnd='+_isEnd+'&keywords='+_keywords;
	$('.formSearchClassList').attr('action',_url);
})
