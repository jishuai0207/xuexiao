define(function(require,exports){
	//修改班级信息
	$('.j_modifyBaseInfo').on('click',function(){		
		var that = $(this);
		// 请求dialog库
		classId = that.attr('classid');
		require('dialog');
		// 弹出方法
		$.dialog({
			id:'j_modifyBaseInfo_dialog',
			title:'修改基本信息',
			content:$('.j_modifyBaseInfo_dialog').html().replace('FormModifyBaseInfo_beta','FormModifyBaseInfo'),
			width:700,
			height:120,
			icon:null,
			ok:function(){
				$('.FormModifyBaseInfo').submit();
				return false;
			},
			cancel:true
		});
		// 获取默认值
		var _name = $.trim(that.parent().parent().parent().prev().find('.className').text());
		$('.FormModifyBaseInfo .classNames').val(_name);
		$('.FormModifyBaseInfo .address').val(that.attr('place'));
		
		//日期处理
		require('module/common/date').init();
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
						cancel:null
					})
				}else if(json.status == -1){
					window.location.href = json.data.url;
                }else if(json.status == 1){
					$.dialog({
						content:json.msg,
						icon:'succeed',
						cancel:null,
						ok:function(){
							window.location.reload();
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
		$('.FormModifyBaseInfo').append('<input type="hidden" name="classId" value="'+that.attr('classid')+'" />');
	})
})
