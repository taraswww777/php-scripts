'use strict';

const CONFIG = require('../gulp.config');

const browserSync = require('browser-sync').create();


module.exports = () => {
	browserSync.init({
		server: {
			baseDir: CONFIG.browserSync.baseDir
		}
	});

	browserSync.watch(CONFIG.browserSync.watch).on('change', browserSync.reload);
};
