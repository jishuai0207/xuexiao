define(function(require,exports){
    //录入学员前端验证
    require('validform');
    var demo=$(".FormResetPassword").Validform({
        tiptype:3,
        showAllError:false,
        ajaxPost:true,
        callback:function(json){
            if(json.status == 1){
                require('dialog');
				$.dialog({
					content:'修改密码成功',
					icon:"succeed",
					okVal:'去登录',
					cancel:null,
					ok:function(){
						window.location.href = json.data.url;
					}
				})
            };
            return false;
        }
    });

    demo.addRule([
        {
            ele:".telephone",
            datatype:"m",
            nullmsg: "请输入手机号",
            errormsg: "输入错误"
        },
        {
            ele:".setNewPassword",
            datatype:"s6-16",
            nullmsg: "请输入新密码",
            errormsg: "新密码输入错误"
        },
        {
            ele:".setNewPasswordSec",
            datatype:"s6-16",
            recheck:"newPass",
            nullmsg: "请重复输入新密码",
            errormsg: "两次密码输入不一致"
        }
    ]);

    // 发送验证码方法
    $('.sendWord').click(function(){
        var that = $(this);
        var _mobile = $('.telephone').val();
        $.ajax({
            url:'/index.php/post/login/sendCode',
            type:'post',
            dataType:'json',
            data:{
                telephone:_mobile
            },
            success:function(json){
                require('dialog');
                if(json.status == 0){
                    $.dialog({
                        content:json.msg,
                        icon:'warning',
                        cancel:null
                    });
                }else if(json.status == 1){
                    if(that.attr('id')){return false};
                    that.attr('id','sendWordOk');
                    exports.waitTime();
                    // $.dialog({
                    // 	content:json.msg,
                    // 	icon:'succeed',
                    // 	ok:function(){
                    // 		// window.location.reload();
                    // 		return false;
                    // 	},
                    // 	cancel:null
                    // });
                }
            }
        });

    })

    // 倒计时
    exports.waitTime = function(){
        var wait = 60;
        var timer = null;
        timer = setInterval(function() {
            wait--;
            if(wait < 0){
                clearInterval(timer);
                $("#sendWordOk").attr("id","").html("重新发送");
            }else{
                $("#sendWordOk").html(wait + "秒后重新发送");
            }
        },1000)
    }
})
