module.exports = function (grunt) {
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    var browserifyFiles = {
        './public/javascripts/bundle/page_mails_show.js':
        ['./public/javascripts/page_mails_show.coffee'],
        './public/javascripts/bundle/page_mails_compose.js':
        ['./public/javascripts/page_mails_compose.coffee']
    };

    var lessFiles = ['./public/stylesheets/*.less'];

    grunt.initConfig({

        less: {
            development: {
                options: {
                    paths: ['public/stylesheets'],
                    sourceMap: true
                },
                files: {
                    'public/stylesheets/mobile.css': 'public/stylesheets/mobile.less'
                }
            },
            production: {
                options: {
                    paths: ['public/stylesheets'],
                    cleancss: true
                },
                files: {
                    'mobile.css': 'mobile.less'
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
        }
    });

    grunt.registerTask('build', ['browserify:development', 'less:development']);
    grunt.registerTask('dist',  ['browserify:production']);
};
