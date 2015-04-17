define(function(require,exports){
	$('.changeClass').click(function(){
		var _classid = $('.j_addTeacher').attr('classid');
		var _teacherIdOld = $(this).attr('teacherIdOld');
		var _cl = $('.j_addTeacher_dialog .changeClass');
		var _ctrlArea = $('.ctrlArea');
		// 恢复隐藏的更换隐藏的div
		_cl.removeClass('undis');
		// 取任课角色
		_cl.find('.teacherRule').html(_ctrlArea.find('.teacherRule').html());
		// 取当前点击的老师名字
		_cl.find('.teacherOldName').html(_ctrlArea.find('.teacherNowName').html());
		// 请求dialog库
		require('dialog');
		// 弹出方法
		$.dialog({
			content:$('.j_addTeacher_dialog').html(),
			ok:function(){
				exports.selectTeacher(_classid,_teacherIdOld);
				return false;
			}
		});
		// 请求搜索老师数据
		require('module/classInfo/teacherSelectSearch').getData();
		// 获取全部数据
		require('module/classInfo/teacherSelectSearch').getAllData();
		// 点击老师左侧单选框方法
		$('.teacherArea em.emRadio').each(function(){
			$(this).click(function(){
				$('.teacherArea em.emRadio').removeClass('active');
				$(this).addClass('active');
				var _h = $.trim($(this).parent().next('.name').text());
				$('.teacherNewName').html(_h);
			})
		});

	})
	// 处理函数
	exports.selectTeacher = function(_classid,_teacherIdOld){
		// 未选择老师的时候
		if($('.teacherArea em.emRadio.active').length < 1){
			$.dialog({
				content:'请先选择一个老师',
				icon:'warning'
			});
			return false;
		};
		$.ajax({
			url:'/index.php/post/orgclass/changeteacher',
			dataType:'json',
			type:'post',
			data:{
				teacherIdNew:$('.teacherArea em.emRadio.active').attr('value'),
				teacherIdOld:_teacherIdOld,
				classId:_classid
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
					$.dialog({
						content:json.msg,
						icon:'succeed',
						ok:function(){
							window.location.reload();
							return false;
						},
						cancel:null
					});
				}
			}
		});
	}
})
