define(function(require,exports){
	// 入职登记
	$('.leaveOn').click(function(){
		var that = $(this);
		$.dialog({
			content:'<p>确定将该老师登记为入职？</p><p class="grey">登记入职后，该老师将恢复您机构的教师身份登录爱学习平台</p>',
			icon:'warning',
			ok:function(){
				$.ajax({
					url:that.attr('url')+'?teacherId='+that.attr('teacherId'),
					type:'get',
					dataType:'json',
					success:function(json){
						require('dialog');
						if(json.status == 0){
							$.dialog({
								title:json.data.title,
								content:json.msg,
								icon:'warning',
								cancel:null
							});
						}else if(json.status == -1){
							window.location.href = json.data.url;
		                }else if(json.status == 1){
							$.dialog({
								title:json.data.title,
								content:json.msg,
								icon:'succeed',
								ok:function(){
									window.location.reload();
									return false;
								},
								init:function(){
									$(".aui_close").remove();
								},
								cancel:null
							});
						}
					}
				})
			}
		});
	})
	// 离职登记
	$('.leaveOff').click(function(){
		var that = $(this);
		$.dialog({
			content:'<p>确定将该老师登记为离职？</p><p class="grey">登记离职后，该老师将不再以您机构的教师身份登录爱学习平台</p>',
			icon:'warning',
			ok:function(){
				$.ajax({
					url:that.attr('url')+'?teacherId='+that.attr('teacherId'),
					type:'get',
					dataType:'json',
					success:function(json){
						require('dialog');
						if(json.status == 0){
							$.dialog({
								title:json.data.title,
								content:json.msg,
								cancel:null,
								icon:'warning'
							});
						}else if(json.status == -1){
							window.location.href = json.data.url;
		                }else if(json.status == 1){
							$.dialog({
								title:json.data.title,
								content:json.msg,
								icon:'succeed',
								init:function(){
									$(".aui_close").remove();
								},
								ok:function(){
									window.location.reload();
									return false;
								},
								cancel:null
							});
						}
					}
				})
			}
		});
	})
})
