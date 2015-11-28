var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');
var order = require("gulp-order");
var util = require('gulp-util');
var gulpif = require('gulp-if');
var plumber = require('gulp-plumber');
var ulgify = require('gulp-uglify');





var config = {
    assetsDir: 'src/AppBundle/Resources/public/',
    sassPattern: 'scss/**/.scss',
    jsPattern: 'js/**/.scss',
    production: !!util.env.production,
    sourceMaps: !util.env.production,
    cssPath: this.assetsDir + "css",
    jsPath: this.assetsDir + "js"

};


gulp.task('sass', function() {
    gulp.src('src/AppBundle/Resources/public/scss/**/*.scss')
        .pipe(plumber())
        .pipe(gulpif(config.sourceMaps, sourcemaps.init()))
        .pipe(sass())
        .pipe(concat('app.css'))
        .pipe(gulpif(config.sourceMaps, sourcemaps.write('.')))
        .pipe(gulp.dest('src/AppBundle/Resources/public/css'));
});

gulp.task('minifycss', ['sass'], function() {
    gulp.src([
        'src/AppBundle/Resources/public/css/bootstrap.css',
        'src/AppBundle/Resources/public/css/bootstrap.cerulean.css',
        'src/AppBundle/Resources/public/css/app.css',
        ])
        .pipe(plumber())
        .pipe(concat('app.css'))
        .pipe(config.production ? minifyCSS() : util.noop())

        .pipe(gulp.dest('web/css'));
});

gulp.task('minifyjs', function() {
    gulp.src([
        'src/AppBundle/Resources/public/js/jquery-1.11.3.js',
        'src/AppBundle/Resources/public/js/bootstrap.js',
        'src/AppBundle/Resources/public/js/modernizr-mq.js',
        'src/AppBundle/Resources/public/js/app.js',
    ])
        .pipe(plumber())
        .pipe(concat('app.js'))
        .pipe(config.production ? ulgify() : util.noop())
        .pipe(gulp.dest('web/js'));
});

gulp.task('watch', function() {
    gulp.watch('src/AppBundle/Resources/public/scss/**/*.scss', ['minifycss']);
    gulp.watch('src/AppBundle/Resources/public/css/**/*.css', ['minifycss']);
    gulp.watch('src/AppBundle/Resources/public/js/**/*.js', ['minifyjs']);

});

gulp.task('default', ['minifycss', 'minifyjs', 'watch']);

