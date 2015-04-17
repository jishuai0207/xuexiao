define(function(require,exports){
	$('.entryBox').delegate('.subs','click',function(){
		var _classid= $('.uploadTeacherInfo').attr('classid');
		var _filemd5= $('.uploadTeacherInfo').attr('filemd5');
		$.ajax({
			url:'/index.php/teacher/doinsert',
			type:'post',
			dataType:'json',
			data:{
				classId:_classid,
				fileMd5:_filemd5
			},
			success:function(json){
				if(json.status == 0){
					require('dialog');
					$.dialog({
						content:json.msg,
						icon:'warning',
						cancel:null
					});
				}else if(json.status == -1){
                    window.location.href = json.data.url;
                }else if(json.status == 1){
					window.location.href=json.data.url;
				}
			}
		})
	})
})
