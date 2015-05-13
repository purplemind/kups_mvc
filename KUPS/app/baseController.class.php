<?php
Abstract Class baseController {

	/*
	 * @registry object
	*/
	protected $register;

	function __construct($registry) {
		$this->register = $registry;
	}

	/**
	 * @all controllers must contain an index method
	 */
	abstract function display($action);
}
?>