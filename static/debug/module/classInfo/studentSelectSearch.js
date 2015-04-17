define(function(require,exports){
    // 获取数据
    exports.getData = function(){
        var _val = $('.studentSelectSearchBox input').val();
        $.ajax({
            url:'/index.php/view/orgclass/addstulist',
            type:'post',
            dataType:'json',
            data:{
                keywords:_val,
                classId:$('#moduleId').attr('classid')
            },
            success:function(json){
                if(json.status == 0){
                    $('.studentShows').html(json.msg);
                }else if(json.status == -1){
                    window.location.href = json.data.url;
                }else{
                    exports.temp(json);
                }
            }
        })
        $('.studentSelectSearchBox .submits').click(function(){
            var _s = [];
            $('.hasSeleted li').each(function(){
                _s.push($(this).attr('studentid'));
            });
            var _val = $(this).prev().val();
            $.ajax({
                url:'/index.php/view/orgclass/addstulist',
                type:'post',
                dataType:'json',
                data:{
                    keywords:_val,
                    classId:$('#moduleId').attr('classid'),
                    selectList:_s
                },
                success:function(json){
                    if(json.status == 0){
                        $('.studentShows').html(json.msg);
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
        $('.studentSelect .allDatas').click(function(){
            var _s = [];
            $('.hasSeleted li').each(function(){
                _s.push($(this).attr('studentid'));
            });
            // 清空输入框的值
            $('.studentSelectSearchBox input').val('');
            $.ajax({
                url:'/index.php/view/orgclass/addstulist',
                type:'post',
                dataType:'json',
                data:{
                    keywords:'',
                    classId:$('.j_addStudent').attr('classid'),
                    selectList:_s
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
                if(b.isInThisClass == 1){
                    _li += '<li class="cf active" studentid="'+b.studentId+'"><span class="name fl"><a href="'+ b.studentUrl +'" class="blueText" target="_blank">'+ b.studentName +'</a></span> <span class="code fl" title="'+b.studentCode+'">'+ b.studentCode+'</span><span class="grade fl">'+b.gradeName+'</span><a class="add fr">添加</a></li>';
                }else{
                    _li += '<li class="cf" studentid="'+b.studentId+'"><span class="name fl"><a href="'+ b.studentUrl +'" class="blueText" target="_blank">'+ b.studentName +'</a></span> <span class="code fl" title="'+b.studentCode+'">'+ b.studentCode +'</span><span class="grade fl">'+b.gradeName+'</span><a class="add fr">添加</a></li>';
                }
            });
            _html += '<div class="box"><span class="tit">'+ key +'</span><ul>'+ _li +'</ul></div>';
        });
        if(json.status == 0){
            $('.studentShows').html(json.msg);
        }else if(json.status == -1){
            window.location.href = json.data.url;
        }else if(json.status == 1){
            $('.studentShows').html(_html);
        };
    }
})
