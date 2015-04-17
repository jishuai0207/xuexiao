define(function(require,exports){
    var _s = $('.uploadOrgClassInfo');
    var _isup = _s.attr('isup');
    var _a = (_s.attr('status') == 1) && (_s.attr('filemd5') !=='') && (_s.attr('step') == 2);
    if(_a){
        $.ajax({
            url:'/index.php/orgclass/uploadstatus?status='+_s.attr('status')+'&fileMd5='+_s.attr('filemd5')+'&classId='+_s.attr('classId')+'&step='+_s.attr('step'),
            type:'get',
            dataType:'json',
            success:function(json){
                if(json.status == 1){
                    // 下一步按钮显示并可点击
                    $('.cancelClick').addClass('undis');
                    $('.nextBlueBtn').removeClass('undis');
                    $('.inMsg').html(json.msg);
					$('#File1').hide();
					$('.yh').hide();
                }else if(json.status == -1){
                    window.location.href = json.data.url;
                }else{
                    $('.cancelClick').addClass('undis');
                    // $('.cancelClick').removeClass('undis');
                    $('.inMsg').html(json.msg);
                    return false;
                }
            }
        })
    }else{
        if(_isup == 1){
            $('.inMsg').html('上传失败,文件格式与模版文件不符');
        }
    }
})
