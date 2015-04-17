define(function(require,exports){
    var arr = [];
    // 添加学员弹出层
    $('.j_addStudent').on('click',function(){
        var _classid = $(this).attr('classid');
        // 请求dialog库
        require('dialog');
        // 弹出方法
        $.dialog({
            title:'添加学员',
            content:$('.j_addStudent_dialog').html().replace('allStudent_beta','allStudent'),
            okVal:'添加',
            icon:null,
            ok:function(){
                if($('.allStudent .remove').length < 1){
                    return false;
                };
                $.ajax({
                    url:'/index.php/post/orgclass/studentadd',
                    type:'post',
                    dataType:'json',
                    data:{
                        classId:_classid,
                        studentIdList:arr
                    },
                    success:function(json){
                        if(json.status == 0){
                            $.dialog({
                                content:json.msg,
                                icon:'warning',
                                cancel:null
                            });
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
                        }else if(json.status == -1){
                            window.location.href = json.data.url;
                        }
                    }
                })
                return false;
            },
            cancel:true
        });
        // 请求搜索老师数据
        require('module/classInfo/studentSelectSearch').getData();
        // 获取全部数据
        require('module/classInfo/studentSelectSearch').getAllData();
        // 点击添加或者删除逻辑
        exports.addDelFn();
        // 添加学员弹出层年级筛选函数
        $('.slideUl').hover(function(){
            $(this).addClass('slideUlHover');
            $(this).find('ul').show();
        },function(){
            $(this).removeClass('slideUlHover');
            $(this).find('ul').hide();
        });
        
        // 鼠标经过年级下拉层
        var _arr = [];
        $('.studentArea .gradeDiv ul a').click(function(){
            var _s = [];
            $('.hasSeleted li').each(function(){
                _s.push($(this).attr('studentid'));
            });
            var _seleted = $(this).attr('value');
            if($(this).attr('class') !== "active"){
                $(this).addClass('active');
                _arr.push(_seleted);
            }else{
                $(this).removeClass('active');
                _arr.splice($.inArray(_seleted,_arr),1);
            }
            $.ajax({
                url:'/index.php/view/orgclass/addstulist',
                dataType:'json',
                type:'post',
                data:{
                    classId:$('#moduleId').attr('classid'),
                    gradeIds:_arr,
                    selectList:_s
                },
                success:function(json){
                    if(json.status == 0){
                        $('.studentShows').html(json.msg);
                    }else if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        require('module/classInfo/studentSelectSearch').temp(json);
                    }
                }
            })
        })
    });
    // 点击搜索框
    $('.studentSelectSearchBox .submits').on('click',function(e){
        e.stopPropagation();
        var _classid = $(this).attr('classid');
        exports.selectStudent(_classid);
    });
    // 处理函数
    exports.selectStudent = function(_classid){
        $.ajax({
            url:'/index.php/post/orgclass/addstulist',
            dataType:'json',
            type:'post',
            data:{
                classId:_classid
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
    }
    // 点击添加或者删除逻辑方法
    exports.addDelFn = function(){
        var _i = 0;
        $('.allStudent').delegate('.add','click',function(){
            if($(this).parent().hasClass('active')){return false}
            _i++;
            $('.hasSeleted .number').html(_i);
            var that = $(this);
            statusFn.addStudent(that);
        });
        $('.allStudent').delegate('.remove','click',function(){
            _i--;
            $('.hasSeleted .number').html(_i);
            var that = $(this);
            statusFn.delStudent(that);
        });
        var statusFn = {
            // 添加学员
            addStudent:function(obj){
                var objParent = obj.parent();
                // 防止重复点击
                if(objParent.hasClass('active')){return false;}
                // 点击的时候添加active
                objParent.addClass('active');
                var _h = objParent.html().replace('add','remove');
                var _sid = objParent.attr('studentid');
                arr.push(_sid);
                $('.allStudent .hasSeleted .list ul').append('<li class="cf" studentid='+ _sid +'>'+_h+'</li>');
            },
            // 删除学员
            delStudent:function(obj){
                var objParent = obj.parent();
                objParent.remove();
                var _sid = objParent.attr('studentid');
                arr.splice($.inArray(_sid,arr),1);
                $('.allStudent .studentShows .box ul li').each(function(){
                    if($(this).attr('studentid') == objParent.attr('studentid')){
                        $(this).removeClass('active');
                    }
                })
            }
        };
    }
})
