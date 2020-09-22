const { src, dest, parallel, watch } = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
// const cssnano = require('gulp-cssnano');
// const rename = require('gulp-rename');


function browsersync() {
  browserSync.init({
    proxy: "http://mycatalog.loc"
  });
}

function scss() {
  return src('src/scss/main.scss')
    .pipe( sass().on('error', sass.logError) )
    .pipe( dest('src/css') )
    .pipe( browserSync.stream() );
}

function startWatch() {
  watch(['src/js/**/*.js', '**/*.php']).on('change', browserSync.reload);
  watch('src/scss/**/*.scss', scss);
}

exports.default = parallel(scss, browsersync, startWatch);