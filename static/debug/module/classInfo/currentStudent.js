define(function(require,exports){
    if($('#currentStudent').length < 1){return false;}
    $.ajax({
        url:'/index.php/view/orgclass/currentstudent',
        type:'get',
        dataType:'json',
        data:{
            classId:$('.studentLists').attr('classid')
        },
        success:function(json){
            if(json.status == -1){
                window.location.href = json.data.url;
            }else{
                exports.temp(json);
                // 分页代码
                $('.page .pageContent').html(json.data.page);
                $('.page').delegate('.pageContent a','click',function(){
                    if($(this).attr('class') == 'active'){return false}
                    var _url = '/index.php/view/orgclass/currentstudent?classId='+$('.studentLists').attr('classid')+'&p=' + $(this).attr('data-ele');
                    $.ajax({
                        url:_url,
                        type:'get',
                        dataType:'json',
                        success:function(json){
                            if(json.status == -1){
                                window.location.href = json.data.url;
                            }else{
                                $('.page .pageContent').html(json.data.page);
                                // 渲染模版函数
                                exports.temp(json);
                            }
                        }
                    })
                });
            }
        }
    })
    // 分页渲染函数
    exports.temp = function(json){
        var _classStatus = $(".studentLists").attr("classStatus");

        if(_classStatus == 1){
            // 定义模版
            var source = '<table border="0" cellspacing="0" cellpadding="0"><tr><th>姓名</th><th>性别</th><th>加入时间</th><th>最近登陆时间</th><th></th></tr>{{each list as value i}}<tr><td><div class="himg cf"><a href="{{value.studentUrl}}" class="blueText"><img src="{{value.avatar}}" alt="" class="fl"> <span class="fl">{{value.studentName}}</span></a></div></td><td>{{value.sex}}</td><td>{{value.joinTime}}</td><td><span class="red">{{value.lastLogin}}</span></td></tr>{{/each}}</table>';
        }else{
            // 定义模版
            var source = '<table border="0" cellspacing="0" cellpadding="0"><tr><th>姓名</th><th>性别</th><th>加入时间</th><th>最近登陆时间</th><th></th></tr>{{each list as value i}}<tr><td><div class="himg cf"><a href="{{value.studentUrl}}" class="blueText"><img src="{{value.avatar}}" alt="" class="fl"> <span class="fl">{{value.studentName}}</span></a></div></td><td>{{value.sex}}</td><td>{{value.joinTime}}</td><td><span class="red">{{value.lastLogin}}</span></td><td><div class="ctrl"><a href="javascript:void(0)" class="blueText quiteClass" studentid="{{value.studentId}}">退班</a> | <a href="javascript:void(0)" class="blueText changeClass" studentid="{{value.studentId}}">转班</a></div></td></tr>{{/each}}</table>';
        }
        // 渲染
        var render = template.compile(source);
        // 临时保存数据
        var html = render({
            list:json.data.studentList
        });
        // 填充页面
        $('.currentStudentShows').html(html);
        // 锚点方法
        require('module/classInfo/point');
    }
})
