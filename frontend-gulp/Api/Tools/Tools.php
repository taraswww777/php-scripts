<?php
/**
 * Author: Kovalev Taras
 * Author Email: taraswww777@mail.ru
 * Date: 26.07.2018 23:44
 */

namespace FrontendGulp\Api\Tools;

use FrontendGulp\Api\FrontendGulp;
use stdClass;

abstract class Tools
{

	public static function clearParamString($str)
	{
		return trim(trim(trim($str, '"'), '\''));
	}

	public static function mkDir($dir)
	{
		if (!@mkdir($dir, 0755, true) && !is_dir($dir)) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
		}
	}

	public static function removeDir($path)
	{
		$files = array_diff(scandir($path, SCANDIR_SORT_NONE), array('.', '..'));
		foreach ($files as $file) {
			$fileName = $path . '/' . $file;
			(is_dir($fileName)) ? self::removeDir($fileName) : unlink($fileName);
		}
	}

	/**
	 * @param $template
	 * @param array $context
	 * @return mixed
	 */
	public static function render($template, $context = [])
	{
		return FrontendGulp::getInst()->render($template, $context);
	}

	/**
	 * @param string $point
	 * @return string
	 */
	public static function urlJs($point = 'index')
	{
		return FrontendGulp::getInst()->urlJs($point);
	}

	/**
	 * @param string $point
	 * @return string
	 */
	public static function urlCss($point = 'index')
	{
		return FrontendGulp::getInst()->urlCss($point);
	}

	/**
	 * @param array $array
	 * @return object
	 */
	public static function arrToObj( $array = [] ) {
		$obj = new stdClass;
		foreach ( $array as $k => $v ) {
			if ( strlen( $k ) ) {
				if ( is_array( $v ) ) {
					$obj->{$k} = Tools::arrToObj( $v ); //RECURSION
				} else {
					$obj->{$k} = $v;
				}
			}
		}

		return $obj;
	}

	public static function existsView( $view ) {
		return FrontendGulp::getInst()->existsView( $view );
	}
}