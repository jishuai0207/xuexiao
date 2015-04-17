define(function(require,exports){
    if($('#currentSchedule').length < 1){return false;}
    $.ajax({
        url:'/index.php/view/orgclass/schedule?classId='+$('.studentLists').attr('classid'),
        type:'get',
        dataType:'json',
        success:function(json){
            if(json.status == -1){
                window.location.href = json.data.url;
            }else{
                exports.temp(json);
                // 替换|为br
                exports.replaceFn();
                // 分页代码
                $('.page .pageContent').html(json.data.page);
                $('.page').delegate('.pageContent a','click',function(){
                    if($(this).attr('class') == 'active'){return false}
                    var _url = '/index.php/view/orgclass/schedule?classId='+$('.studentLists').attr('classid')+'&p=' + $(this).attr('data-ele');
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
                                // 替换|为br
                                exports.replaceFn();
                            }
                        }
                    })
                });
            }
        }
    });
    // 替换|为br
    exports.replaceFn = function(){
        $('.timeScheduleDate').each(function(){
           var _h = $(this).html().replace('|','<br />');
            $(this).html(_h);
            if($(this).html().search('<br>') < 0){
                $(this).parent().css('line-height','50px');
            }
        });
    }
    // 分页渲染函数
    exports.temp = function(json){
        var source = '<table border="0" cellspacing="0" cellpadding="0"><tr><th>讲次</th><th>课节名称</th><th>代课老师</th><th width="120"></th></tr>{{each list as value i}}<tr><td>{{value.num}}</td><td>{{value.lessonName}}</td><td><span class="replaceTruthName">{{value.replaceTruthName}}</span></td><td><div class="ctrl" replaceTruthName="{{value.replaceTruthName}}"><ul lessonid="{{value.lessonId}}">{{if value.replaceStatus == 0}}<li><a href="javascript:void(0)" class="blueText addSupplyTeacher">添加代课老师</a></li>{{else}}<li><a href="javascript:void(0)" class="blueText modifySupplyTeacher">修改代课老师</a></li><li><a href="javascript:void(0)" class="blueText delSupplyTeacher">删除代课老师</a></li>{{/if}}</ul></div></td></tr>{{/each}}</table>'
/*
		 var source = '<table border="0" cellspacing="0" cellpadding="0"><tr><th>讲次</th><th>课节名称</th><th>上课时间</th><th>任课老师</th><th>代课老师</th><th width="100"></th></tr>{{each list as value i}}<tr><td>{{value.num}}</td><td>{{value.lessonName}}</td><td><p class="timeScheduleDate">{{value.ScheduleDate}}</p></td><td>{{value.truthName}}</td><td><span class="replaceTruthName">{{value.replaceTruthName}}</span></td><td>{{if value.classStatus == 0}}<div class="ctrl" replaceTruthName="{{value.replaceTruthName}}"><ul lessonid="{{value.lessonId}}">{{if value.SecheduleReadyStatus == 1}}<li><a href="javascript:void(0)" class="blueText modifySchedule">修改排课</a></li>{{if value.replaceStatus == 0}}<li><a href="javascript:void(0)" class="blueText addSupplyTeacher">添加代课老师</a></li>{{else}}<li><a href="javascript:void(0)" class="blueText modifySupplyTeacher">修改代课老师</a></li><li><a href="javascript:void(0)" class="blueText delSupplyTeacher">删除代课老师</a></li>{{/if}} {{else}}<li><a href="javascript:void(0)" class="blueText startSchedule">排课</a></li>{{/if}}</ul></div>{{/if}}</td></tr>{{/each}}</table>';
		*/
            // 渲染
            var render = template.compile(source);
        // 临时保存数据
        var html = render({
            list:json.data.schedulelist
        });
        // 填充页面
        $('.currentScheduleShows').html(html);
        // 锚点方法
        require('module/classInfo/point');
    }
})
