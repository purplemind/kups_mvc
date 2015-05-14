<?php

/**
 * The registry is an object where site wide variables can be stored without the
 * use of globals.
 */
Class Registry {
	
	private $vars = array();
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
}

?>