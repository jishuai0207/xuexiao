define(function(require,exports){
    // 请求删除班级弹出层
    $('.j_delClassInfo').on('click',function(){
        var classid = $(this).attr('classid');
        if(Number($('#studentNums').html())  > 0){
            $.dialog({
                content:'删除班级前，请先将所有学员退班',
                icon:'warning',
                okVal:'知道了',
                cancel:null
            });
            return false;
        }
        // 请求dialog库
        require('dialog');
        $.dialog({
            id:'curformQuiteClass',
            title:"删除班级",
            content:'确认删除班级？',
            icon:'warning',
            ok:function(){
                $.ajax({
                    url:'/index.php/post/orgclass/del',
                    dataType:'json',
                    type:'post',
                    data:{
                        classId:classid
                    },
                    success:function(json){
                        $.dialog({id:'curformQuiteClass'}).close();
                        if(json.status == 0){
                            $.dialog({
                                content:json.msg,
                                icon:'warning',
                                okVal:'知道了',
                                cancel:null
                            })
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
                                    window.location.href=json.data.url;
                                    return false;
                                },
                                okVal:'回到班级列表',
                                cancel:null
                            });
                        }

                    }
                });
                return false;
            }
        })

    })
})
