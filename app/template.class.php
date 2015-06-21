<?php
Class Template {

	/*
	* @the registry
	* @access private
	*/
	private $registry;

	/*
	* @Variables array
	* @access private
	*/
	private $vars = array();

	/**
	 *
	 * @constructor
	 * @access public
	 * @return void
	 *
	*/
	function __construct($registry) {
		$this->registry = $registry;

	}

	/**
	 *
	 * @set undefined vars
	 * @param string $index
	 * @param mixed $value
	 *
	 * @return void
	 *
	 */
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}


	function load_template($name) {
		$path = __SITE_PATH . '/template' . '/' . $name . '.tpl.php';

		if (file_exists($path) == false)
		{
			throw new Exception('Template not found in '. $path);
			return false;
		}

		// Load variables
		foreach ($this->vars as $key => $value)
		{
			$$key = $value;
		}

		ob_start();
		include ($path);
		$content = ob_get_contents();
		include (__SITE_PATH . '/template/base_content.tpl.php');
		$content = ob_get_clean();
		return $content;
	}

}

?>