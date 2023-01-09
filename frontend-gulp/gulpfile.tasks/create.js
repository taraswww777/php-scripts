'use strict';

const CONFIG = require('../gulp.config');
const argv = require('yargs').argv;
const gulp = require('gulp');
const replace = require('gulp-replace');
const rename = require('gulp-rename');
const mergeStream = require('merge-stream');

module.exports = () => {
	let blockName = (argv.b) ? argv.b : 'demo-block';
	let directory = (argv.d) ? argv.d : 'common';
	let path = `/block/${directory}/` + blockName;

	let streamSimple = gulp.src(CONFIG.SRC.PATH + '/block/blank/*.{css,less,sass,js,scss}')
			.pipe(replace('%block-name%', blockName))
			.pipe(rename({
				basename: blockName,
			}))
			.pipe(gulp.dest(CONFIG.SRC.PATH + path));

	let streamBlade = gulp.src(CONFIG.SRC.PATH + '/block/blank/*.php')
			.pipe(replace('%block-name%', blockName))
			.pipe(rename({
				basename: blockName,
				suffix: '.blade',
			}))
			.pipe(gulp.dest(CONFIG.SRC.PATH + path));
	console.log('[CONFIG.SRC.PATH + path]: ', CONFIG.SRC.PATH + path);
	return mergeStream(streamSimple, streamBlade)
};
