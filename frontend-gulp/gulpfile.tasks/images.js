'use strict';

const CONFIG = require('../gulp.config');

const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const newer = require('gulp-newer');
const cache = require('gulp-cache');
const pngquant = require('imagemin-pngquant');


module.exports = () => {
	return gulp.src(CONFIG.SRC.IMG, {since: gulp.lastRun('images')})
			.pipe(newer(CONFIG.DIST.IMG))
			.pipe(
					cache(
							imagemin([
								imagemin.gifsicle({interlaced: true}),
								imagemin.jpegtran({progressive: true}),
								imagemin.svgo(),
								imagemin.optipng({optimizationLevel: 3}),
								pngquant({quality: '65-70', speed: 5})
							], {
								verbose: true
							})
					)
			)
			.pipe(gulp.dest(CONFIG.DIST.IMG))
};