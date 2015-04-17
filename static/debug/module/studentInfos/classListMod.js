define(function(require,exports){
    // 入口
    exports.init = function(){
        //搜索班级
        exports.searchClass();
        // 筛选功能
        exports.screenClass();
        // 搜索全部班级函数
        exports.searchClassAllData();
    }
    // 搜索班级函数
    exports.searchClass = function(){
        $.ajax({
            url:'/index.php/view/orgclass/studentchange',
        type:'post',
        dataType:'json',
        data:{
            studentId:$('.j_classList_dialog').attr('studentId')
        },
        success:function(json){
            if(json.status == -1){
                window.location.href = json.data.url;
            }else{
                // 渲染页面
                exports.temp(json);
                // 点击单选框
                exports.emRadioFn();
            }
        }
        });
        $('.j_classList_dialog .searchClass .submits').click(function(){
            var that = $(this);
            $.ajax({
                url:'/index.php/view/orgclass/studentchange',
                type:'post',
                dataType:'json',
                data:{
                    keywords:that.prev().val(),
                studentId:$('.j_classList_dialog').attr('studentId')
                },
                success:function(json){
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        exports.temp(json);
                        $('.j_classList_dialog .screen').attr('prevkeywords',json.data.prevkeywords);
                    }
                }
            })
        })
    }
    // 搜索全部班级函数
    exports.searchClassAllData = function(){
        $('.j_classList_dialog .searchClass .allDatas').click(function(){
            var that = $(this);
            $.ajax({
                url:'/index.php/view/orgclass/studentchange',
                type:'post',
                dataType:'json',
                data:{
                    studentId:$('.j_classList_dialog').attr('studentId')
                },
                success:function(json){
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        exports.temp(json);
                        $('.j_classList_dialog .screen').attr('prevkeywords',json.data.prevkeywords);
                    }
                }
            })
        })
    }
    // 筛选功能
    exports.screenClass = function(){
        var _key = $('.j_classList_dialog .screen').attr('prevkeywords');
        var _subjectId = '',_gradeId = '';
        $('.j_classList_dialog .screen select.subjects').change(function(){
            var _url = '/index.php/view/orgclass/studentchange';
            _subjectId = $(this).find('option:selected').val();
            $.ajax({
                url:_url,
                type:'post',
                dataType:'json',
                data:{
                    subjectId:$(this).find('option:selected').val(),
                gradeId:_gradeId,
                keywords:$('.searchClass input').val(),
                studentId:$('.j_classList_dialog').attr('studentId')
                },
                success:function(json){
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        exports.temp(json);
                    }
                }
            })
        })
        $('.j_classList_dialog .screen select.grades').change(function(){
            var _url = '/index.php/view/orgclass/studentchange';
            _gradeId = $(this).find('option:selected').val();
            $.ajax({
                url:_url,
                type:'post',
                dataType:'json',
                data:{
                    subjectId:$('.j_classList_dialog .screen select.subjects').find('option:selected').val(),
                    gradeId:_gradeId,
                    keywords:$('.searchClass input').val(),
                    studentId:$('.j_classList_dialog').attr('studentId')
                },
                success:function(json){
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        exports.temp(json);
                        return false;
                    }
                }
            })
        });
    }
    // 搜索结果渲染模版
    exports.temp = function(json){
        if(json.status == 0){
            var html=json.msg;
        }else if(json.status == -1){
            window.location.href = json.data.url;
        }else if(json.status == 1){
            // 定义模版
            var source = '{{each list as value i}}{{if value.isInThisClass == 1}}<ul class="cf active">{{else}}<ul class="cf">{{/if}}<li class="radio fl"><em class="emRadio" classIdNew="{{value.classId}}"></em></li><li class="name fl">{{value.className}}</li><li class="code fl">{{value.classCode}}</li><li class="teacher fl">{{value.teacher}}</li><li class="subject fl">{{value.gradeName}}{{value.Subject}}</li><li class="studentNumber fl">{{value.studentNumber}}</li></ul>{{/each}}';
            // 渲染
            var render = template.compile(source);
            // 临时保存数据
            var html = render({
                list:json.data.classlist
            });
        }
        // 填充页面
        $('.j_classList_dialog .bd .classListShows').html(html);
    }
    // 点击radio
    exports.emRadioFn = function(){
        $('.classListShows').delegate('em.emRadio','click',function(){
            if(!$(this).parent().parent().hasClass('active')){
                $(this).addClass('active').parent().parent().siblings().find('.emRadio').removeClass('active');
            };
        })
    }
})
