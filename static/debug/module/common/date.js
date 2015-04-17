define(function(require,exports){
	
	exports.init=function(){
		exports.chooseYear();//年 处理
		exports.chooseMonth();//选择月份，填充日
	}
    
    //年份填充
    exports.chooseYear=function(){
    	var _html="";
    	var year=new Date().getFullYear();
		_html="<option  value="+(year-1)+">"+(year-1)+"</option>";
		_html+="<option selected value="+year+">"+year+"</option>";
		_html+="<option value="+(year+1)+">"+(year+1)+"</option>";
    	$(".chooseYear").append(_html);
    }

    //操作月份，填充对应的日
    exports.chooseMonth=function(){
        $(".selectChoose").delegate(".chooseMonth","change",function(){
        	var year=$(".chooseYear").val();//得到年份，判断是否是闰年
        	var month=$(this).val();
        	var day=0,_html="";
        	if(month==4 || month==6 || month==9 || month==11){
        		day=30;
        	}else if(month==2){
        		if(year%4==0 && year%100!=0 || year%400==0){
        			day=29;
        		}else{
        			day=28;
        		}
        	}else{
        		day=31;
        	}
        	for(var i=1;i<=day;i++){
                if(i<10){
                    i="0"+i;
                }
				_html+="<option value="+i+">"+i+"</option>";
        	}
        	$(this).parents("li").find(".chooseDay").html("<option selected>--</option>").append(_html).removeAttr("disabled");
        });
    }

})
