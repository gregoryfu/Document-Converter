/*
####################################################
####################################################
############## COPYRIGHT AARON M KENNY #############
###### CODE NOT TO BE USED WITHOUT PERMISSION ######
###### SEND REQUESTS TO AARONMKENNY@GMAIL.COM ######
####################################################
####################################################
*/

/*
####################################################
############### REQUIRE NPM MODULES ################
####################################################
*/

var gulp = require("gulp"),
    sass = require("gulp-ruby-sass"),
    autoprefixer = require("gulp-autoprefixer"),
    sourcemaps = require('gulp-sourcemaps'),
    rename = require("gulp-rename"),
    plumber = require("gulp-plumber"),
    uglify = require("gulp-uglify"),
    concat = require("gulp-concat");

/*
####################################################
##################### SETTINGS #####################
####################################################
*/


// Default JavaScript Action
// Value "JSMinify" Will Concatenate AND Minify all JavaScript Files
// Value "JSConcat" Will ONLY Concatenate JavaScript Files
var JSAction = "JSConcat";

// Default Task (Development)
gulp.task("default", ["styles", JSAction, "watch"]);
// Distribution build task
gulp.task("build", ["stylesProd", JSAction]);

/*
####################################################
######### SASS COMPILE TASK (DEVELOPMENT) ##########
####################################################
*/

gulp.task("styles", function(){
    return sass("app/assets/source_scss/styles.scss", {
        style: "compressed",
        cacheLocation: "temp/sass-cache",
        sourcemap: true
    })
    .on("error", function(err) {
        console.error("Error!", err.message);
    })
    .pipe(autoprefixer({
        browsers: ["> 1%"]
    }))
    .pipe(rename("styles.min.css"))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest("app/assets/css"));
});

/*
####################################################
######### SASS COMPILE TASK (DISTRIBUTION) #########
####################################################
*/

gulp.task("stylesProd", function(){
    return sass("app/assets/source_scss/styles.scss", {
        style: "compressed",
        cacheLocation: "temp/sass-cache"
    })
    .on("error", function(err) {
        console.error("Error!", err.message);
    })
    .pipe(autoprefixer({
        browsers: ["> 1%"]
    }))
    .pipe(rename("styles.min.css"))
    .pipe(gulp.dest("app/assets/css"));
});

/*
####################################################
########### SCRIPTS CONCATENATE & MINIFY ###########
####################################################
*/

gulp.task("JSMinify", function(){
  gulp.src(["app/assets/source_js/vendor/*.js", "app/assets/source_js/plugins/*.js", "app/assets/source_js/*.js"])
  .pipe(plumber())
  .pipe(uglify())
  .pipe(concat("scripts.min.js"))
  .pipe(gulp.dest("app/assets/js"));
});

/*
####################################################
############# SCRIPTS CONCATENATE ONLY #############
####################################################
*/

gulp.task("JSConcat", function(){
  gulp.src(["app/assets/source_js/vendor/*.js", "app/assets/source_js/plugins/*.js", "app/assets/source_js/*.js"])
  .pipe(plumber())
  .pipe(concat("scripts.js"))
  .pipe(gulp.dest("app/assets/js"));
});

/*
####################################################
################# GULP WATCH TASK ##################
####################################################
*/

gulp.task("watch", function(){
  gulp.watch(["app/assets/source_scss/**/*.scss"], ["styles"]);
  gulp.watch(["app/assets/source_js/**/*.js"], [JSAction]);
});
