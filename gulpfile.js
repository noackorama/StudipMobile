var gulp   = require('gulp'),
    less   = require('gulp-less'),
    minify = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    zip    = require('gulp-zip'),
    notify = require("gulp-notify"),

    underscore = require("underscore"),

    browserify   = require('browserify'),
    watchify     = require('watchify'),
//    partition    = require('partition-bundle'),
    source       = require('vinyl-source-stream');

var environment = 'debug';

var paths = {
    scripts: {
        "./public/javascripts/mail_view.js": "MailView"
    },
    styles: ['./public/stylesheets/*.less']
};


var handleErrors = function() {
    var args = Array.prototype.slice.call(arguments);
    // Send error to notification center with gulp-notify
    notify.onError({
        title: "Compile Error",
        message: "<%= error.message %>"
    }).apply(this, args);
    // Keep gulp from hanging on this task
    this.emit('end');
};

gulp.task('default', ['less']);

gulp.task('less', function() {
    // place code for your default task here
    return gulp.src(paths.styles)
        .pipe(less()).pipe(gulp.dest('css'))
        .pipe(minify())
        .pipe(concat('studipmobile.min.css'))
        .pipe(gulp.dest('./public/stylesheets'));
});

/*
gulp.task('browserify', function(){

    // browserify page_mails_index.js page_mails_show.js -p [ factor-bundle -o bundle/page_mails_index.js -o bundle/page_mails_show.js ] -o bundle/common.js

    var bundle = browserify({
        entries: ['./public/javascripts/page_mails_index.js', './public/javascripts/page_mails_show.js'],
        extensions: ['.coffee'],
        debug: true
    });

    //browserify -p [ partition-bundle --map mapping.json --output output/directory --url directory ]

    bundle.plugin(partition, {
        map: "mapping.json",
        output:
        o: ['bundle/page_mails_index.js', 'bundle/page_mails_show.js']
    });

    // Create Write Stream
    var dest = fs.createWriteStream('./public/javascripts/bundle/common.js');

    bundle.bundle().pipe(source('./common.js')).pipe(gulp.dest('/tmp'));
    // Bundle
    //var stream = bundle.bundle().pipe(dest);

    /*
    return browserify({
        entries: ['.public/javascripts/page_mails_index.js', '.public/javascripts/page_mails_show.js']
    })
    .plugin(factor, {
        // File output order must match entry order
        o: ['bundle/page_mails_index.js', 'bundle/page_mails_show.js']
    })
    .bundle({
        debug: true
    })
    .pipe(source('common.js'))
    .pipe(gulp.dest('bundle'));
});
*/

gulp.task('browserify', function () {

    var bundler = browserify({
        entries: ['./public/javascripts/page_mails_show.js'],
        debug: true
    });

    return bundler
        .bundle()
        .on('error', handleErrors)
        .pipe(source("page_mails_show.js"))
        .pipe(gulp.dest('./public/javascripts/bundle'));
});

gulp.task('zip', ['default'], function() {
    return gulp.src([
        'controllers/**',
        'helpers/**',
        'lib/**',
        'LICENSE',
        'migrations/**',
        'models/**',
        'plugin.manifest',
        'public/**',
        'README.md',
        'sql/**',
        'StudipMobile.php',
        'vendor/**',
        'views/**'
    ], { mark: true, cwdbase: true })
    .pipe(zip('studip-mobile.zip'))
    .pipe(gulp.dest('.'));
});

// Rerun the task when a file changes
gulp.task('watch', function() {
  gulp.watch(paths.styles, ['less']);
  //gulp.watch(paths.scripts, ['browserify']);
});
