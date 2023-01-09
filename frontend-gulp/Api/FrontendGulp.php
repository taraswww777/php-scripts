<?php

namespace FrontendGulp\Api;

use FrontendGulp\Api\Templates\TemplatesManager;
use FrontendGulp\Api\Tools\Dump;

require __DIR__ . '/config.php';


/**
 * Class FrontendGulp
 *
 */
class FrontendGulp
{
	private $manifest = [];
	private $pathManifest;
	private $templatesManager;
	private static $_instance;

	private function __construct()
	{
		$this->pathManifest = frontendGulpPublicPath . frontendGulpDistPath . '/manifest';
	}

	protected function __clone()
	{
	}

	public static function getInst()
	{
		if (null === self::$_instance) self::$_instance = new self();
		return self::$_instance;
	}

	private function loadManifest($typeManifest = 'css')
	{
		if (empty($this->manifest[$typeManifest])) {

			$path = $this->pathManifest . '/' . $typeManifest . '.json';
			if (file_exists($path)) {
				$this->manifest[$typeManifest] = json_decode(file_get_contents($path), true);
			} else {
				$this->manifest[$typeManifest] = [];
			}
		}
	}

	public function urlCss($point = 'index')
	{
		$typeManifest = 'css';
		$this->loadManifest($typeManifest);
		if (!empty($this->manifest[$typeManifest][$point . '.css'])) {
			$file = $this->manifest[$typeManifest][$point . '.css'];
		} else {
			$file = $point . '.css';
		}
		return frontendGulpPublicUrl . '/' . $typeManifest . '/' . trim(trim($file, '/'), '\\');
	}

	public function url($path = '')
	{
		return frontendGulpPublicUrl . '/' . trim(trim($path, '/'), '\\');
	}

	public function urlJs($point = 'index')
	{
		$typeManifest = 'js';
		$this->loadManifest($typeManifest);
		if (!empty($this->manifest[$typeManifest][$point . '.js'])) {
			$file = $this->manifest[$typeManifest][$point . '.js'];
		} else {
			$file = $point . '.js';
		}
		return frontendGulpPublicUrl . '/' . $typeManifest . '/' . trim(trim($file, '/'), '\\');
	}

	public function templates()
	{
		return $this->templatesManager ? $this->templatesManager : $this->templatesManager = new TemplatesManager();
	}

	public function existsView($view)
	{
		return $this->templates()->existsView($view);
	}

	public function render($template, $context = [])
	{
		return $this->templates()->render($template, $context);
	}
}
