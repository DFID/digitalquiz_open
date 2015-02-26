var gulp        = require('gulp'),
    sass        = require('gulp-ruby-sass'),
    concat      = require('gulp-concat'),
    jshint      = require('gulp-jshint'),
    notify      = require('gulp-notify'),
    plumber     = require('gulp-plumber'),
    uglify      = require('gulp-uglify'),
    stripDebug  = require('gulp-strip-debug'),
    cssmin      = require('gulp-cssmin'),
    livereload  = require('gulp-livereload'),
    rename      = require("gulp-rename");

// Gulp plumber error handler
var onError = function(err) {
  console.log(err);
}

// Lets us type "gulp" on the command line and run all of our tasks
gulp.task('default', ['jshint', 'scripts', 'styles', 'watch']);

gulp.task('styles', function () {
  return gulp.src('./src/scss/app.scss')
    .pipe(sass({
      sourcemap: true,
      precision: 10,
      loadPath: [
        process.cwd() + '/bower_components/foundation/scss'
      ]
    }))
    // .pipe(sass({
    //   style: 'compressed',
    //   quiet: true,
    //   trace: true
    // }))
    // .pipe(sass({sourcemap: true, sourcemapPath: '../scss'}))
    .on('error', function (err) { console.log(err.message); })
    .pipe(cssmin())
    .pipe(gulp.dest('./dist/css'))
    .pipe(notify({ message: 'CSS task complete' }));
});

// Hint all of our custom developed Javascript to make sure things are clean
gulp.task('jshint', function() {
  return gulp.src('./src/scripts/*.js')
  .pipe(plumber({
    errorHandler: onError
  }))
  .pipe(jshint())
  .pipe(jshint.reporter('default'))
  .pipe(notify({ message: 'JS Hinting task complete' }));
});

gulp.task('scripts', function() {
  return gulp.src('./src/js/*.js')
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(rename('app.min.js'))
    .pipe(concat('app.min.js'))
    // .pipe(stripDebug())
    // .pipe(uglify())
    .pipe(gulp.dest('./dist/js/'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('watch', function() {
  livereload.listen();

	// Watch .scss files
  gulp.watch('src/scss/**/*.scss', ['styles']);

  // Watch JS
  gulp.watch('./src/js/**/*.js', ['jshint', 'scripts']);

  gulp.watch('dist/**/*').on('change', livereload.changed);

});