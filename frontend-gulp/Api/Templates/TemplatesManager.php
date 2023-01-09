<?php
/**
 * Author: Kovalev Taras
 * Author Email: taraswww777@mail.ru
 * Date: 22.07.2018 14:12
 */

namespace FrontendGulp\Api\Templates;

use Jenssegers\Blade\Blade;

class TemplatesManager
{
	public static $cachePath;
	public static $cachePathBlade;
	private $tplPath;

	public function __construct()
	{
		self::$cachePath = frontendGulpPath . '/.cache';
		self::$cachePathBlade = self::$cachePath . '/blade';
		$this->tplPath = frontendGulpPath . '/src/block';

		if (!frontendGulpBladeUseCache) {
			self::clearCache();
		}

		$this->mkDir(self::$cachePathBlade);
	}

	public static function clearCache()
	{
		if (!realpath(self::$cachePath)) return false;

		return self::recursiveClear(self::$cachePath, true);
	}

	private static function recursiveClear($path, $isCacheFolder = false)
	{
		$files = array_diff(scandir($path, SCANDIR_SORT_NONE), array('.', '..'));
		foreach ($files as $file) {
			(is_dir("$path/$file")) ? self::recursiveClear("$path/$file") : unlink("$path/$file");
		}
		if (!$isCacheFolder) {
			return rmdir($path);
		}

		return true;
	}


	public function mkDir($dir)
	{
		if (!@mkdir($dir, 0755, true) && !is_dir($dir)) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
		}
	}

	public function existsView( $view ) {
		$viewPathInfo = pathinfo( $view );
		$viewPath     = $this->tplPath . '/' . $view . '/' . $viewPathInfo['basename'] . '.blade.php';
		return file_exists( $viewPath );
	}

	/**
	 * @param string $view
	 * @param array $vars
	 */
	public function render($view, $context = [])
	{
		$viewPathInfo = pathinfo($view);
		$viewPath = $view . '/' . $viewPathInfo['basename'];

		$blade = new BladeCustom([$this->tplPath], self::$cachePathBlade);

		return $blade->make($viewPath, $context);
	}
}
