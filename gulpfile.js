// Require All NPM Modules
var gulp = require("gulp"),
    sass = require("gulp-ruby-sass"),
    rename = require("gulp-rename"),
    plumber = require("gulp-plumber"),
    uglify = require("gulp-uglify"),
    concat = require("gulp-concat");

// Default JavaScript Action
// Value "JSMinify" Will Concatenate AND Minify all JavaScript Files
// Value "JSConcat" Will Only Concatenate JavaScript Files
var JSAction = "JSConcat";

// Default Task
gulp.task("default", ["styles", JSAction, "watch"]);

// SASS Compile Task
// Compile SASS and Move to CSS Folder
gulp.task("styles", function(){
  return sass("app/assets/source_scss/styles.scss", {
    "style": "compressed",
    "cacheLocation": "temp/sass-cache"
  })
  .on("error", function(err) {
    console.error("Error!", err.message);
  })
  .pipe(rename("styles.min.css"))
  .pipe(gulp.dest("app/assets/css"));
});

// Scripts Minify Task
// Minifies AND Concatenates JavaScript
gulp.task("JSMinify", function(){
  gulp.src(["app/assets/source_js/vendor/*.js", "app/assets/source_js/plugins/*.js", "app/assets/source_js/*.js"])
  .pipe(plumber())
  .pipe(uglify())
  .pipe(concat("scripts.min.js"))
  .pipe(gulp.dest("app/assets/js"));
});

// Script Concat ONLY Task
// Only Concatenates Files together To Save On Requests, And Avoids Issues With Minifying
gulp.task("JSConcat", function(){
  gulp.src(["app/assets/source_js/vendor/*.js", "app/assets/source_js/plugins/*.js", "app/assets/source_js/*.js"])
  .pipe(plumber())
  .pipe(concat("scripts.js"))
  .pipe(gulp.dest("app/assets/js"));
});

// Watch Task
// Run The Followings Tasks On Change
gulp.task("watch", function(){
  gulp.watch(["app/assets/source_scss/**/*.scss"], ["styles"]);
  gulp.watch(["app/assets/source_js/**/*.js"], [JSAction]);
});