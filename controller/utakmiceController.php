<?php

class utakmiceController Extends baseController {

	/**
	 * Return HTML content
	 *
	 * @param $action string format: id/edit or id/delete
	 * @see baseController::display()
	 */
	public function display($action) {
		
		$content = '';
		$this->register->template->lige = $this->get_lige();
		$this->register->template->sezone = $this->get_sezone();
		$content = $this->register->template->load_template('utakmica');

		if (isset($_POST['sacuvaj_utakmicu'])) {
		  $this->save($_POST);
		}
		
		return $content;
	}
	
	public function get_lige() {
		$result = array();
		if (!$res = $this->register->db_conn->query("SELECT sifra_lige, naziv_lige FROM lige")) {
			$this->register->infos->set_error($this->register->db_conn->connect_error);
		}
		else { 
		  while ($row = $res->fetch_assoc()) {
			  $result[] = array(
			    'sifra_lige' => $row['sifra_lige'],
			    'naziv_lige' => $row['naziv_lige'],
			  );
			}
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
	
	private function save($post) {
	  include_once 'model/utakmica.model.php';
	  $utakmica = new utakmicaModel($this->register);
	  $utakmica->save($post);
	}
}