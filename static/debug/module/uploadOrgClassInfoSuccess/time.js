define(function(require,exports){
     // 倒计时
    exports.waitTime = function(){
        var wait = 2;
        var timer = null;
        timer = setInterval(function() {
            wait--;
            if(wait < 1){
                clearInterval(timer);
                window.location.href = $('#returnUrl').attr('url');
            }else{
                $(".waitP span").html(wait);
            }
        },1000)
    }
})
