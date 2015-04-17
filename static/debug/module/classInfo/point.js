define(function(require,exports){
	// 得到hash
	var hash = window.location.hash;
	switch(hash){
		case '#currentStudent':
			$(window).scrollTop($('#currentStudent').offset().top);
			break;
		case '#currentSchedule':
			$(window).scrollTop($('#currentSchedule').offset().top);
			break;
		case '#currentTeacherRule':
			$(window).scrollTop($('#currentTeacherRule').offset().top);
			break;
	}
})
