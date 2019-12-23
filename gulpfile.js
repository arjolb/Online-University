let gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync'),
    webpack = require('webpack'),
    modernizr = require('gulp-modernizr');

let themeLocation = './wp-content/themes/online-university/';

function styles(){
    return gulp.src(themeLocation+'css/style.scss')
    .pipe(sass().on('error',sass.logError))
    .pipe(autoprefixer())
    .pipe(gulp.dest(themeLocation));
}

function cssInject(){
    return gulp.src(themeLocation+'style.css')
    .pipe(browserSync.stream());
}

let cssInjection = gulp.series(styles,cssInject);

function scripts(cb) {
    webpack(require('./webpack.config.js'),function (err,stats) { 
        if (err) {
            console.log(err.toString());
          }

          console.log(stats.toString());
          cb();
    });
}

function modernizrFn() {
    return gulp.src([themeLocation+'css/**/*.scss',themeLocation+'js/**/*.js'])
    .pipe(modernizr({
        'options' : ['setClasses']
    }))
    .pipe(gulp.dest(themeLocation+'js/Vendor'));
}

function scriptsRefresh(cb) {
    browserSync.reload();
    cb();
}

let jsInjection = gulp.series(modernizrFn,scripts);

function watch() {
    browserSync.init({
        notify : false,
        proxy : 'http://localhost/online-university'
    });

    gulp.watch(themeLocation+'css/**/*.scss',cssInjection);

    gulp.watch(themeLocation+'**/*.php',function (cb) { 
        browserSync.reload();
        cb();
    });

    gulp.watch(themeLocation+'js/**/*.js',scriptsRefresh);
}

gulp.task('modernizr',jsInjection);

gulp.task('default',watch);