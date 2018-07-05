var gulp 			= require('gulp');
var concat 			= require('gulp-concat');// for bundling complied css/js
var sass 			= require('gulp-sass');//for sass/scss compling
var browserSync 	= require('browser-sync').create(); //for Real-time browser sync


//SCSS task
gulp.task('sass', function(){
	return gulp.src(['public/assets/scss/style.scss'])
	.pipe( concat('style.css') )
	.pipe( sass({outputStyle: 'compact'}).on('error', sass.logError) )
	.pipe( gulp.dest('public/css') )
	.pipe(browserSync.reload({
    	stream: true
    }))

    ;
});


//browser-sync task
/*
gulp.task('browser-sync', function() {
    browserSync.init({
        server: {
            baseDir: "./"
        }
    });
});
*/

gulp.task('browserSync', function() {
    browserSync.init({
        proxy: "localhost/valuebranddesign",
		browser: 'chrome'
    });
});


//Watch task
gulp.task('watch', ['browserSync', 'sass'], function(){
	//will look any change on sass/scss file and auto change without reload
	gulp.watch('public/scss/**/*.scss', ['sass']);

	// Reloads the browser whenever HTML or JS files change
	gulp.watch('public/assets/**/*.php', browserSync.reload);
	gulp.watch('public/assets/js/**/*.js', browserSync.reload);
  ; 
});