<?php

class homeController Extends baseController {
	
	public function __construct($register) {
		parent::__construct($register);
	}
	
	public function display($content_name) {
		print 'Dobro došli';
	}
}