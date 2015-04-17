define(function(require,exports){
	$('.uploadTemplate').click(function(){
		var classid = $(this).attr('classid');
		$.ajax({
			url:'/index.php/view/schedule/checkIsAllowUpload?classId=' + classid,
			dataType:'json',
			type:'post',
			success:function(json){
				 if(json.status == 0){
                    $.dialog({
                        content:json.msg,
                        icon:'warning',
                        cancel:null
                    });
                }else if(json.status == 1){
                    window.location.href = json.data.url;
                }else if(json.status == -1){
                    window.location.href = json.data.url;
                }
			}
		})
	})
})
