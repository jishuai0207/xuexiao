define(function(require,exports){
	// 添加教师弹出层
	$('.j_addTeacher').on('click',function(){
		var _classid = $(this).attr('classid');
		var _pageType = $(this).attr('pageType');
		// 请求dialog库
		require('dialog');
		// 弹出方法
		$.dialog({
			title:'添加任课老师',
			content:$('.j_addTeacher_dialog').html(),
			okVal:'添加',
			icon:null,
			ok:function(){
				exports.selectTeacher(_classid,_pageType);
				return false;
			},
			cancel:true
		});
		// 默认请求数据
		var _val = $('.teacherSelectSearchBox input').val();
		$.ajax({
			url:'/index.php/view/orgclass/teacherAdd',
			type:'get',
			dataType:'json',
			data:{
				keywords:_val,
				classId:$('.j_addTeacher').attr('classid')
			},
			success:function(json){
				if(json.status == 0){
					$.dialog({
						content:json.msg,
						icon:'warning'
					})
				}else if(json.status == -1){
					window.location.href = json.data.url;
                }else{
					require('module/classInfo/teacherSelectSearch').temp(json);
				}
			}
		});
		// 点击老师左侧单选框方法
		$('.teacherArea em.emRadio').each(function(){
			$(this).click(function(){
				$('.teacherArea em.emRadio').removeClass('active');
				$(this).addClass('active');
			})
		});
		// 请求搜索老师数据
		require('module/classInfo/teacherSelectSearch').getData();
		// 获取全部数据
		require('module/classInfo/teacherSelectSearch').getAllData();
	});

	// 处理函数
	exports.selectTeacher = function(_classid,_pageType){
		// 未选择老师的时候
		if($('.teacherArea em.emRadio.active').length < 1){
			$.dialog({
				content:'请先选择一个老师',
				icon:'warning'
			});
			return false;
		};
		$.ajax({
			url:'/index.php/post/orgclass/addteacher',
			dataType:'json',
			type:'post',
			data:{
				teacherId:$('.teacherArea em.emRadio.active').attr('value'),
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
