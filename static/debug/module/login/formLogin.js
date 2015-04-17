define(function(require,exports){
	
	//登录前端验证
	require('validform');
	
	var demo=$(".formLogin").Validform({
		tiptype:3,
		showAllError:true,
		ajaxPost:true,
		callback:function(json){
			if(json.status == 1){
				window.location.href=json.data.url;
			}else if(json.status == 0){
				require('dialog');
				$.dialog({
					content:json.msg,
					icon:'warning',
                    cancel:null
				})
			};
			return false;
		}
	});
	
	demo.addRule([
	{
		ele:".username",
		datatype:"*",
		nullmsg: "请输入您的账号",
		errormsg: "输入错误"
	},
	{
		ele:".password",
		datatype:"*",
		nullmsg: "请输入您的密码",
		errormsg: "输入错误"
	}
	]);
})
