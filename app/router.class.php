<?php
/**
 * The router class is responsible for loading up the correct controller.
 * It does nothing else.
 */
class Router {
	/*
	* @the registry
	*/
	private $registry;

	private $args = array();
	
	private $path;
	
	/**
	 * Path to the controller php file
	 * @var string
	 */
	public $file;

	/**
	 * Controller name, must be the same as php file name
	 * @var string
	 */
	public $controller;

	public $action;

	function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function setPath($path) {
		/*** check if path i sa directory ***/
		if (is_dir($path) == false)
		{
			throw new Exception ('Invalid controller path: `' . $path . '`');
		}
		/*** set the path ***/
		$this->path = $path;
	}
	
	public function getPath() {
	  return $this->path;
	}
	
	/**
	 * Return HTML content
	 * 
	 * @see Template::load_template()
	 *
	 * @load the controller
	 * @access public
	 * @return void
	 *
	 */
	public function loader()
	{
		/*** check the route and set vars: controller, action, file ***/
		$this->getControllerFile();
	
		/*** if the file is not there diaf ***/
		if (is_readable($this->file) == false)
		{
			echo $this->file;
			die ('404 Not Found');
		}
	
		/*** include the controller ***/
		include $this->file;
	
		/*** a new controller class instance ***/
		$class = $this->controller . 'Controller';
		$controller = new $class($this->registry); // all controllers have $registry variable
	
		/*** run the action ***/
		return $controller->display($this->action); // old v: $controller->$action() and before check if is callable 
	}
	
	/**
	 * Method that will decide which controller to load
	 * By the way: set $action if exists, otherwise set $action to 'index'
	 * Set $controller if exists, otherwise set $controller to 'index'
	 * Set $file to path of the seted controller
	 * 
	 * @get the controller
	 * @access private
	 * @return void
	 */
	private function getControllerFile() {
	
		/*** get the route from the url ***/
		$route = (empty($_GET['ruta'])) ? '' : $_GET['ruta'];
	
		if (empty($route))
		{
			$route = 'index';
		}
		else
		{
			/*** get the parts of the route ***/
			// route example: http://www.example.com/index.php?ruta=news => $parts[0] = 'news'
			$parts = explode('/', $route, 2);
			$this->controller = $parts[0];
			if(isset($parts[1]))
			{
				$this->action = $parts[1];
			}
		}
	
		if (empty($this->controller))
		{
			$this->controller = 'home';
		}
	
		/*** Get action ***/
		if (empty($this->action))
		{
			$this->action = 'add';
		}
	
		/*** set the file path ***/
		$this->file = $this->path .'/'. $this->controller . 'Controller.php';
	}
	
}
?>