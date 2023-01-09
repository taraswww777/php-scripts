<?php
/**
 * Author: Kovalev Taras
 * Author Email: taraswww777@mail.ru
 * Date: 22.07.2018 13:52
 */


if (!defined('frontendGulpDistPath')) {
	// Абсолютный путь до дирректории frontend-gulp
	define('frontendGulpDistPath', '/dist');
}

if (!defined('frontendGulpPath')) {
	// Абсолютный путь до дирректории frontend-gulp
	define('frontendGulpPath', dirname(__DIR__));
}

if (!defined('frontendGulpPublicPath')) {
	// Абсолютный путь до публичной дирректории
	define('frontendGulpPublicPath', dirname(__DIR__));
}

if (!defined('frontendGulpPublicUrl')) {
	// путь от публичной дирректории до сгенерированных файлов

	if (defined('ABSPATH') and function_exists('get_theme_file_uri')) {
		define('frontendGulpPublicUrl', get_theme_file_uri() . '/assets/frontend-gulp' . frontendGulpDistPath);
	} else {
		define('frontendGulpPublicUrl', frontendGulpDistPath);
	}
}


if (!defined('frontendGulpBladeUseCache')) {
	// путь от публичной дирректории до сгенерированных файлов
	define('frontendGulpBladeUseCache', false);
}

if (!defined('frontendGulpBlockNamespace')) {
	define('frontendGulpBlockNamespace', '\FrontendGulp\Api\Templates\Bem\Block');
}

if (!defined('frontendGulpNamespace')) {
	define('frontendGulpNamespace', '\FrontendGulp\Api\FrontendGulp');
}

if (!defined('frontendGulpDumpNamespace')) {
	define('frontendGulpDumpNamespace', '\FrontendGulp\Api\Tools\Dump');
}
if (!defined('DEFAULT_CURRENCY')) {
    define('DEFAULT_CURRENCY', 'RUB');
}
