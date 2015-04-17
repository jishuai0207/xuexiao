define(function(require,exports){
    $.ajax({
        url:'/index.php/teacher/checkStep2?&fileMd5='+$('.uploadTeacherInfo').attr('filemd5'),
    dataType:'json',
    type:'get',
    success:function(json){
        $('#total').html(json.data.total);
        $('#normal').html(json.data.normal);
        $('#errNum').html(json.data.errNum);

        exports.temp(json);

        if(json.status == 0){
            $('.entryBox .subs').addClass('grey').removeClass('subs');
        }else if(json.status == -1){
            window.location.href = json.data.url;
        }else{
            $('.entryBox .grey').removeClass('grey').addClass('subs');
        }

        if(json.data.errNum == 0){
            $('.problems').addClass('undis');
        }

        $('.page .pageContent').html(json.data.page);
        $('.page').delegate('.pageContent a','click',function(){
            if($(this).attr('class') == 'active'){return false};
            var _url = '/index.php/teacher/checkStep2?&p=' + $(this).attr('data-ele')+'&fileMd5='+$('.uploadTeacherInfo').attr('filemd5');
            $.ajax({
                url:_url,
                type:'get',
                dataType:'json',
                success:function(json){
                    $('.page .pageContent').html(json.data.page);
                    if(json.status == -1){
                        window.location.href = json.data.url;
                    }else{
                        $('.page .pageContent').html(json.data.page);
                        // 渲染模版函数
                        exports.temp(json);
                    }
                }
            })
        })
    }
    });

    // 分页渲染函数
    exports.temp = function(json){
        // 定义模版
        var source = '<table cellspacing="0" cellpadding="0" border="0"><tr><th>信息所在行</th><th>真实姓名</th><th>问题</th></tr>{{each list as value i}}<tr><td>第{{i}}行</td><td>{{value.name}}</td><td>{{if value.type == 1}}<span class="red">{{value.checkinfo}}</span>{{/if}}{{if value.type == 2}}<span class="red">{{value.checkinfo}}</span>{{/if}}{{if value.type == 3}}<span class="red">{{value.checkinfo}}</span>{{/if}}</td></tr>{{/each}}</table>';
        // 渲染
        var render = template.compile(source);
        // 临时保存数据
        var html = render({
            list:json.data.err
        });
        // 填充页面
        $('.wrongAreaList').html(html);
    }
})

