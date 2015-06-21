<?php

class sezonaController Extends baseController {
	
	/**
	 * Return HTML content
	 * 
	 * @param $action string format: id/edit or id/delete
	 * @see baseController::display()
	 */
	public function display($action) {
		
		require_once __SITE_PATH . '/model/sezona.model.php';
		
		$sezona = new sezonaModel($this->register);
		
		$action_parts = explode('/', $action);
		$sezona = new sezonaModel($this->register);
		$this->register->template->sezona = $sezona;
		
		switch ($action_parts[0]) {
		  case 'add':
		    $this->register->template->akcija = 'add';
			  if (isset($_POST['submit-sezona'])) {
			    $sezona->save($_POST);
			  }
		    break;
		    
		  case 'edit':
			  $this->register->template->akcija = 'edit';
			  $godina = isset($action_parts[1]) ? $action_parts[1] : NULL;
			  $this->register->template->godina = $godina;
			  $this->register->template->sezona = $sezona->load_sezona($godina);
			  if (isset($_POST['submit-sezona'])) {
			    $sezona->update($_POST);
			  }
		    break;
		    
		  case 'delete':
			  $godina = isset($action_parts[1]) ? $action_parts[1] : NULL;
			  $this->register->template->godina = $godina;
			  $this->register->template->sezona = $sezona->load_sezona($godina);
			  if (isset($_POST['ajax_request'])) {
		      $this->register->template->akcija = 'add';
		      $sezona->delete($godina);
		      unset($this->register->template->sezona);
		    }
		    elseif (isset($_POST['submit-sezona'])) {
		     $sezona->delete($godina);
		    }
		    else {
		      $this->register->template->akcija = 'delete';		      
		    }
		    break;
		    
		  default:
		    die("Akcija koju želite da preduzemte nije predviđena");
		}

		return $this->register->template->load_template('sezona');
	}
	
}