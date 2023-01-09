'use strict';

const gulp = require('gulp');
const _if = require('gulp-if');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const notify = require('gulp-notify');
const sass = require('gulp-sass');
const combine = require('stream-combiner2').obj;
const CONFIG = require('../gulp.config');
const rev = require('gulp-rev');
const cleanCSS = require('gulp-clean-css');
const gcmq = require('gulp-group-css-media-queries');


module.exports = () => {
	return combine(
			gulp.src(CONFIG.SRC.SASS),
			_if(CONFIG.isDev, sourcemaps.init()),
			sass(),
			autoprefixer(CONFIG.autoprefixer),
			_if(CONFIG.isDev, sourcemaps.write()),
			rev(),
			_if(!CONFIG.isDev, combine(gcmq(),cleanCSS(CONFIG.cleanCSS))),
			gulp.dest(CONFIG.DIST.SASS),
			combine(rev.manifest(CONFIG.MANIFEST.CSS), gulp.dest(CONFIG.MANIFEST.PATH)),
	).on('error', notify.onError());
};
