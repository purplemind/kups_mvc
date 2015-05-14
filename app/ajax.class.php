<?php
class Ajax {
	public $is_ajax;
	public function __construct() {
		(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ?
			$this->is_ajax = true : $this->is_ajax = false;
	}
}
?>