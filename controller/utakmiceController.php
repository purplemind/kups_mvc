<?php

class utakmiceController Extends baseController {

	/**
	 * Return HTML content
	 *
	 * @see baseController::display()
	 */
	public function display($action) {
		
		$content = '';
	  
		$args = explode('/', $action);
		$action = $args[0];
		
	  switch ($action) {	      
	    case 'filter':
	      $page = (isset($args[1])) ? $args[1] : 1;
	      $this->register->template->page = $page;
	      $this->register->template->lige = $this->get_lige();
	      $this->register->template->sezone = $this->get_sezone();
	      $filter_liga = isset($_POST['filter_liga']) ? $_POST['filter_liga'] : (isset($_GET['filter_liga']) ? $_GET['filter_liga'] : '0');
	      $filter_sezona = isset($_POST['filter_sezona']) ? $_POST['filter_sezona'] : (isset($_GET['filter_sezona']) ? $_GET['filter_sezona'] : '0');
        include_once 'model/utakmica.model.php';
        $utakmica = new utakmicaModel($this->register);
        $this->register->template->filter = true;
        if ($filter_sezona != '0' && $filter_liga != '0') {
          $this->register->template->selected_liga = $filter_liga;
          $this->register->template->selected_sezona = $filter_sezona;
          $this->register->template->utakmice =
            $utakmica->get_all_at_sezona_liga($filter_sezona, $filter_liga, 30 * ($page - 1), 30 * $page);
        }
        if ($filter_sezona != '0' && $filter_liga == '0') {
          $this->register->template->selected_sezona = $filter_sezona;
          $this->register->template->utakmice =
           $utakmica->get_all_at_sezona($filter_sezona, 30 * ($page - 1), 30 * $page);
        }
        if ($filter_sezona == '0' && $filter_liga != '0') {
          $this->register->template->selected_liga = $filter_liga;
          $this->register->template->utakmice =
           $utakmica->get_all_at_liga($filter_liga, 30 * ($page - 1), 30 * $page);
        }
      	if ($filter_sezona == '0' && $filter_liga == '0') {
          $this->register->template->utakmice = $utakmica->get_all(30 * ($page - 1), 30 * $page);
        }
	      $content = $this->register->template->load_template('filter_utakmice');
	      break;
	    
	    case 'edit':
	      include_once 'model/utakmica.model.php';
	      $utakmica = new utakmicaModel($this->register);
	      (isset($args[1])) ? $sifra_utakmice = $args[1] : $sifra_utakmice = 0;
	      if ($sifra_utakmice != 0) {
	        $utakmica->get_utakmica($sifra_utakmice);
	        $sudije = $utakmica->get_sudije();
	        $prekrsaji_sudije = array();
	        for ($i = 0; $i < count($sudije); $i++) {
	          $prekrsaji_sudije[$sudije[$i]['sudija']] = array();
	          $prekrsaji = $utakmica->get_prekrsaji_sudije($sudije[$i]['sudija']);
	          for ($j = 0; $j < count($prekrsaji); $j++) {
	            $prekrsaji_sudije[$sudije[$i]['sudija']][] = $prekrsaji[$j];
	          }
	        }
	        $this->register->template->utakmica = $utakmica;
	        $this->register->template->sudije = $sudije;
	        $this->register->template->prekrsaji_sudije = $prekrsaji_sudije;
	        $this->register->template->lige = $this->get_lige();
	        $this->register->template->sezone = $this->get_sezone();
	        $this->register->template->klubovi = $this->get_klubovi($utakmica->sifra_lige);
	        $this->register->template->all_sudije = $this->get_all_sudije();
	        $this->register->template->all_pozicije = $this->get_all_pozicije();
	        $this->register->template->all_faulovi = $this->get_all_faulovi();
	        $content = $this->register->template->load_template('edit_utakmice');
	      }
	      break;
	      
	    case 'add':
        $this->register->template->lige = $this->get_lige();
        $this->register->template->sezone = $this->get_sezone();
        $content = $this->register->template->load_template('add_utakmice');
         
        if (isset($_POST['sacuvaj_utakmicu'])) {
          $this->save($_POST);
        }	         
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
	
	public function get_utakmice_sudija($sudija, $sezona) {
	  $result = array();
	  
	  $res = $this->register->db_conn->query("SELECT utk.domacin, utk.gost, utk.sifra_utakmice
      FROM utakmice AS utk
      INNER JOIN pozicija_na_utakmici AS pnu ON pnu.utakmica = utk.sifra_utakmice
      WHERE pnu.sudija = '" . $sudija . "'
      AND utk.godina_sezone = " . $sezona ." 
      ORDER BY utk.godina_sezone DESC");
	   
    while($row = $res->fetch_assoc()) {
      $domacin = $this->register->db_conn->query("SELECT naziv_kluba FROM klubovi WHERE sifra_kluba='" .$row['domacin'] ."'");
      $domacin = $domacin->fetch_assoc();
      $gost = $this->register->db_conn->query("SELECT naziv_kluba FROM klubovi WHERE sifra_kluba='" .$row['gost'] ."'");
      $gost = $gost->fetch_assoc();
      $result[$row['sifra_utakmice']] = array (
      'sifra_utakmice' => $row['sifra_utakmice'],
      'domacin' => $domacin['naziv_kluba'],
      'gost' => $gost['naziv_kluba'],
      );
    }
	   
	  return $result;
	}
	
	public function get_prekrsaji_sudije($utakmica, $sudija) {
	  $result = array();
	  
	  $res = $this->register->db_conn->query("SELECT pu.id_prekrsaja, pu.sifra_faula, faulovi.naziv_faula
	      FROM prekrsaji_utakmice as pu
	      INNER JOIN faulovi ON faulovi.sifra_faula = pu.sifra_faula
	      WHERE sifra_utakmice = " . $utakmica .
	      " AND sudija = '" . $sudija . "'");
	  while ($row = $res->fetch_assoc()) {
	    $result[$row['id_prekrsaja']] = array (
	      'id_prekrsaja' => $row['id_prekrsaja'],
	      'sifra_faula' => $row['sifra_faula'],
	      'naziv_faula' => $row['naziv_faula'],
	    );
	  }
	  
	  return $result;
	}
	
	private function get_all_sudije() {
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
	
	private function get_all_pozicije() {
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
	
	private function get_all_faulovi() {
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
	
}