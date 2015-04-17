define(function(require,exports){
	// 学科下拉菜单方法
	$('.slideUl').hover(function(){
		$(this).addClass('slideUlHover');
		$(this).find('ul').show();
	},function(){
		$(this).removeClass('slideUlHover');
		$(this).find('ul').hide();
	})
})
