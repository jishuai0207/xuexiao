define(function(require,exports){
	var _p = $('input[name="_p"]').val(),
		_teacher = $('input[name="_teacher"]').val(),
		_isEnd =$('input[name="_isEnd"]').val(),
		_classTypeCode = $('input[name="_classTypeCode"]').val(),
		_classTypePeriod = $('input[name="_classTypePeriod"]').val(),
		_gradeId = $('input[name="_gradeId"]').val();

		$('.classLists .hd span a').each(function(){
			if($(this).attr('data-id') == _isEnd){
				$(this).addClass('active');
			}
		});
		$('.classLists .hd span a').on('click',function(){
			var _id = $(this).attr('data-id');
			var _url = '/index.php/orgclass/index?teacherId='+_teacher+'&classTypeCode='+_classTypeCode+'&classTypePeriod='+_classTypePeriod+'&gradeId='+_gradeId+'&isEnd='+_id;
			window.location.href=_url;
		})

})
