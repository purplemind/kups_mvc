<?php

class utakmiceController Extends baseController {

	/**
	 * Return HTML content
	 *
	 * @param $action string format: id/edit or id/delete
	 * @see baseController::display()
	 */
	public function display($action) {
		
		include_once 'model/utakmica.model.php';
		$utakmica = new utakmicaModel($this->register);

		$action_parts = explode('/', $action);	
		if (count($action_parts) > 1) {
			$this->register->template->id = $action_parts[0];
			$this->register->template->akcija = $action_parts[1];
			if ($action_parts[1] == 'edit') {
				$sudija->get_sudija($action_parts[0]);
			}
		}
		else {
			$this->register->template->akcija = 'add';
		}
		
		$content = '';
		$this->register->template->lige = $this->get_lige();
		$this->register->template->sezone = $this->get_sezone();
		$this->register->template->utakmica = $utakmica;
		if (isset($_POST['step'])) {
			switch($_POST['step']) {
				case 1:
					$this->register->template->steps_before = 1;
					
					$this->register->template->first_step = $utakmica->set_first_step($_POST);
					$content = $this->register->template->load_template('utakmice');
					$content .= $this->register->template->load_template('utakmice_klubovi');
					//$this->register->template->utakmica = new Utakmica; set first step values	
					break;
				case 2:
					print_r($_POST);
					break;
			}
		}
		else {
			$this->register->template->steps_before = 0;
			$content = $this->register->template->load_template('utakmica');
		}
		
		//load template and return content:
		/*
		try {
			$content = $this->register->template->load_template('utakmice');
		} catch (Exception $e) {
			$this->register->infos->set_error($e->getMessage());
		}
		*/
		
		return $content;
	}
	
	public function get_lige() {
		$result = NULL;
		if (!$result = $this->register->db_conn->query("SELECT * FROM lige")) {
			$this->register->infos->set_error($this->register->db_conn->connect_error);
		}
		return $result;
	}
	
	public function get_klubovi($liga, $ajax = FALSE) {
		$res = $this->register->db_conn->query('SELECT sifra_kluba, naziv_kluba FROM klubovi WHERE sifra_lige = "' .$liga .'"');
	  if ($ajax === FALSE) {
		  return $res;
	  }
	  else {
	    $result = array();
	    while ($row = $res->fetch_assoc()) {
	      $result[] = array(
	        'sifra_kluba' => $row['sifra_kluba'],
	        'naziv_kluba' => $row['naziv_kluba'],
	      );
	    }
	    return $result;
	  }
	}
	
	public function get_sezone() {
		$result = NULL;
		if (!$result = $this->register->db_conn->query("SELECT godina_sezone FROM sezona")) {
			$this->register->infos->set_error($this->register->db_conn->connect_error);
		}
		return $result;
	}
}