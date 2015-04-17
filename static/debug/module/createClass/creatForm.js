define(function(require,exports){
	$('.formCreatClass').submit(function(){
		var subjectId = $(this).find('select.subject option:selected').val(),
			gradeId = $(this).find('select.grade option:selected').val(),
			teacherIdOne = $(this).find('ul.teacherNames li').eq(0).find('a').attr('teacherid') || '',
			teacherIdTwo = $(this).find('ul.teacherNames li').eq(1).find('a').attr('teacherid') || '',
			classTypeCode = $(this).find('select.classType option:selected').val(),
			classTypePeriod = $(this).find('ul.period a.comBlueBtn').attr('period'),
			className = $(this).find('.className').val(),
			place = $(this).find('.address').val();
			chooseWeek = $(this).find('.chooseWeek option:selected').val();
			choosePhase = $(this).find('.choosePhase option:selected').val();
			beginHour = $(this).find('.beginHour option:selected').val();
			beginMin = $(this).find('.beginMin option:selected').val();
			endHour = $(this).find('.endHour option:selected').val();
			endMin = $(this).find('.endMin option:selected').val();
			beginYear = $(this).find('.beginYear option:selected').val();
			beginMonth = $(this).find('.beginMonth option:selected').val();
			beginDay = $(this).find('.beginDay option:selected').val();
			endYear = $(this).find('.endYear option:selected').val();
			endMonth = $(this).find('.endMonth option:selected').val();
			endDay = $(this).find('.endDay option:selected').val();

		$.ajax({
			url:$(this).attr('action'),
			data:{
				subjectId:subjectId,
				gradeId:gradeId,
				teacherIdOne:teacherIdOne,
				teacherIdTwo:teacherIdTwo,
				classTypeCode:classTypeCode,
				classTypePeriod:classTypePeriod,
				className:className,
				place:place,
				chooseWeek:chooseWeek,
				choosePhase:choosePhase,
				beginHour:beginHour,
				beginMin:beginMin,
				endHour:endHour,
				endMin:endMin,
				beginYear:beginYear,
				beginMonth:beginMonth,
				beginDay:beginDay,
				endYear:endYear,
				endMonth:endMonth,
				endDay:endDay
			},
			dataType:'json',
			type:'post',
			success:function(json){
				if(json.status == 0){
					$.dialog({
						content:json.msg,
						icon:'warning',
						cancel:null
					})
				}else if(json.status == -1){
					window.location.href = json.data.url;
                }else{
					window.location.href = json.data.url
				}
			}
		})
	})
	


	// 删除老师
	$('.createClass .teacherNames').delegate('a.close','click',function(){
		$(this).parent().remove();
		if($('.createClass .teacherNames li').length < 2){
			$('a.j_addTeacher').removeClass('undisIm');
		};
	})

	// 学期选中方法
	$('.formCreatClass ul.period').delegate('li a','click',function(){
		var period=$(this).attr("period");
		if(period==1 || period==3){
            $(".choosePhase").hide();
            $(".chooseWeek").show();
		}else if(period==2 || period==4){
            $(".chooseWeek").hide();
               $(".choosePhase").show();
		}
		$('.selectChoose select').each(function(){
			$(this).find("option:first").attr('selected','selected');
		});
		$(".beginYear").val(new Date().getFullYear());
		$(".endYear").val(new Date().getFullYear());
		$(".chooseDay").attr("disabled","disabled");
		$(".selectChoose").show();
		$(this).attr('class','comBlueBtn').parent().siblings().find('a').attr('class','comWhiteBtn');
	})
})
