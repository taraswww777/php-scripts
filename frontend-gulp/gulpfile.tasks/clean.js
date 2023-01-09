'use strict';

const CONFIG = require('../gulp.config');
const del = require('del');

module.exports = () => {
	console.info('[TASK Clean] Clear dir: ' + CONFIG.DIST.PATH);
	return del(CONFIG.DIST.PATH, {force: true})
};
