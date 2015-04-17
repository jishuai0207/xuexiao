define(function(require,exports){
    var classType = '';
    // 选择学科
    $('.formCreatClass .subject').change(function(){
		$('.createClass .content ul li').eq(0).find('i').addClass('loading_1');
        var _url = '/index.php/view/orgclass/gradesubject?subjectId='+$('.formCreatClass .subject').find('option:selected').val()+'&gradeId='+$('.formCreatClass .grade').find('option:selected').val();
        $.ajax({
            url:_url,
            type:'get',
            dataType:'json',
            success:function(json){
                if(json.status == -1){
                    window.location.href = json.data.url;
                }else{
                    $('a.j_addTeacher').removeClass('undisIm');
                    classType='';
                    $.each(json.data,function(a,b){
                        classType +='<option value="'+b.code+'">'+b.name+'</option>';
                    });
                    $('.formCreatClass .classType').html(classType);
                    // 清空已选择老师数据
                    $('.formCreatClass .teacherNames').html('');
					$('.createClass .content ul li').eq(0).find('i').removeClass('loading_1');
                }
            }
        })
    })
    // 选择年级
    $('.formCreatClass .grade').change(function(){
		$('.createClass .content ul li').eq(1).find('i').addClass('loading_1');
        var _url = '/index.php/view/orgclass/gradesubject?subjectId='+$('.formCreatClass .subject').find('option:selected').val()+'&gradeId='+$('.formCreatClass .grade').find('option:selected').val();
        $.ajax({
            url:_url,
            type:'get',
            dataType:'json',
            success:function(json){
                if(json.status == -1){
                    window.location.href = json.data.url;
                }else{
                    classType='';
                    $.each(json.data,function(a,b){
                        classType +='<option value="'+b.code+'">'+b.name+'</option>';
                    });
                    $('.formCreatClass .classType').html(classType);
					$('.createClass .content ul li').eq(1).find('i').removeClass('loading_1');
                }
            }
        })
    })
    // 选择班型
    $('.formCreatClass .classType').change(function(){
		$('.createClass .content ul li').eq(3).find('i').addClass('loading_1');
        var that = $(this);
        var _s = $('.formCreatClass .classType').find('option:selected').val();
        var _url = '/index.php/view/orgclass/getPeriod?classTypeCode='+_s;
        $.ajax({
            url:_url,
            type:'get',
            dataType:'json',
            success:function(json){
                if(json.status == -1){
                    window.location.href = json.data.url;
                }else if(json.status == 0){
                    that.parent().next().addClass('undis');
                }else{
                    var _h = '';
                    $.each(json.data.period,function(a,b){
                        _h +='<li><a href="javascript:void(0)" class="comWhiteBtn" period="'+b.classTypePeriod+'">'+b.periodName+'</a></li>';
                    });
                    that.parent().next().removeClass('undis');
                    $('.formCreatClass li ul.period').html(_h);
					$('.createClass .content ul li').eq(3).find('i').removeClass('loading_1');
                    $(".selectChoose").hide();
                }
            }
        })
    })
})
