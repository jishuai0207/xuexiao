define(function(require,exports){
    $.ajax({
        url:'/index.php/schedule/uploadstep1?classId='+$('.uploadScheduleInfo').attr('classid')+'&fileMd5='+$('.uploadScheduleInfo').attr('filemd5'),
    dataType:'json',
    type:'get',
    success:function(json){
        if(json.data.msg_count==0){
        $('.wrongArea').addClass("undis");
        }
        $('.wrongArea h2').html(json.msg);

        var _h = '',_t = '';
        $.each(json.data.list,function(a,b){
            if(b.isupdate==0){
            _h +='<a class="blueText" lesId="'+b.lessonId+'" href="#c_'+ b.lessonId +'">'+b.lessonName+'</a>';
            }
        });
        $('.wrongArea span.wongSu').html(_h);
        exports.temp(json);

        if(json.status == 0){
            $('.entryBox .subs').addClass('grey').removeClass('subs');
        }else if(json.status == -1){
            window.location.href = json.data.url;
        }else{
            $('.entryBox .grey').removeClass('grey').addClass('subs');
        }
    }
    });

    // 分页渲染函数
    exports.temp = function(json){
        // 定义模版
        var source = '<table cellspacing="0" cellpadding="0" border="0"><tr><th>讲次</th><th>课节名称</th><th>上课时间</th><th>任课老师</th></tr>{{each list as value i}}{{if value.isupdate == 0}}<tr class="pink" id="c_{{value.lessonId}}">{{else}}<tr id="c_{{value.lessonId}}">{{/if}}<td class="num">{{value.num}}</td><td class="name">{{value.lessonName}}</td><td class="time">{{if value.datetime== "信息无效"}}<em class="red">{{value.datetime}}</em>{{else}}{{value.datetime}}{{/if}}</td><td class="teacher">{{if value.teacherName == "信息无效"}}<em class="red">{{value.teacherName}}</em>{{else}}<a href="{{value.teacherUrl}}" target="_blank" class="blueText">{{value.teacherName}}</a>{{/if}}</td></tr>{{/each}}</table>';
        // 渲染
        var render = template.compile(source);
        // 临时保存数据
        var html = render({
            list:json.data.list
        });
        // 填充页面
        $('.wrongAreaList').html(html);
    }
})
