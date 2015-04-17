module.exports = function (grunt) {

    var sourceDir = "../../static/debug";// 源码目录
    var buildDir = ".build";// 构建中间目录
    var finalDir = "../../static/online";// 最终打包目录

    var transport = require('grunt-cmd-transport');
    var style = transport.style.init(grunt);
    var script = transport.script.init(grunt);

    grunt.initConfig({
        // 检测js依赖
        transport: {
            options: {
                paths: [sourceDir],
                parsers: {
                    '.js': [script.jsParser],
                    '.css': [style.css2jsParser]
                },
                alias: {
                    'jquery':'lib/jquery/1.8.2/jquery',
                    'validform':'lib/validform/5.3.2/validform',
                    'dialog':'lib/artdialog/4.1.7/artDialog'
                }
            },
            build: {
                files: [
                    {
                        expand: true,
                        cwd: sourceDir,
                        src: ['module/**/*.js'],
                        dest: buildDir
                    }
                ]
            }
        },
        // 合并js
        concat: {
            options: {
                paths: [buildDir],
                include: 'all'
            },
            build: {
                files: [
                    {
                        expand: true,
                        cwd: buildDir,
                        src: ['**/**/*.js','!**/**/*-debug.js','!lib/*'],
                        dest: finalDir
                    }
                ]
            }
        },
        // 压缩js
        uglify: {
            options: {
                mangle: false
            },
            build: {
                files: [
                    {
                        expand: true,
                        cwd: finalDir,
                        src: ['**/**/*.js'],
                        dest: finalDir
                    }
                ]
            }
        },
        css_combo: {
            options: {
                debug: false,
                compress: true
            },
            build: {
                files: [
                    {
                        expand: true,
                        cwd: sourceDir,
                        src: ['**/**/style.css'],
                        dest: finalDir
                    }
                ]
            }
        },
        // 删除临时目录
        clean: {
            build: [buildDir]
        },
        //复制文件
        copy: {
            build: {
                expand: true,
                flatten: false,
                cwd: sourceDir,
                src: ['html/**/*','!module/**/*.js','lib/**/*','public/**/*'],
                dest: finalDir,
                filter: 'isFile'
            },
            image : {
                expand: true,
                flatten: false,
                cwd: sourceDir,
                src: ['images/**/*'],
                dest: finalDir,
                filter: 'isFile'
            },
            css : {
                expand: true,
                flatten: false,
                cwd: sourceDir,
                src: ['**/**/style.css'],
                dest: finalDir,
                filter: 'isFile'
            }
        }
    });

    // grunt.loadNpmTasks('cookies');
    grunt.loadNpmTasks('grunt-css-combo');
    grunt.loadNpmTasks('grunt-cmd-transport');
    grunt.loadNpmTasks('grunt-cmd-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('default', ['transport', 'concat', 'uglify', 'css_combo', 'clean', 'copy:build','copy:image']);

};
