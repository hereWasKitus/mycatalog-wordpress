const { src, dest, parallel, watch } = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
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

function js() {
  return src([
    'src/js/libs/products-search.js',
    'src/js/libs/custom-select.js',
    'src/js/libs/history-back.js',
    'src/js/libs/file-uploader.js',
  ])
    .pipe( concat('index.js') )
    .pipe( dest('src/js/') )
    .pipe( browserSync.stream() );
}

function startWatch() {
  watch(['**/*.php']).on('change', browserSync.reload);
  watch('src/js/libs/*.js', js);
  watch('src/scss/**/*.scss', scss);
}

exports.default = parallel(scss, js, browsersync, startWatch);