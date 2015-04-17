define(function(require,exports){
    // 添加家长
    $('.addParents').click(function(){
        $('.addParentsUl').removeClass('undis');
        $(this).addClass('undis');
    });
    // 删除家长B
    $('.delParents').click(function(){
        $('.addParentsUl').addClass('undis');
        $('.addParents').removeClass('undis');
    });
    // 选择年显示月
    // $('.yearSelect').change(function(){
    //     $('.monthSelect').removeClass('undisIm');
    // })
    // 提交录入学员表单
    $('.formInputStudent').submit(function(){
        var that = $(this);
        var _sex = that.find('[name=sex]');
        var sexValue = '';
        for(var i=_sex.length;i--;){
            var sex = _sex[i]
        if(sex.checked){
            sexValue = sex.value
        }
        }
        $.ajax({
            url:$('.formInputStudent').attr('action'),
            type:'post',
            dataType:'json',
            data:{
			truthName:that.find('[name=truthName]').val(),
            nickName:that.find('[name=nickName]').val(),
            parentTel1:that.find('[name=parentTel1]').val(),
            parent1ref:that.find('[name=parent1ref]').find('option:selected').val(),
            parentTel2:that.find('[name=parentTel2]').val(),
            parent2ref:that.find('[name=parent2ref]').find('option:selected').val(),
            schoolCode:that.find('[name=schoolCode]').val(),
            studentId:that.find('[name=studentId]').val() || '',
            school:that.find('[name=school]').val(),
            sex:sexValue,
            grade:that.find('[name=grade]').val(),
            path:'',
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
                }else if(json.status == 2){
                    $.dialog({
                        content:json.msg + '<p>'+ json.data.student+'<p>' + '<p>'+ json.data.parent+'<p>',
                        icon:'warning',
                        width:450,
                        ok:function(){
                            $.ajax({
                                url:$('.formInputStudent').attr('action'),
                            type:'post',
                            dataType:'json',
                            data:{
                                truthName:that.find('[name=truthName]').val(),
								nickName:that.find('[name=nickName]').val(),
								parentTel1:that.find('[name=sex]').val(),
								parent1ref:that.find('[name=parent1ref]').find('option:selected').val(),
								parentTel2:that.find('[name=parentTel2]').val(),
								parent2ref:that.find('[name=parent2ref]').find('option:selected').val(),
								schoolCode:that.find('[name=schoolCode]').val(),
								studentId:that.find('[name=studentId]').val() || '',
								school:that.find('[name=school]').val(),
								sex:that.find('[name=sex]').val(),
								grade:that.find('[name=grade]').val(),
								path:'',
								year:that.find('[name=year]').find('option:selected').val(),
								month:that.find('[name=month]').find('option:selected').val(),
								confirm:true
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
									alert();
                                    $.dialog({
                                        content:json.msg,
                                        icon:'succeed',
                                        cancel:null,
                                        ok:null,
                                        button:[
                                    {
                                        name:'查看该学员',
                                        callback:function(){
                                            window.location.href = json.data.infoUrl;
                                        }
                                    },
                                        {
                                            name:'回到学员列表',
                                        callback:function(){
                                            window.location.href = json.data.allUrl;
                                        }
                                        }]
                                    });
                                }
                            }
                            })
                        }
                    });
                }else if(json.status == -1){
                    window.location.href = json.data.url;
                }else if(json.status == 1){
                    window.location.href=json.data.url;
                }else if(json.status == 3){
					$.dialog({
						content:json.msg,
						icon:'succeed',
						cancel:null,
						ok:null,
						button:[
					{
						name:'查看该学员',
						callback:function(){
							window.location.href = json.data.infoUrl;
						}
					},
						{
							name:'回到学员列表',
						callback:function(){
							window.location.href = json.data.allUrl;
						}
						}]
					});

				}
            }
        })
    })
})
