define(function(require,exports){
	$('.changeClass').click(function(){
		var _classid = $('#moduleId').attr('classid');
		var _teacherIdOld = $(this).attr('teacherIdOld');
		var _pageType = $(this).attr('pageType');
		var _cl = $('.j_addTeacher_dialog .changeClassBox');
		var _ctrlArea = $(this);
		// 恢复隐藏的更换隐藏的div
		_cl.find('li.tit').removeClass('undis');
		// 取任课角色
		_cl.find('.teacherRule').html(_ctrlArea.parent().siblings('.teacherRule').html());
		// 取当前点击的老师名字
		_cl.find('.teacherOldName').html(_ctrlArea.parent().siblings('.teacherNowName').html());
		var _sechedulenum = $(this).attr('sechedulenum');
		if(_sechedulenum > 0){
			_cl.find('li.red').removeClass('undis');
			_cl.find('li.red').find('em.nums').html(_sechedulenum);
		}else{
			_cl.find('li.red').addClass('undis');
		}
		// 请求dialog库
		require('dialog');
		// 弹出方法
		$.dialog({
			title:'更换任课老师',
			content:$('.j_addTeacher_dialog').html(),
			ok:function(){
				exports.selectTeacher(_classid,_teacherIdOld,_pageType);
				return false;
			}
		});
		// 请求搜索老师数据
		require('module/classInfo/teacherSelectSearch').getData();
		// 获取全部数据
		require('module/classInfo/teacherSelectSearch').getAllData();

	})
	// 处理函数
	exports.selectTeacher = function(_classid,_teacherIdOld,_pageType){
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
				classId:_classid,
				pageType:_pageType
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
					        window.location.href = json.data.url;
							return false;
						},
						cancel:null
					});
				}
			}
		});
	}
})
