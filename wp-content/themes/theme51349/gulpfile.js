// Load Gulp
var gulp = require('gulp'),
    gutil = require('gulp-util'),
    plugins = require('gulp-load-plugins')({
        rename: {
            'gulp-live-server': 'serve'
        }
    });

// Start Watching: Run "gulp"
gulp.task('default', ['watch']);

// Run "gulp server"
gulp.task('server', ['serve', 'watch']);

// Minify jQuery Plugins: Run manually with: "gulp squish-jquery"
// gulp.task('squish-jquery', function () {
//     return gulp.src('src/js/libs/**/*.js')
//         .pipe(plugins.uglify({
//             output: {
//                 'ascii_only': true
//             }
//         }))
//         .pipe(plugins.concat('jquery.plugins.min.js'))
//         .pipe(gulp.dest('js'));
// });

// Minify Custom JS: Run manually with: "gulp build-js"
// gulp.task('build-js', function () {
//     return gulp.src('src/js/*.js')
//         .pipe(plugins.jshint())
//         .pipe(plugins.jshint.reporter('jshint-stylish'))
//         .pipe(plugins.uglify({
//             output: {
//                 'ascii_only': true
//             }
//         }))
//         .pipe(plugins.concat('scripts.min.js'))
//         .pipe(gulp.dest('js'));
// });

// Less to CSS: Run manually with: "gulp build-css"
gulp.task('build-css', function () {
    return gulp.src('src/less/*.less')
        .pipe(plugins.plumber())
        .pipe(plugins.less())
        .on('error', function (err) {
            gutil.log(err);
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: [
                    '> 1%',
                    'last 2 versions',
                    'firefox >= 4',
                    'safari 7',
                    'safari 8',
                    'IE 8',
                    'IE 9',
                    'IE 10',
                    'IE 11'
                ],
            cascade: false
        }))
        .pipe(plugins.cssmin())
        .pipe(gulp.dest('css')).on('error', gutil.log);
});

// Default task
gulp.task('watch', function () {
    // gulp.watch('src/js/libs/**/*.js', ['squish-jquery']);
    // gulp.watch('src/js/*.js', ['build-js']);
    gulp.watch('*.less', ['build-css']);
});

// Folder "/" serving at http://localhost:8888
// Should use Livereload (http://livereload.com/extensions/)
gulp.task('serve', function () {
    var server = plugins.serve.static('/', 8888);
    server.start();
    gulp.watch(['css/*'], function (file) {
        server.notify.apply(server, [file]);
    });
});
