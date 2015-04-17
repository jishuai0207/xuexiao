define(function(require,exports){
    $('.studentInfos').delegate('a.joinNewClass','click',function(){
        var _studentId=$('.classLists').attr('studentid');
        $('.j_classList_dialog').attr('studentId',_studentId);
        $.dialog({
            title:'加入新班级',
            content:$('.j_classList_dialog').html(),
            ok:function(){
                // 如果未选择班级
                if($('.classListShows em.active').length < 1){
                    $.dialog({
                        content:'请选择班级',
                        icon:'warning',
                        cancel:null
                    });
                    return false;
                }
                $.ajax({
                    url:'/index.php/post/orgclass/studentInClass',
                type:'post',
                dataType:'json',
                data:{
                    studentId:_studentId,
                    classId:$('.classListShows em.active').attr('classidnew')
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
                return false;
            }
        })
        // 加载班级模块函数
        require('module/studentInfos/classListMod').init();
    })
})
