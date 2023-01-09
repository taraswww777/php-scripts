'use strict';

const argv = require('yargs').argv;
const path = require('path');

const PATH_SRC = './src';
const PATH_BASE_DIST = '/dist';

// в случае когда папка dist должна находиться в одной папке с  frontend-gulp
// const PATH_WEB_ROOT = './tests';
const PATH_WEB_ROOT = '.';

const PATH_DIST = PATH_WEB_ROOT + PATH_BASE_DIST;
const isWatch = argv.NODE_ENV === 'dev-watch';
const isDev = argv.NODE_ENV === 'dev' || isWatch;

const cleanCSS_level = {
	mergeAdjacentRules: true, // controls adjacent rules merging; defaults to true
	mergeIntoShorthands: true, // controls merging properties into shorthands; defaults to true
	mergeMedia: true, // controls `@media` merging; defaults to true
	mergeNonAdjacentRules: true, // controls non-adjacent rule merging; defaults to true
	mergeSemantically: false, // controls semantic merging; defaults to false
	mergeMediaQueries: true,
};

const config = {
	gulp_tasks: './gulpfile.tasks/',
	isDev: isDev,
	isWatch: isWatch,
	WATCH: {
		SASS: PATH_SRC + '/**/*.{sass,scss}',
		ASSETS: PATH_SRC + '/assets/**',
		IMG: PATH_SRC + '/img/**',
		JS: PATH_SRC + '/**/*.js'
	},
	SRC: {
		PATH: PATH_SRC,
		SASS: PATH_SRC + '/entry/*.{sass,scss}',
		ASSETS: PATH_SRC + '/assets/**',
		IMG: PATH_SRC + '/img/**',
		JS: PATH_SRC + '/entry/*.js',
	},

	DIST: {
		PATH: PATH_DIST,
		SASS: PATH_DIST + '/css',
		ASSETS: PATH_DIST + '/assets',
		IMG: PATH_DIST + '/img',
		JS: PATH_DIST + '/js',
	},
	browserSync: {
		baseDir: PATH_WEB_ROOT,
		watch: PATH_WEB_ROOT + '/**'
	},
	MANIFEST: {
		PATH: path.join(__dirname, PATH_WEB_ROOT + PATH_BASE_DIST + '/manifest'),
		CSS: 'css.json',
		WEBPACK: 'js.json',
	},
	WEBPACK: {
		include: 'frontend-gulp'
	},
	autoprefixer: {
		browsers: ['last 4 versions'],
		cascade: false
	},
	cleanCSS: {
		// https://github.com/jakubpawlowicz/clean-css#constructor-options
		debug: isDev,
		compatibility: 'ie7',
		level: {
			0: cleanCSS_level,
			1: cleanCSS_level,
			2: cleanCSS_level,
			3: cleanCSS_level,
		}
	}
};

module.exports = config;
