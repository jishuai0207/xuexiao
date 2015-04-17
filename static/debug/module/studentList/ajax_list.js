define(function(require,exports){
    // 分页具体数据
    exports.truePage = function(){
        $.ajax({
            url:'/index.php/view/student/lists?p=1',
        type:'get',
        dataType:'json',
        success:function(json){
            if(json.status == -1){
                window.location.href = json.data.url;
            }else{
                // 渲染模版函数
                exports.mods(json);
                // 分页函数
                exports.pageFn(json);
            }
        }
        });
    };
    // 分页渲染函数
    exports.mods = function(json){
        // 定义模版
        var source = '<table border="0" cellspacing="0" cellpadding="0"><tr><th>姓名</th><th>性别</th><th>在校年级</th><th>目前班级数</th><th>录入时间</th><th>最近登陆时间</th><th></th></tr>{{each list as value i}}<tr><td><div class="himg cf"><a href="{{value.infoUrl}}" class="blueText"><img src="{{value.path}}" alt="" class="fl"></a><ul class="fl text"><li><a href="{{value.infoUrl}}" class="blueText">{{value.name}}</a></li><li class="grey">编码：{{value.id}}</li><li class="grey">原学号：{{value.code}}</li></ul></div></td><td>{{value.sex}}</td><td>{{value.grade}}</td><td>{{value.classNum}}</td><td>{{value.creat}}</td><td><span class="red">{{value.loginTime}}</span></td><td><ul class="ctrl"><li><a href="{{value.classUrl}}" class="blueText">班级管理</a></li><li><a href="{{value.modifyUrl}}" class="blueText">修改基本信息</a></li><li><a href="{{value.resetUrl}}" class="blueText">充值密码</a></li></ul></td></tr>{{/each}}</table>';
        // 渲染
        var render = template.compile(source);
        // 临时保存数据
        var html = render({
            list:json.data.studentList
        });
        // 填充页面
        $('.studentDataList').html(html);
    }
    // 分页函数
    exports.pageFn = function(json){
        // 分页代码
        $('.page .pageContent').html(json.data.page);
        $('.page').delegate('.pageContent a','click',function(){
            if($(this).attr('class') == 'current'){return false};
            var _url = '/index.php/view/student/lists?&p=' + $(this).attr('data-ele');
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
    // 搜索学员分页函数
    exports.searchStudentPageFn = function(json){
        // 分页代码
        $('.page .pageContent').html(json.data.page);
        $('.page').delegate('.pageContent a','click',function(){
            // 防止重复点击
            if($(this).attr('class') == 'current'){return false};
            // 获取搜索关键字
            // var value = $('.formSearchStudent .keywords').val();
            var _url = '/index.php/view/student/lists?keyword='+value+'&p=' + $(this).attr('data-ele');
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
})
