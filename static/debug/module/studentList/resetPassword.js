define(function(require,exports){
    // 重置密码弹出层方法
    $('.resetPassword').click(function(){
        var that=$(this);
        require('dialog');
        $.dialog({
            title:'重置密码',
            content:'确定要重置密码吗？',
            icon:'warning',
            ok:function(){
                $.ajax({
                    url:that.attr('url'),
                type:'get',
                dataType:'json',
                success:function(json){
                    if(json.status == 0){
                        $.dialog({
                            content:json.msg,
                            icon:'warning',
                            cancel:null,
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
                });
                return false;
            }
        })
    })
})
