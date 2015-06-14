<?php

class sudijeController Extends baseController {
	
	/**
	 * Return HTML content
	 * 
	 * @param $action string format: id/edit or id/delete
	 * @see baseController::display()
	 */
	public function display($action) {
		
		include_once 'model/sudije.model.php';
		$sudija = new sudijaModel($this->register);
		$this->register->template->sudija = $sudija;
		
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
		
		if (isset($_POST) && isset($_POST['submit-sudija']) && $sudija->valid_data($_POST)) {
								
			switch($_POST['akcija']) {
		
				case 'edit':
					if ($sudija->update($action_parts[0], $_POST)) {
						$this->register->infos->set_info('Podatak je uspešno promenjen.');
					}
					else {
						$this->register->infos->set_error('Podatak NIJE promenjen! Proverite unete podatke.');
					}
					break;
						
				case 'add':
					if ($sudija->save($_POST)) {
						$this->register->infos->set_info('Podatak je uspešno sačuvan.');
					}
					else {
						$this->register->infos->set_error('Podatak NIJE sačuvan! Proverite unete podatke.');
					}
					break;
			}
		}
		else {
			if (count($action_parts) > 1 && $action_parts[1] == 'delete') {
				//@todo: are you sure!!!
				if ($sudija->delete($action_parts[0])) {
					$paths = explode('?', $_SERVER['REQUEST_URI']);
					header('Location: ' . $paths[0] . '?ruta=sudije');
					exit();
					$this->register->infos->set_info('Podatak je obrisan.');
				}
				else {
					$this->register->infos->set_error('Podatak NIJE obrisan!');
				}
			}
		}
		
		//load template and return content:
	  $content = "";
		try {
			$content = $this->register->template->load_template('sudije');
		} catch (Exception $e) {
			$this->register->infos->set_error($e->getMessage());
		}
		
		return $content;
	}
	
	public function get_sudije() {
	  $res = $this->register->db_conn->query('SELECT sifra_sudije, ime, prezime FROM sudije');
    $result = array();
    while ($row = $res->fetch_assoc()) {
      $result[] = array(
        'sifra_sudije' => $row['sifra_sudije'],
        'ime_prezime' => $row['ime'] . ' ' . $row['prezime'],
      );
    }
    return $result;
	}
	
	private function get_sudijske_pozicije() {
	  return array(
	    'R'  => 'Referee',
	    'U'  => 'Umpire',
	    'HL' => 'Head Linesman',
	    'LJ' => 'Line Judge',
	    'SJ' => 'Side Judge',
	    'BJ' => 'Back Judge', 
	    'FJ' => 'Field Judge',
	  );
	}
	
	public function get_sudija_template($broj_sudije, $ajax = FALSE) {
	  $this->register->template->broj_sudije = $broj_sudije;
	  $this->register->template->sudije = $this->get_sudije();
	  $this->register->template->pozicije = $this->get_sudijske_pozicije();
	  return $this->register->template->load_template('sudija_na_utakmici');
	}
	
	private function get_all_prekrsaji() {
	  $res = $this->register->db_conn->query('SELECT sifra_faula, naziv_faula FROM faulovi');
	  $result = array();
	  while ($row = $res->fetch_assoc()) {
	    $result[] = array(
	    'sifra_faula' => $row['sifra_faula'],
	    'naziv_faula' => $row['naziv_faula'],
	    );
	  }
	  return $result;
	}
	
	public function prekrsaji_template($broj_sudije, $broj_prekrsaja, $ajax = FALSE) {
	  $this->register->template->prekrsaji = $this->get_all_prekrsaji();
	  $this->register->template->broj_sudije = $broj_sudije;
	  $this->register->template->broj_prekrsaja = $broj_prekrsaja;
	  return $this->register->template->load_template('spisak_prekrsaja');
	}
	
}