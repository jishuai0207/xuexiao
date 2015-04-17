define(function(require,exports){
    $('.quiteClass').click(function(){
        var that = $(this);
        require('dialog');
        $.dialog({
            title:'退出班级',
            content:'确认将<span class="bold">'+$('h2.studentName').text()+'</span>退出<span class="bold">'+$(this).parent().siblings().find('.studentClassName').text()+'</span>？',
            icon:'warning',
            ok:function(){
                $.ajax({
                    url:'/index.php/post/orgclass/studentleave',
                type:'post',
                dataType:'json',
                data:{
                    classId:that.attr('classid'),
                studentId:that.attr('studentid')
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
                })
            }
        })
    })
})
