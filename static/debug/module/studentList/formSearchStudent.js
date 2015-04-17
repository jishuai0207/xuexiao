define(function(require,exports){
	
	//录入学员前端验证
	require('validform');
	
	var demo=$(".formSearchStudent").Validform({
		tiptype:3,
		showAllError:true,
		ajaxPost:true,
		beforeSubmit:function(curform){
			var value = curform.find('.keywords').val();
			curform.attr('action','/index.php/view/student/lists?keywords=' + value);

		},
		callback:function(data){
			$('.studentLists .hd').addClass('undis');
			require('module/studentList/ajax_list').mods(data);
			require('module/studentList/ajax_list').searchStudentPageFn(data);
		}
	});
	
	demo.addRule([
	{
		ele:".keywords",
		datatype:"*",
		nullmsg: "请输入学员编码、学员姓名、原学号",
		errormsg: "输入错误"
	}
	]);
})
