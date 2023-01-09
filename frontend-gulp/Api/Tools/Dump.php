<?php
/**
 * Author: Kovalev Taras
 * Author Email: taraswww777@mail.ru
 * Date: 22.07.2018 22:04
 */

namespace FrontendGulp\Api\Tools;

class Dump
{
	/**
	 * Служебная ф-я, подготавливает данные к выводу
	 *
	 * @param null $var
	 * @param bool $isP
	 * @param string $style
	 * @param null $title
	 */
	public static function xPrint($var = null, $isP = true, $style = '', $title = null)
	{
		if ($isP) {
			ob_start();
			print_r($var);
			$info = ob_get_clean();
		} else {
			ob_start();
			var_dump($var);
			$info = ob_get_clean();
		}
		if (PHP_SAPI === 'cli') {
			echo "----------[ $title[0]  $title[1] ]----------\n$info\n----------------------------------------\n";
		} else {
			echo $style, '<div class="xPrintWrapper"><div class="xPrintTitle">' . '<span>' . $title[0] . '</span> ' . $title[1] . '</div>
										<pre>' . $info . '</pre>
										</div>';
		}
	}

	/**
	 * Служебная ф-я, собирает мета-данные данные
	 *
	 * @param null $title
	 * @return array
	 */
	private static function prepare($title = null)
	{
		ini_set('xdebug.var_display_max_depth', 50);
		ini_set('xdebug.var_display_max_children', 25600);
		ini_set('xdebug.var_display_max_data', 999999999);

		$debug_backtrace = self::whoCall(false);


		if (!empty($title)) {
			$sTitle[0] = "$title -> ";
			if (!$_SERVER['DOCUMENT_ROOT']) $sTitle[1] .= $debug_backtrace['file']; else {
				$sTitle[1] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $debug_backtrace['file']);
				if (strlen($sTitle[1]) == strlen($debug_backtrace['file'])) {
					$temp = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']);
					$sTitle[1] = str_replace($temp, '', $debug_backtrace['file']);
				}
			}
			$sTitle[1] .= ' :: ' . $debug_backtrace['line'];
		} else {
			if (!$_SERVER['DOCUMENT_ROOT']) $sTitle[1] = $debug_backtrace['file']; else {
				$sTitle[1] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $debug_backtrace['file']);
				if (strlen($sTitle[1]) == strlen($debug_backtrace['file'])) {
					$temp = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']);
					$sTitle[1] = str_replace($temp, '', $debug_backtrace['file']);
				}
			}
			$sTitle[1] .= ' :: ' . $debug_backtrace['line'];
		}
		$style = '
<style>.xPrintWrapper{color: #000;background: #f6f6f6;font-size: 14px;font-family: Areal, sans-serif;padding: 10px;margin: 0 15px 0 0;position: relative;top: 15px;border: 1px solid gray;width: 80%;z-index: 1000;}
.xPrintWrapper pre{white-space: pre!important;}
.xPrintWrapper .xPrintTitle{font-weight: bold;padding: 4px 0 4px 5px;color: #000;background: #dddddd;top: -15px;min-height: 15px;border: 1px solid gray;z-index: 1000;font-family: DialogInput , Monospaced, sans-serif;overflow: hidden;line-height: inherit;height: auto;}
.xPrintWrapper .xPrintTitle span{color: #fff;background: red;padding: 2px;margin: 0 3px 0 0;}
.xPrintWrapper pre{z-index: 1000;color: black;font-size: 14px;line-height: 1;white-space: pre}</style>
';
		return [
			't' => $sTitle,
			's' => $style,
		];
	}

	/**
	 * Распечатает дамп $var
	 * @param null $var
	 * @param bool $isP
	 * @param null $title
	 */
	public static function xp($var = null, $isP = true, $title = null)
	{
		$prepare = self::prepare($title);
		self::xPrint($var, $isP, $prepare['s'], $prepare['t']);
	}

	/**
	 * Распечатает дамп $var и выполнит exit
	 *
	 * @param null $var
	 * @param bool $isP
	 * @param null $title
	 */
	public static function xd($var = null, $isP = true, $title = null)
	{
		$prepare = self::prepare($title);
		self::xPrint($var, $isP, $prepare['s'], $prepare['t']);
		if (PHP_SAPI === 'cli') exit(__FILE__ . '::' . __LINE__); else
			exit('<p>' . __FILE__ . '::' . __LINE__ . '</p>');
	}

	/**
	 * Выведет дамп $var в файл
	 *
	 * @param null $var
	 * @param bool $isP
	 * @param string $file
	 * @param bool $rewrite
	 */
	public static function xf($var = null, $isP = true, $file = '/../logs/dump.txt', $rewrite = true)
	{
		if ($isP) {
			ob_start();
			print_r($var);
			$info = ob_get_clean();
		} else {
			ob_start();
			var_dump($var);
			$info = ob_get_clean();
		}
		$path = (!empty($_SERVER['DOCUMENT_ROOT'])) ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PWD'];
		$file = $path . $file;
		if (!@mkdir(dirname($file)) && !is_dir(dirname($file))) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', dirname($file)));
		}

		if ($rewrite) {
			file_put_contents($file, $info);
		} else {
			file_put_contents($file, $info, FILE_APPEND);
		}
	}

	/**
	 * @param bool $getPathInfo
	 * @param int $level
	 * @return string|array
	 */
	public static function whoCall($getPathInfo = true, $level = 2)
	{
		$res = debug_backtrace()[$level];
		if ($getPathInfo) {
			$res = "File: {$res['file']} Line: {$res['line']}";
		}
		return $res;
	}
}
