'use strict';

const CONFIG = require('../gulp.config');

const gulp = require('gulp');
const newer = require('gulp-newer');


module.exports = () => {
	return gulp.src(CONFIG.SRC.ASSETS, {since: gulp.lastRun('assets')})
			.pipe(newer(CONFIG.DIST.ASSETS))
			.pipe(gulp.dest(CONFIG.DIST.ASSETS))
};
