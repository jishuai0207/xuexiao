define(function(require,exports){
	// 添加学员弹出层1111
	$('.j_modifyBaseInfo').on('click',function(){
		// 请求dialog库
		require('dialog');
		classId = $('.classInfo').attr('classId');
		// 弹出方法
		$.dialog({
			id:'j_modifyBaseInfo_dialog',
			title:'修改基本信息',
			content:$('.j_modifyBaseInfo_dialog').html().replace('FormModifyBaseInfo_beta','FormModifyBaseInfo'),
			width:660,
			height:120,
			icon:null,
			ok:function(){
				$('.FormModifyBaseInfo').submit();
				return false;
			},
			cancel:true
		});
		// 获取默认值
		$('.FormModifyBaseInfo .classNames').val($('#className').text());
		$('.FormModifyBaseInfo .address').val($('#place').attr('place'));
		//日期处理
		require('module/common/date').chooseMonth();
		//弹出框  会写
		require('module/common/editClass').init();
		//修改基本信息验证
		require('validform');
		$(".FormModifyBaseInfo").Validform({
			tiptype:3,
			showAllError:true,
			ajaxPost:true,
			callback:function(json){
				if(json.status == 0){
					$.dialog({
						content:json.msg,
						icon:'warning',
						width:250,
						height:80,
						cancel:null,
						time:1
					})
				}else if(json.status == -1){
					window.location.href = json.data.url;
                }else if(json.status == 1){
					$.dialog({
						content:json.msg,
						icon:'succeed',
						width:250,
						height:80,
						cancel:null,
						ok:function(){
					        window.location.href = json.data.url;
							return false;
						}
					});
				}
			}
		}).addRule([
		{
			ele:".classNames",
			datatype:"*1-30"
		}
		]);

		$('.FormModifyBaseInfo').append('<input type="hidden" name="classId" value="'+$('.studentLists').attr('classid')+'" />');
	})
})
