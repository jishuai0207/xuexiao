define(function(require,exports){
	$('.subjectli li a').click(function(){
		if($(this).attr('class') !== "active"){
			$(this).addClass('active');
		}else{
			$(this).removeClass('active');
		}

	})
	// 选择年显示月
	// $('.yearSelect').change(function(){
	// 	$('.monthSelect').removeClass('undisIm');
	// })

	$('.formAddTeacher').submit(function(){
		var that = $(this);
		var subjectArr = [];
		$(this).find('.subjectli li a.active').each(function(){
			subjectArr.push($(this).attr('subjectId'));
		});
		// 判断获取男女
		var _sex = that.find('[name=sex]');
        var sexValue = '';
        for(var i=_sex.length;i--;){
            var sex = _sex[i]
            if(sex.checked){
                sexValue = sex.value
            }
        }
		// 发送请求
		$.ajax({
			url:$('.formAddTeacher').attr('action'),
			type:'post',
			dataType:'json',
			data:{
				truthName:that.find('[name=truthName]').val(),
				nickName:that.find('[name=nickName]').val(),
				sort:that.find('[name=sort]').val(),
				telphone:that.find('[name=telphone]').val(),
				subject:subjectArr,
				sex:sexValue,
				path:'',
				inJob:that.find('[name=injob]:checked').val(),
				email:that.find('[name=email]').val(),
				idCard:that.find('[name=idCard]').val(),
				position:that.find('[name=position]:checked').val(),
				year:that.find('[name=year]').find('option:selected').val(),
				month:that.find('[name=month]').find('option:selected').val()
			},
			success:function(json){
				require('dialog');
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
