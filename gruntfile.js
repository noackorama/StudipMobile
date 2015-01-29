module.exports = function (grunt) {
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-compress');

    var browserifyFiles = {
        './public/javascripts/bundle/page_calendar.js':
        ['./public/javascripts/page_calendar.coffee'],
        './public/javascripts/bundle/page_mails_show.js':
        ['./public/javascripts/page_mails_show.coffee'],
        './public/javascripts/bundle/page_mails_compose.js':
        ['./public/javascripts/page_mails_compose.coffee']
    };

    var lessFiles = ['./public/stylesheets/*.less'];

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        less: {
            development: {
                options: {
                    paths: ['public/stylesheets'],
                    sourceMap: true
                },
                files: {
                    'public/stylesheets/mobile.css': 'public/stylesheets/mobile.less',
                    'public/stylesheets/studip.css': 'public/stylesheets/studip.less'
                }
            },
            production: {
                options: {
                    paths: ['public/stylesheets'],
                    cleancss: true
                },
                files: {
                    'public/stylesheets/mobile.css': 'public/stylesheets/mobile.less',
                    'public/stylesheets/studip.css': 'public/stylesheets/studip.less'
                }
            }
        },

        browserify: {
            development: {
                files: browserifyFiles,
                options: {
                    transform: ['coffeeify'],
                    debug: true
                }
            },
            production: {
                files: browserifyFiles,
                options: {
                    transform: ['coffeeify'],
                    debug: false
                }
            }
        },

        watch: {
            files: [
                'public/javascripts/*.coffee',
                'public/javascripts/*.js',
                'public/stylesheets/*.less'
            ],
            tasks: ['build']
        },

        // Clean the build folder
        clean: {
            build: {
                src: ['build/', '<%= pkg.name %>.zip']
            }
        },

        copy: {
            build: {
                src: ['**', '!node_modules/**', '!gruntfile.js', '!package.json', '!.git*', '!*.org'],
                dest: 'build/'
            }
        },

        // Compress the build folder into an upload-ready zip file
        compress: {
            build: {
                options: {
                    mode: 'zip',
                    archive: '<%= pkg.name %>.zip'
                },
                cwd: 'build/',
                src: ['**/*']
            }
        }
    });

    grunt.registerTask('build', ['browserify:development', 'less:development']);
    grunt.registerTask('dist',  ['clean:build', 'browserify:production', 'less:production', 'copy:build', 'compress:build']);
};
