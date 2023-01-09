'use strict';

const CONFIG = require('../gulp.config');

const gulp = require('gulp');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const webpackStream = require('webpack-stream');
const webpack = webpackStream.webpack;
const path = require('path');
const named = require('vinyl-named');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const AssetsPlugin = require('assets-webpack-plugin');

module.exports = (callback) => {
	let firstBuildReade = false;

	function done(err, stats) {
		firstBuildReade = true;
		if (err) {
			return;
		}
		gulplog[stats.hasErrors() ? 'error' : 'info'](stats.toString({
			colors: true
		}));
	}

	let options = {
		mode: CONFIG.isDev ? 'development' : 'production',
		output: {
			publicPath: CONFIG.DIST.JS,
			filename: CONFIG.isDev ? '[name].js' : '[name]-[chunkhash:10].js'
		},
		watch: CONFIG.isWatch,
		devtool: CONFIG.isDev ? 'cheap-module-inline-source-map' : false,
		module: {
			rules: [
				{
					test: /\.js$/, use: {
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env']
						}
					}
				}
			]
		},
		plugins: [
			new webpack.NoEmitOnErrorsPlugin(),
			new webpack.ProvidePlugin({
				$: 'jquery',
				jQuery: 'jquery',
				"window.jQuery": "jquery"
			})
		]
	};

	if (!CONFIG.isDev) {
		options.plugins.push(new AssetsPlugin({
			filename: CONFIG.MANIFEST.WEBPACK,
			path: CONFIG.MANIFEST.PATH,
			processOutput(assets) {
				for (let key in assets) {
					assets[key + '.js'] = assets[key].js.slice(options.output.publicPath.length);
					delete assets[key];
				}
				return JSON.stringify(assets)
			}
		}));

		options.plugins.push(new UglifyJsPlugin(
				{
					uglifyOptions: {
						output: {
							comments: false,
							beautify: false,
						}
					}
				}
		));
	}

	return gulp.src(CONFIG.SRC.JS)
			.pipe(plumber({
				errorHandler: notify.onError(err => ({
					title: 'webpack',
					message: err.message
				}))
			}))
			.pipe(named())
			.pipe(webpackStream(options))
			.pipe(gulp.dest(CONFIG.DIST.JS))
			.on('data', () => {
				if (firstBuildReade) {
					callback();
				}
			});
};
