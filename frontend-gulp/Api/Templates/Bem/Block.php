<?php

namespace FrontendGulp\Api\Templates\Bem;

class Block extends BemEntity
{

	/**
	 * Block constructor.
	 * @param string $name - имя блока
	 */
	public function __construct($name)
	{
		$this->setName($name);
	}

	/**
	 * @return string
	 */
	public function getBemName()
	{
		return $this->name;
	}

	/**
	 * Возврашает новый элемент текущего блока
	 * @param string $name
	 * @return Element
	 */
	public function elem($name)
	{
		return new Element($name, $this);
	}

}
