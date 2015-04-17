define(function(require,exports){
    // 获取数据
    exports.getData = function(){
        $('.teacherSelectSearchBox .submits').click(function(){
            var _val = $(this).prev().val();
            $.ajax({
                url:'/index.php/view/orgclass/createTeacherSelect?subjectId='+$('.formCreatClass .subject').find('option:selected').val(),
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
                        exports.temp(json);
                    }
                }
            })
        })
    }
    // 获取全部数据
    exports.getAllData = function(){
        $('.teacherSelect .allDatas').click(function(){
            // 清空输入框的值
            $('.teacherSelectSearchBox input').val('');
            $.ajax({
                url:'/index.php/view/orgclass/createTeacherSelect?subjectId='+$('.formCreatClass .subject').find('option:selected').val(),
                type:'get',
                dataType:'json',
                data:{
                    keywords:'',
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
                        exports.temp(json);
                    }
                }
            })
        })
    }
    // 模版
    exports.temp = function(json){
        var _html='';
        $.each(json.data.list,function(key,val){
            var _li = '';
            $.each(json.data.list[key],function(a,b){
                _li += '<li class="cf"><span class="radio fl"><em name="teacherId" class="emRadio" value="'+ b.teacherId +'"></em></span> <span class="name fl"><a href="'+ b.teacherinfourl +'" class="blueText" target="_blank">'+ b.truthName +'</a></span> <span class="code fl" title="'+b.teacherCode+'">编码：'+ b.teacherCode +'</span> <span class="img"><img src="'+ b.path +'" alt=""></span></li>';
            });
            _html += '<div class="box"><span class="tit">'+ key +'</span><ul>'+ _li +'</ul></div>';
        });
        if(json.status == 0){
            $('.teacherShows').html(json.msg);
        }else if(json.status == -1){
            window.location.href = json.data.url;
        }else if(json.status == 1){
            $('.teacherShows').html(_html);
        };
        // 点击单选框选中
        $('.teacherArea em.emRadio').each(function(){
            $(this).click(function(){
                $('.teacherArea em.emRadio').removeClass('active');
                $(this).addClass('active');
            })
        });
    }
})
