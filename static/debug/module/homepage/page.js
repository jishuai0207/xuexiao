define(function(require,exports){
    // 分页具体数据
    exports.truePage = function(){
        $.ajax({
            url:'/index.php/view/index/index?p=1',
            type:'get',
            dataType:'json',
            success:function(json){
                if(json.status == -1){
                    window.location.href = json.data.url;
                }else{
                    if(json.status == 0){
                        $('.homepageDataList').html(json.msg);
                    }else{
                        // 渲染模版函数
                        exports.mods(json);
                        // 分页代码
                        $('.page .pageContent').html(json.data.page);
                        $('.page').delegate('.pageContent a','click',function(){
                            if($(this).attr('class') == 'active'){return false}
                            var _url = '/index.php/view/index/index?p=' + $(this).attr('data-ele');
                            $.ajax({
                                url:_url,
                                type:'get',
                                dataType:'json',
                                success:function(msg){
                                    if(json.status == -1){
                                        window.location.href = json.data.url;
                                    }else{
                                        $('.page .pageContent').html(msg.data.page);
                                        // 渲染模版函数
                                        exports.mods(msg);
                                    }
                                }
                            })
                        });
                    }
                }
            }
        });
    };
    // 分页渲染函数
    exports.mods = function(json){
        // 定义模版
        var source = '<table border="0" cellspacing="0" cellpadding="0"><tr><th>班级名称</th><th>上课时间</th><th>任课老师</th><th>代课老师</th></tr>{{each list as value i}}<tr><td><a href="{{value.classurl}}">{{value.className}}</a></td><td>{{value.scheduleTime}}</td><td>{{value.teacherTruethName}}{{value.TeacherNickname}}</td><td>{{value.replaceTeacherTruthName}}</td></tr>{{/each}}</table>';
        // 渲染
        var render = template.compile(source);
        // 临时保存数据
        var html = render({
            list:json.data.today_list
        });
        // 填充页面
        $('.homepageDataList').html(html);
    }
})
