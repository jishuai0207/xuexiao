define(function(require,exports){
	// 请求删除老师弹出层
	$('.delTeacher').on('click',function(){
		var _classid = $(this).attr('classid');
		var _teacherId = $(this).attr('teacherId');
		var _pageType = $(this).attr('pageType');
		$.dialog({
			title:'删除任课老师',
			content:'确认要删除任课老师吗？',
			icon:'warning',
			ok:function(){
				$.ajax({
					url:'/index.php/post/orgclass/delteacher',
					dataType:'json',
					type:'post',
					data:{
						teacherId:_teacherId,
						classId:_classid,
						pageType:_pageType
					},
					success:function(json){
						if(json.status == 0){
							$.dialog({
								title:'删除任课老师',
								content:json.msg,
								icon:'warning',
								cancel:null
							});
						}else if(json.status == -1){
							window.location.href = json.data.url;
		                }else if(json.status == 1){
							$.dialog({
								title:'删除任课老师',
								content:json.msg,
								icon:'succeed',
								ok:function(){
							        window.location.href = json.data.url;
									return false;
								},
								cancel:null
							});
						}
					}
				})
			}
		})
		
		
	})
})
