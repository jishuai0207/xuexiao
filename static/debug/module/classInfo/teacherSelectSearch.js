define(function(require,exports){
    // 获取数据
    exports.getData = function(){
        var _val = $('.teacherSelectSearchBox input').val();
        $.ajax({
            url:'/index.php/view/orgclass/teacheradd',
            type:'post',
            dataType:'json',
            data:{
                keywords:_val,
            classId:$('#moduleId').attr('classid')
            },
            success:function(json){
                if(json.status == 0){
                    $('.teacherShows').html(json.msg);
                }else if(json.status == -1){
                    window.location.href = json.data.url;
                }else{
                    exports.temp(json);
                }
            }
        })

        $('.teacherSelectSearchBox .submits').click(function(){
            var _val = $(this).prev().val();
            $.ajax({
                url:'/index.php/view/orgclass/teacheradd',
                type:'post',
                dataType:'json',
                data:{
                    keywords:_val,
                classId:$('#moduleId').attr('classid')
                },
                success:function(json){
                    if(json.status == 0){
                        $('.teacherShows').html(json.msg);
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
                url:'/index.php/view/orgclass/teacheradd',
                type:'post',
                dataType:'json',
                data:{
                    keywords:'',
                classId:$('#moduleId').attr('classid')
                },
                success:function(json){
                    if(json.status == -1){
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
            // 替换 | 为 <br />
            $('.teacherShows').find('.name a').each(function(){
                var _h = $(this).html().replace('|','<br />');
                $(this).html(_h);
                if($(this).html().search('<br>') < 0){
                    $(this).parent().css('line-height','50px');
                }
            })
        };
        // 点击单选框选中
        $('.teacherArea em.emRadio').each(function(){
            $(this).click(function(){
                $('.teacherArea em.emRadio').removeClass('active');
                $(this).addClass('active');
                var _h = $.trim($(this).parent().next('.name').text());
                $('.teacherNewName').html(_h);
            })
        });
    }
})
