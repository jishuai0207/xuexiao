define(function(require,exports){

	exports.init=function(){
		exports.submitForm();
		exports.pageClick();
	}

	exports.submitForm=function(){
		$("#signForm").submit(function(){
			$(this).ajaxSubmit({
				url:"/index.php/sign/getTmpData",
			type:"post",
			dataType:"json",
			success:function(json){
				if(json.status==0){
					require('dialog');//调用dialog
					$.dialog({
						title:'提示信息',
						content:json.msg,
						okVal:'确认',
						cancel:false
					})
				}else{
					var signList = '{{each info as value i}}<tr siid="{{value.siid}}" lid="{{value.lesson_id}}" cid="{{value.cid}}"><td>{{value.school}}</td><td>{{value.truthName}}</td><td class="w100">{{value.classCode}}</td><td class="w170">{{value.className}}</td><td>{{value.subDate}}</td><td>{{value.subTime}}</td><td><font {{if value.issign == "0"}} class="red" {{/if}}>{{value.signInfo}}</font></td><td>{{value.scoreInfo}}</td><td>{{value.teacher[0]}}{{if value.teacher[1] != ""}}</br>{{value.teacher[1]}}{{/if}}</td><td>{{value.replaceInfo}}</td><td>{{value.refInfo}}</td><td>{{value.parentTel1}}</td></tr>{{/each}}';
					var render = template.compile(signList);
					// 临时保存数据
					var html = render({
						info:json.data.info
					});
					$('#signtable').html(html);
					$('.pageContent').html(json.data.page);
				}
			},

			error:function(XMLHttpRequest, textStatus, errorThrown){            
				require('dialog');//调用dialog
				$.dialog({
					title:'提示信息',
					content:"方法调用失败",
					okVal:'确认',
					cancel:false
				})
			}
		});
		return false;
	});
}

exports.pageClick=function(){
	$(".pageContent").delegate("a","click",function(event){
		  	event.preventDefault();
			var _url=$(this).attr("href");
			if(_url=='javascript:;') return false;
			$.ajax({
				url:_url,
				type:"get",
				dataType:"json",
				success:function(json){
					if(json.status==0){
						require('dialog');//调用dialog
						$.dialog({
							title:'提示信息',
							content:json.msg,
							okVal:'确认',
							cancel:false
						})
					}else{
						var signList = '{{each info as value i}}<tr siid="{{value.siid}}" lid="{{value.lesson_id}}" cid="{{value.cid}}"><td>{{value.school}}</td><td>{{value.truthName}}</td><td class="w100">{{value.classCode}}</td><td class="w170">{{value.className}}</td><td>{{value.subDate}}</td><td>{{value.subTime}}</td><td><font {{if value.issign == "0"}} class="red" {{/if}}>{{value.signInfo}}</font></td><td>{{value.scoreInfo}}</td><td>{{value.teacher[0]}}{{if value.teacher[1] != ""}}</br>{{value.teacher[1]}}{{/if}}</td><td>{{value.replaceInfo}}</td><td>{{value.refInfo}}</td><td>{{value.parentTel1}}</td></tr>{{/each}}';
						var render = template.compile(signList);
						// 临时保存数据
						var html = render({
							info:json.data.info
						});
						$('#signtable').html(html);
						$('.pageContent').html(json.data.page);
					}
				},
				error:function(){
					require('dialog');//调用dialog
					$.dialog({
						title:'提示信息',
						content:"方法调用失败",
						okVal:'确认',
						cancel:false
					})
				}
			});
	});
}



})

