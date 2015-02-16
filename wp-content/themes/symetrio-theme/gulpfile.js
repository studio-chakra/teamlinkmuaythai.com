
// Include gulp
var gulp            = require('gulp');


// Include Our Plugins
var sass            = require('gulp-sass');
var minifycss       = require('gulp-minify-css');
var concat          = require('gulp-concat');
var uglify          = require('gulp-uglify');
var rename          = require('gulp-rename');
var browserSync     = require('browser-sync');
var reload          = browserSync.reload;


// Task: Sass
gulp.task('sass', function () {
    return gulp.src('assets/scss/app.scss')
        .pipe(sass({includePaths: ['assets/scss']}))
        // Catch any SCSS errors and prevent them from crashing gulp
        .on('error', function (error) {
            console.error(error);
            this.emit('end');
        })
        .pipe(gulp.dest('assets/css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('assets/css'))
        .pipe(reload({stream:true}));
});


// Task: Concatenate & Minify JS
// gulp.task('scripts', function() {
//     return gulp.src([
//         'bower_components/jquery/dist/jquery.js',
//         'vendor/jQueryMosaic/js/mosaic.1.0.1.js',
//         'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/collapse.js',
//         'bower_components/magnific-popup/dist/jquery.magnific-popup.js'
//         ])
//         .pipe(concat('vendor.js'))
//         .pipe(gulp.dest('js'))
//         .pipe(rename('vendor.min.js'))
//         .pipe(uglify())
//         .pipe(gulp.dest('js'));
// });


// Task: Browser Sync
gulp.task('browser-sync', function() {
    browserSync({
        proxy: "teamlinkmuaythai.dev",
        files: "assets/css/**"
        // reloadDelay: 5000
    });
});


// WATCH
gulp.task('default', ['sass', 'browser-sync'], function () {
    gulp.watch("assets/scss/**/*.scss", ['sass']);
});