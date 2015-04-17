define(function(require,exports){
	//自定义班型名称
	require('dialog');
    $(".typesEdit").delegate(".editBtn","click",function(){
		var _oldData = $(this).prev().html();
    	var _parent=$(this).parent();
           _parent.hide().next().show();
		   _parent.next().find("input[name=typeName]").val(_oldData);
    })

 	$(".typesEdit").delegate(".sureEdit","click",function(){
    	var _parent=$(this).parents(".editNameHidden");
    	var _val=_parent.find("input[name=typeName]").val();
    	var typeCode=$(this).attr('typeCode');
			$.post('/index.php/classtype/setcustomtypename',{typeCode:typeCode,classTypeName:_val},function(data){ 
					if(data.status == 0){
						artDialog({
							content:data.msg,
							icon:'warning',
							cancel:null
						});
					}
					if(data.status == 1){
					   _parent.hide().prev().show();
					   _parent.prev().find(".typeName").html(_val);
					}
				},'json'
			)
    })

  	$(".typesEdit").delegate(".cancleEdit","click",function(){
    	var _parent=$(this).parents(".editNameHidden");
           _parent.hide().prev().show();
    })


})
