define(function(require,exports){
    exports.init = function(){
        // 排课弹出层
        exports.startSchedule();
        // 修改排课
        exports.modifySchedule();
        // 添加代课老师
        exports.addSupplyTeacher();
        // 修改代课老师
        exports.modifySupplyTeacher();
        // 删除代课老师
        exports.delSupplyTeacher();
    }
    // 排课弹出层
    exports.startSchedule = function(){
        $('.currentScheduleShows').delegate('a.startSchedule','click',function(){
            var that=$(this);
            $.ajax({
                url:'/index.php/view/schedule/add?action=add',
                type:'post',
                dataType:'json',
                data:{
                    classId:$('.studentLists').attr('classid'),
                    lessonId:that.parent().parent().attr('lessonid')
                },
                success:function(json){
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        var __teacherIdHtml = '';
                        $.each(json.data.teacherlist,function(a,b){
                            // 判断只有一个老师的时候默认选中状态
                            if(json.data.teacherlist.length < 2){
                                __teacherIdHtml ='<label class="fl"><input checked="checked" type="radio" name="xm" teacherId="'+b.teacherId+'" />'+b.truthName+' </label>';
                            }else{
                                __teacherIdHtml +='<label class="fl"><input type="radio" name="xm" teacherId="'+b.teacherId+'" />'+b.truthName+' </label>';
                            }
                        });
                        var _years = ''
                $.each(json.data.yearlist,function(c,d){
                    _years +='<option value="'+d+'">'+d+'</option>'
                })
            var _h = '<li class="cf"><span class="t fl">任课老师<em class="red">*</em></span><p class="fl">'+__teacherIdHtml+'</p></li><li class="cf"><span class="t fl">上课日期<em class="red">*</em></span><p class="fl"><select name="" id="" class="fl selectYear"><option value="">请选择</option>'+_years+'</select><i class="fl">年</i><select name="" id="" class="fl selectMonth"><option value="">请选择</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select><i class="fl">月</i><select name="" id="" class="fl selectDay"><option value="">请选择</option></select><i class="fl">日</i></p></li><li class="cf"><span class="t fl">上课时间<em class="red">*</em></span><p class="fl"><input type="text" class="cInput start_hour fl" /><i class="fl">:</i><input type="text" class="cInput start_minu fl" /><i class="fl">--</i><input type="text" class="cInput end_hour fl" /><i class="fl">:</i><input type="text" class="cInput end_minu fl" /></p></li>';
            $('.Schedule').html(_h);
            // 当选择月的时候获取数据getDaysListByMonth
            $('.selectMonth').change(function(){
                var _url = '/index.php/view/schedule/getDaysListByMonth';
                var _monthId = $(this).find('option:selected').val();
                var _yearId = $(this).parent().find('option:selected').val();
                $.ajax({
                    url:_url,
                    dataType:'json',
                    type:'post',
                    data:{
                        year:_yearId,
                        month:_monthId
                    },
                    success:function(json){
                        if(json.status == -1){
                            window.location.href = json.data.url;
                        }else{
                            var _h = '';
                            $.each(json.data,function(a,b){
                                _h +='<option value="'+b+'">'+b+'</option>';
                            });
                            $('.selectDay').html('<option value="">请选择</option>'+_h);
                        }
                    }
                })
            })
                    }
                }

            });
            $.dialog({
                title:'排课',
                content:$('.j_startSchedule_dialog').html().replace('Schedule_beta','Schedule'),
                width:500,
                ok:function(){
                    var teacherId = $(".Schedule input[name='xm']:checked").attr('teacherid'),
                    classId = $(".studentLists").attr('classid'),
                    lessonId = that.parent().parent().attr('lessonid'),
                    year = $('.selectYear').find('option:selected').val(),
                    mouth = $('.selectMonth').find('option:selected').val(),
                    day = $('.selectDay').find('option:selected').val(),
                    start_hour = $('.start_hour').val(),
                    start_minu = $('.start_minu').val(),
                    end_hour = $('.end_hour').val(),
                    end_minu = $('.end_minu').val(),
                    _url = '/index.php/post/schedule/add';
                    $.ajax({
                        url:_url,
                        dataType:'json',
                        type:'post',
                        data:{
                            teacherId:teacherId,
                            classId:classId,
                            lessonId:lessonId,
                            year:year,
                            mouth:mouth,
                            day:day,
                            start_hour:start_hour,
                            start_minu:start_minu,
                            end_hour:end_hour,
                            end_minu:end_minu
                        },
                        success:function(json){
                            if(json.status == 0){
                                $.dialog({
                                    content:json.msg,
                                    icon:'warning',
                                    cancel:null
                                });
                            }else if(json.status == -1){
                                window.location.href = json.data.url;
                            }else if(json.status == 1){
                                $.dialog({
                                    content:json.msg,
                                    icon:'succeed',
                                    ok:function(){
                                        window.location.reload();
                                        return false;
                                    },
                                    cancel:null
                                });
                            }
                        }
                    })
                    return false;
                }
            });
        })
    }
    //修改排课
    exports.modifySchedule = function(){
        $('.currentScheduleShows').delegate('a.modifySchedule','click',function(){
            var that=$(this);
            $.ajax({
                url:'/index.php/view/schedule/add?action=mod',
                type:'post',
                dataType:'json',
                data:{
                    classId:$('.studentLists').attr('classid'),
                lessonId:that.parent().parent().attr('lessonid')
                },
                success:function(json){
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        var __teacherIdHtml = '';
                        $.each(json.data.teacherlist,function(a,b){
                            __teacherIdHtml +='<label class="fl"><input isSelect="'+b.is_select+'" type="radio" name="xm" teacherId="'+b.teacherId+'" />'+b.truthName+' </label>';
                        });
                        var _years = ''
                $.each(json.data.yearlist,function(c,d){
                    _years +='<option value="'+d+'">'+d+'</option>'
                })
            var _h = '<li class="cf"><span class="t fl">任课老师<em class="red">*</em></span><p class="fl nowTeacher">'+__teacherIdHtml+'</p></li><li class="cf"><span class="t fl">上课日期<em class="red">*</em></span><p class="fl"><select name="" id="" class="fl selectYear"><option value="">请选择</option>'+_years+'</select><i class="fl">年</i><select name="" id="" class="fl selectMonth"><option value="">请选择</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select><i class="fl">月</i><select name="" id="" class="fl selectDay"><option value="">请选择</option></select><i class="fl">日</i></p></li><li class="cf"><span class="t fl">上课时间<em class="red">*</em></span><p class="fl"><input type="text" class="cInput start_hour fl" /><i class="fl">:</i><input type="text" class="cInput start_minu fl" /><i class="fl">--</i><input type="text" class="cInput end_hour fl" /><i class="fl">:</i><input type="text" class="cInput end_minu fl" /></p></li>';
            $('.Schedule').html(_h);
            // 填充已选择数据
            $('.nowTeacher input').each(function(){
                if($(this).attr('isSelect') == 1){
                    $(this).attr('checked','checked');
                }
            });
            // 当选择月的时候获取数据getDaysListByMonth
            $('.selectMonth').change(function(){
                var _url = '/index.php/view/schedule/getDaysListByMonth';
                var _monthId = $(this).find('option:selected').val();
                var _yearId = $(this).parent().find('option:selected').val();
                $.ajax({
                    url:_url,
                    dataType:'json',
                    type:'post',
                    data:{
                        year:_yearId,
                    month:_monthId
                    },
                    success:function(json){
                        if(json.status == -1){
                            window.location.href = json.data.url;
                        }else{
                            var _h = '';
                            $.each(json.data,function(a,b){
                                _h +='<option value="'+b+'">'+b+'</option>'
                            });
                            $('.selectDay').html('<option value="">请选择</option>'+_h);
                        }
                    }
                })
            })
                    }
                }
            });
            $.dialog({
                title:'修改排课',
                content:$('.j_startSchedule_dialog').html().replace('Schedule_beta','Schedule'),
                width:500,
                ok:function(){
                    var teacherId = $(".Schedule input[name='xm']:checked").attr('teacherid'),
                    classId = $(".studentLists").attr('classid'),
                    lessonId = that.parent().parent().attr('lessonid'),
                    year = $('.selectYear').find('option:selected').val(),
                    mouth = $('.selectMonth').find('option:selected').val(),
                    day = $('.selectDay').find('option:selected').val(),
                    start_hour = $('.start_hour').val(),
                    start_minu = $('.start_minu').val(),
                    end_hour = $('.end_hour').val(),
                    end_minu = $('.end_minu').val(),
                    _url = '/index.php/post/schedule/modify';
                    $.ajax({
                        url:_url,
                        dataType:'json',
                        type:'post',
                        data:{
                            teacherId:teacherId,
                        classId:classId,
                        lessonId:lessonId,
                        year:year,
                        mouth:mouth,
                        day:day,
                        start_hour:start_hour,
                        start_minu:start_minu,
                        end_hour:end_hour,
                        end_minu:end_minu
                        },
                        success:function(json){
                            if(json.status == 0){
                                $.dialog({
                                    content:json.msg,
                                    icon:'warning',
                                    cancel:null
                                });
                            }
                            else if(json.status == -1){
                                window.location.href = json.data.url;
                            }else if(json.status == 1){
                                $.dialog({
                                    content:json.msg,
                                    icon:'succeed',
                                    ok:function(){
                                        window.location.reload();
                                        return false;
                                    },
                                    cancel:null
                                });
                            }
                        }
                    })
                    return false;
                }
            })
        })
    }
    // 添加代课老师
    exports.addSupplyTeacher = function(){
        $('.currentScheduleShows').delegate('a.addSupplyTeacher','click',function(){
            var _classid = $('.studentLists').attr('classid');
            var _lessonid = $(this).parent().parent().attr('lessonid');
            $.dialog({
                title:'添加代课老师',
                content:$('.j_addTeacher_dialog').html(),
                ok:function(){
                    // 未选择老师的时候
                    if($('.teacherArea em.emRadio.active').length < 1){
                        $.dialog({
                            content:'请先选择一个老师',
                            icon:'warning'
                        });
                        return false;
                    };
                    $.ajax({
                        url:'/index.php/post/schedule/replaceteacheradd',
                        dataType:'json',
                        type:'post',
                        data:{
                            teacherId:$('.teacherArea em.emRadio.active').attr('value'),
                        classId:_classid,
                        lessonId:_lessonid
                        },
                        success:function(json){
                            if(json.status == 0){
                                $.dialog({
                                    content:json.msg,
                                    icon:'warning',
                                    cancel:null
                                });
                            }else if(json.status == -1){
                                window.location.href = json.data.url;
                            }else if(json.status == 1){
                                $.dialog({
                                    content:json.msg,
                                    icon:'succeed',
                                    ok:function(){
                                        window.location.reload();
                                        return false;
                                    },
                                    cancel:null
                                });
                            }
                        }
                    });
                    return false;
                }
            })
            // 点击老师左侧单选框方法
            $('.teacherArea em.emRadio').each(function(){
                $(this).click(function(){
                    $('.teacherArea em.emRadio').removeClass('active');
                    $(this).addClass('active');
                })
            });
            // 请求搜索老师数据
            require('module/classInfo/teacherSelectSearch').getData();
            // 获取全部数据
            require('module/classInfo/teacherSelectSearch').getAllData();
        })
    }
    // 修改代课老师
    exports.modifySupplyTeacher = function(){
        $('.currentScheduleShows').delegate('a.modifySupplyTeacher','click',function(){
            var _classid = $('.studentLists').attr('classid');
            var _lessonid = $(this).parent().parent().attr('lessonid');
            $.dialog({
                title:'修改代课老师',
                content:$('.j_addTeacher_dialog').html(),
                ok:function(){
                    // 未选择老师的时候
                    if($('.teacherArea em.emRadio.active').length < 1){
                        $.dialog({
                            content:'请先选择一个老师',
                            icon:'warning'
                        });
                        return false;
                    };
                    $.ajax({
                        url:'/index.php/post/schedule/replaceteachermod',
                        dataType:'json',
                        type:'post',
                        data:{
                            teacherId:$('.teacherArea em.emRadio.active').attr('value'),
                            classId:_classid,
                            lessonId:_lessonid
                        },
                        success:function(json){
                            if(json.status == 0){
                                $.dialog({
                                    content:json.msg,
                                    icon:'warning',
                                    cancel:null
                                });
                            }else if(json.status == -1){
                                window.location.href = json.data.url;
                            }else if(json.status == 1){
                                $.dialog({
                                    content:json.msg,
                                    icon:'succeed',
                                    ok:function(){
                                        window.location.reload();
                                        return false;
                                    },
                                    cancel:null
                                });
                            }
                        }
                    });
                    return false;
                }
            })
            // 点击老师左侧单选框方法
            $('.teacherArea em.emRadio').each(function(){
                $(this).click(function(){
                    $('.teacherArea em.emRadio').removeClass('active');
                    $(this).addClass('active');
                })
            });
            // 请求搜索老师数据
            require('module/classInfo/teacherSelectSearch').getData();
            // 获取全部数据
            require('module/classInfo/teacherSelectSearch').getAllData();
        })
    }
    // 删除代课老师
    exports.delSupplyTeacher = function(){
        $('.currentScheduleShows').delegate('a.delSupplyTeacher','click',function(){
            var that=$(this);
            var _teacher = that.parent().parent().parent().attr('replaceTruthName');
            $.dialog({
                title:'删除代课老师',
                content:'确定删除代课老师'+_teacher+'？',
                ok:function(){
                    $.ajax({
                        url:'/index.php/post/schedule/replaceteacherdel',
                        type:'post',
                        dataType:'json',
                        data:{
                            classId:$('.classInfo').attr('classid'),
                            lessonId:that.parent().parent().attr('lessonid')
                        },
                        success:function(json){
                            if(json.status == 0){
                                $.dialog({
                                    title:'删除代课老师',
                                    content:json.msg,
                                    icon:'warning',
                                    cancel:null
                                });
                            }else if(json.status == -1){
                                window.location.href = json.data.url;
                            }else if(json.status == 1){
                                $.dialog({
                                    title:'删除代课老师',
                                    content:json.msg,
                                    icon:'succeed',
                                    ok:function(){
                                        window.location.reload();
                                        return false;
                                    },
                                    cancel:null
                                });
                            }
                        }
                    })
                    return false;
                }
            })
        })
    }

})
