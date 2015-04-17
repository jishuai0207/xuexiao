define(function(require,exports){
	// 添加教师弹出层
	$('.j_addTeacher').on('click',function(){
		var _classid = $(this).attr('classid');
		// 请求dialog库
		require('dialog');
		// 弹出方法
		$.dialog({
			title:'添加任课老师',
			content:$('.j_addTeacher_dialog').html(),
			okVal:'添加',
			icon:null,
			ok:function(){
				if($('.createClass .teacherNames li').length > 0){
					$('a.j_addTeacher').addClass('undisIm');
				};
				if($('.teacherArea em.emRadio.active').attr('value') == $('.teacherNames a.close').attr('teacherid')){
					$.dialog({
						content:'请勿重复选择同一老师',
						icon:'warning',
						cancel:null
					})
					$('a.j_addTeacher').removeClass('undisIm');
					return false;
				}
				$('.createClass .teacherNames').append('<li><a href="javascript:void(0)" teacherId="'+$('.teacherArea em.emRadio.active').attr('value')+'" class="blueText close fr">删除</a>'+$('.teacherArea em.emRadio.active').parent().next().text()+'</li>');

			},
			cancel:true
		});
		// 点击老师左侧单选框方法
		$('.teacherArea em.emRadio').each(function(){
			$(this).click(function(){
				$('.teacherArea em.emRadio').removeClass('active');
				$(this).addClass('active');
			})
		});

		// 默认请求数据
		var _val = $('.teacherSelectSearchBox input').val();
		$.ajax({
			url:'/index.php/view/orgclass/createTeacherSelect?subjectId='+$('.formCreatClass .subject').find('option:selected').val(),
			type:'get',
			dataType:'json',
			data:{
				keywords:_val,
				classId:$('.j_addTeacher').attr('classid')
			},
			success:function(json){
                if(json.status == -1){
					window.location.href = json.data.url;
                }else{
				    require('module/createClass/teacherSelectSearch').temp(json);
				    // 替换 | 为 <br />
                    $('.teacherShows').find('.name a').each(function(){
                        var _h = $(this).html().replace('|','<br />');
                        $(this).html(_h);
                        if($(this).html().search('<br>') < 0){
                        	$(this).parent().css('line-height','50px');
                        }
                    })
                }
			}
		});
		// 请求搜索老师数据
		require('module/createClass/teacherSelectSearch').getData();
		// 获取全部数据
		require('module/createClass/teacherSelectSearch').getAllData();
	});
})
