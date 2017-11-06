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
  gulp.src('./src/styles/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./dist/css'))
})

// watch for changes
gulp.task('watch', function() {
  gulp.watch('./src/**/*.scss', ['styles'])
  gulp.watch('./*.html', ['dist'])
})

// dist build
gulp.task('dist', ['styles'])

// default
gulp.task('default', ['server', 'watch', 'dist'])
