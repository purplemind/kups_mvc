<?php

class Info {
	
	private $errors;
	private $infos;

	public function __construct() {
		$this->errors = array();
		$this->infos = array();
	}
	
	public function set_info($value)
	{
		$this->infos[] = $value;
	}

	public function set_error($value)
	{
		$this->errors[] = $value;
	}
	
	public function has_errors() {
		return !empty($this->errors);
	}
	
	public function has_infos() {
		return !empty($this->infos);
	}
	
	public function print_errors() {
		foreach($this->errors as $values) {
			print $values .'<br />';
		}
	}
	
	public function print_infos() {
		foreach($this->infos as $values) {
			print $values .'<br />';
		}
	}
			
}