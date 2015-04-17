请在新项目上线前,运行deploy/deploy.sh以进行一些初始化工作
操作步骤如下：
    1.对deploy/deploy.sh添加执行权限
    2.执行deploy/deploy.sh脚本
以上操作成功执行后：
    1.修改application/config/database.php文件中的以下配置：
       $db['default']['hostname'] = '数据库地址';  
       $db['default']['username'] = '数据库用户名';  
       $db['default']['password'] = '数据库连接密码';
       $db['default']['database'] = '数据库名称';
       $db['default']['port'] = '端口号';
更新工作所包含内容：
    1.压缩静态文件，并在static下创建online目录，而后删除原有的debug目录
    2.修改相关代码执行模式为线上模式
