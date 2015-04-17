define(function(require,exports){
	$('.downloadTemplate').click(function(){
		$.ajax({
			url:'/index.php/view/schedule/download',
			dataType:'json',
			type:'post',
			data:{
				classId:$('.studentLists').attr('classid')
			},
			success:function(json){
				if(json.status == 0){
					$.dialog({
						content:json.msg,
						icon:'warning',
						cancel:null
					});
				}else if(json.status == -1){
					window.location.href = json.data.url;
                }else if(json.status == 1){
					window.location.href=json.data.downLoadurl;
				}
			}
		})
	})
})
