define(function(require,exports){
    exports.init = function(){
        // 退出班级
        exports.quiteClassFn();
        // 转班
        exports.changeClassFn();
    };
    // 退出班级
    exports.quiteClassFn = function(){
        $('.currentStudentShows').delegate('a.quiteClass','click',function(){
            var that = $(this);
            var name = that.parent().parent().siblings().find('.himg').text();
            var className = $('#className').text();
            $.dialog({
                title:'退班',
                icon:'warning',
                content:'确定将<span class="bold">'+name+'</span>退出'+'<span class="bold">'+className+'</span>？',
                ok:function(){
                    $.ajax({
                        url:'/index.php/post/orgclass/studentleave',
                    type:'get',
                    dataType:'json',
                    data:{
                        classId:$('.studentLists').attr('classid'),
                    studentId:that.attr('studentid')
                    },
                    success:function(json){
                        if(json.status == 0){
                            $.dialog({
                                title:'退班',
                                content:json.msg,
                                icon:'warning',
                                cancel:null
                            });
                        }else if(json.status == -1){
                            window.location.href = json.data.url;
                        }else if(json.status == 1){
                            $.dialog({
                                title:'退班',
                                content:json.msg,
                                icon:'succeed',
                                init:function(){
                                    $(".aui_close").remove();
                                },
                                ok:function(){
                                    window.location.reload();
                                    return false;
                                },
                                cancel:null
                            });
                        }
                    }
                    })
                    return false;
                }
            })

        });
    }

    // 转班
    exports.changeClassFn = function(){
        $('.currentStudentShows').delegate('a.changeClass','click',function(){
            var _studentId=$(this).attr('studentid');
            $('.j_classList_dialog').attr('studentId',_studentId);
            var _classid=$('.studentLists').attr('classid');
            $.dialog({
                title:'转班',
                content:$('.j_classList_dialog').html(),
                ok:function(){
                    if($('.classListShows em.active').length < 1){
                        $.dialog({
                            title:'转班',
                            content:'请选择一个班级',
                            icon:'warning',
                            okVal:'知道了',
                            cancel:null
                        });
                        return false;
                    };
                    $.ajax({
                        url:'/index.php/post/orgclass/studentchange',
                        type:'post',
                        dataType:'json',
                        data:{
                            studentId:_studentId,
                            classIdNew:$('.classListShows em.active').attr('classidnew'),
                            classId:_classid
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
                                    init:function(){
                                        $(".aui_close").remove();
                                    },
                                    ok:function(){
                                        window.location.reload();
                                        return false;
                                    },

                                    cancel:null
                                });
                            }
                        }
                    })
                    return false;
                }
            })
            // 加载班级模块函数
            require('module/classInfo/classListMod').init();
        })

    }

})
