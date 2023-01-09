<?php
/**
 * Author: Kovalev Taras
 * Author Email: taraswww777@mail.ru
 * Date: 26.07.2018 23:32
 */

namespace FrontendGulp\Api\Templates;

use FrontendGulp\Api\Templates\Bem\Block;
use FrontendGulp\Api\Tools\Tools;
use Jenssegers\Blade\Blade;
use Psr\Container\ContainerInterface;

/**
 * Class BladeCustom
 * @package FrontendGulp\Api\Templates
 *
 * @property Block $block
 *
 * @method make(string $viewPath, array $context) Illuminate\Container\Container
 */
class BladeCustom extends Blade
{
	private $block;

	public function __construct($viewPaths, $cachePath, ContainerInterface $container = null)
	{
		parent::__construct($viewPaths, $cachePath, $container);
		$this->addDirectives();
	}

	private function addDirectives()
	{
		$this->addDirective_Block();
		$this->addDirective_BlockName();
		$this->addDirective_Elem();
		$this->addDirective_Dump();
		$this->addDirective_Img();
		$this->addDirective_Assets();
	}

	/**
	 * Add directive @block(block-name)
	 *
	 * directive return void
	 */
	private function addDirective_Block()
	{
		$this->compiler()->directive('block', function ($paramsString) {
			$params = explode(',', $paramsString);
			$block = (empty($params[0])) ? $params[0] : Tools::clearParamString($params[0]);
			$this->block = new Block($block);
		});
	}

	/**
	 * Add directive @blockName([modifier-name = null],[modifier-value = null])
	 *
	 * directive return string block-name[--modifier-name[_modifier-value]]
	 */
	private function addDirective_BlockName()
	{
		$this->compiler()->directive('blockName', function ($paramsString = null) {
			$params = explode(',', $paramsString);
			$modName = (empty($params[0])) ? $params[0] : Tools::clearParamString($params[0]);
			$modValue = (empty($params[1])) ? $params[1] : Tools::clearParamString($params[1]);

			$resultClass = (string)$this->block;
			if (!empty($modName) and !empty($modValue)) {
				$resultClass = (string)$this->block->addMod($modName, $modValue);
			} elseif (!empty($modName) and empty($modValue)) {
				$resultClass = (string)$this->block->addMod($modName);
			}
			return $resultClass;
		});
	}

	/**
	 * Add directive @elem(element-name,[modifier-name= null,[modifier-value= null]])
	 *
	 * directive return string  block-name__element-name[--modifier-name[_modifier-value]]
	 */
	private function addDirective_Elem()
	{
		$this->compiler()->directive('elem', function ($paramsString) {
			$params = explode(',', $paramsString);
			$nameElement = Tools::clearParamString($params[0]);
			$modName = (empty($params[1])) ? $params[1] : Tools::clearParamString($params[1]);
			$modValue = (empty($params[2])) ? $params[2] : Tools::clearParamString($params[2]);

			$resultClass = $this->block->elem($nameElement);
			if (!empty($nameElement) and !empty($modName) and !empty($modValue)) {
				$resultClass = $this->block->elem($nameElement)->addMod($modName, $modValue);
			} elseif (!empty($nameElement) and !empty($modName) and empty($modValue)) {
				$resultClass = $this->block->elem($nameElement)->addMod($modName);
			}
			return $resultClass;
		});

	}

	/**
	 * Add directive @dump(variable) or @xp(variable)
	 */
	private function addDirective_Dump()
	{
		$callback = function ($paramsString) {
			$phpCode = '<?php ' . frontendGulpDumpNamespace . '::xp(' . $paramsString . ') ?>';
			return $phpCode;
		};

		$this->compiler()->directive('dump', $callback);
		$this->compiler()->directive('xp', $callback);
	}

	/**
	 * Add directive @img(path to file relative to frontend-gulp/dist)
	 *
	 * directive return string path to Img
	 */
	private function addDirective_Img()
	{
		$this->compiler()->directive('img', function ($paramsString) {
			return frontendGulpPublicUrl . '/img' . Tools::clearParamString($paramsString);
		});

	}

	/**
	 * Add directive @assets(path to file relative to frontend-gulp/dist/assets)
	 *
	 * directive return string path to Assets
	 */
	private function addDirective_Assets()
	{
		$this->compiler()->directive('assets', function ($paramsString) {
			return frontendGulpPublicUrl . '/assets' . Tools::clearParamString($paramsString);
		});

	}
}
