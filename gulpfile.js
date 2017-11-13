var gulp = require('gulp')
var webserver = require('gulp-webserver')
var sass = require('gulp-sass')
var minifyCSS = require('gulp-minify-css')

// scss to css
gulp.task('styles', function() {
  gulp.src('./sass/styles.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./public/css'))
})

// watch for changes
gulp.task('watch', function() {
  gulp.watch('./sass/**/*.scss', ['styles'])
  gulp.watch('./app/views/**/*.volt', ['public'])
})

// public build
gulp.task('public', ['styles'])

// default
gulp.task('default', ['watch', 'public'])
