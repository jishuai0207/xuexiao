define(function(require,exports){

   exports.init=function(){
   		  $.ajax({
	   		url:"/index.php/view/orgclass/gettimeofclass",
	   		data:{classId:classId},
	        dataType:"json",
	        success:function(data){
	        	if(data==""){return;}
	        	if(data.data.show=="semester"){
	        		$(".choosePhase").show();
	        		$(".chooseWeek ").hide();
	        	}else{
	        		$(".choosePhase").hide();
	        		$(".chooseWeek ").show();
	        	}
	        	$(".beginYear").val(data.data.beginTime[0]);
	        	$(".beginMonth").val(data.data.beginTime[1]);
				$(".endYear").val(data.data.endTime[0]);
	        	$(".endMonth").val(data.data.endTime[1]);
	        	$(".choosePhase").val(data.data.tearm);
				$(".chooseWeek").val(data.data.tearm);
				$(".beginHour").val(data.data.beginTimeSlot[0]);
				$(".beginMin").val(data.data.beginTimeSlot[1]);
				$(".endHour").val(data.data.endTimeSlot[0]);
				$(".endMin").val(data.data.endTimeSlot[1]);
	        	$(".beginMonth").change();
				$(".endMonth").change();
	        	$(".endDay").val(data.data.endTime[2]);
				$(".beginDay").val(data.data.beginTime[2]);


	        }
  		 });

   }
 

});
