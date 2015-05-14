<?php

class ajaxController Extends baseController {

/**
 * Return HTML content
 *
 * @param $action string format: %controller/%method/%arg1/%arg2...
 * @see baseController::display()
 */
public function display($action) {
  $action_parts = explode('/', $action);
  $controller = $action_parts[0];
  $method = $action_parts[1];
  $arg_cnt = count($action_parts) - 2;
  $args = array();
  for ($i = 0; $i < $arg_cnt; $i++) {
    $args[$i] = $action_parts[$i + 2];
  }
  $content = array();
  $controller_path = $this->register->router->getPath() . '/' . $controller .'Controller.php'; 
  if (is_readable($controller_path)) {
    include_once $controller_path;
    $class = $controller . 'Controller';
    $obj = new $class($this->register);
    if (method_exists($obj, $method)) {
	    //$content = call_user_func($obj->$method, $args[0], TRUE);
	    $content = $obj->$method($args[0], TRUE);
    }
  }
  return json_encode($content);
}

}