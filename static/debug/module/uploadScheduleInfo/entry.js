define(function(require,exports){
	$('.entryBox').delegate('.subs','click',function(){
		var _classid= $('.uploadScheduleInfo').attr('classid');
		var _filemd5= $('.uploadScheduleInfo').attr('filemd5');
		$.ajax({
			url:'/index.php/schedule/uploadstep2',
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
