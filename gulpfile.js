var gulp = require('gulp')
var webserver = require('gulp-webserver')
var sass = require('gulp-sass')
var minifyCSS = require('gulp-minify-css')

// webserver
gulp.task('server', function() {
  gulp.src('./')
    .pipe(webserver({
      host: '0.0.0.0',
      port: 3000,
      livereload: true
    }))
})

// scss to css
gulp.task('styles', function() {
  gulp.src('./public/sass/styles.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./dist/css'))
})

// watch for changes
gulp.task('watch', function() {
  gulp.watch('./public/**/*.scss', ['styles'])
  gulp.watch('./*.html', ['public'])
})

// public build
gulp.task('public', ['styles'])

// default
gulp.task('default', ['server', 'watch', 'public'])
