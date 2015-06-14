<?php

class sudijaModel {
	
	private $register;
	
	public $sifra_sudije;
	public $ime;
	public $prezime;
	public $godina_pocetka;
	public $mesto_stanovanja;
	public $automobil;
	public $ne_ligama;
	public $ne_ekipama;
	public $za_komesara;
	
	private function init() {
		$this->sifra_sudije = '';
		$this->ime = '';
		$this->prezime = '';
		$this->godina_pocetka = date('Y');
		$this->mesto_stanovanja = '';
		$this->automobil = false;
		$this->ne_ligama = '';
		$this->ne_ekipama = '';
		$this->za_komesara = '';
	}
	
	public function __construct($register) {
		$this->register = $register;
		$this->init();
	}
	
	/**
	 * Check only required fields
	 * 
	 * @param array $post
	 * @return true|false
	 */
	private function required_fields_empty($post) {	
		$required = (array) $post['required'];
		foreach($required as $key => $value) {
			if ($value != 0 && empty($value)) {
				return 1;
			}
		}
		return 0;
	}
	
	/**
	 * Check if sifra contains 6 characters
	 * 
	 * @param string $sifra
	 */
	private function is_sifra_valid($sifra) {
		if (strlen($sifra) != 6) {
			$this->register->infos->set_error('Polje Šifra mora sadržati tačno 6 karaktera.');
			return 0;
		}
		return 1;
	}
	
	private function is_valid_alfanumeric($post) {
		$pattern = '/^[\w\p{L}\p{N}\p{Pd}\s\,\.\-_]+$/u';
		//$pattern = '/^[\w_\-\,\.\s]+$/';
		$ok = true;
		
		//check required fields:
		$required = (array) $post['required'];
		foreach($required as $key => $value) {
			if (!preg_match($pattern, $value)) {
				$this->register->infos->set_error('U polju ' . $key . ' su korišteni nedozvoljeni simboli.');
				$ok = false;
			}
		}
		
		//check other fields:
		foreach($post as $key => $value) {
			if ($key != 'required') {
				if (!empty($value) && !preg_match($pattern, $value)) {
					$this->register->infos->set_error('U polju ' . $key . ' su korišteni nedozvoljeni simboli.');
					$ok = false;
				}
			}
		}
		
		return $ok;
	}
	
	/**
	 * Check are fields empty or contain invalid characters
	 * 
	 * @param array $post
	 * @return boolean
	 */
	public function valid_data($post) {
		$required_empty = $this->required_fields_empty($post);
		$is_sifra_valid = $this->is_sifra_valid($post['required']['sifra_sudije']);
		$are_alphanumeric = $this->is_valid_alfanumeric($post);
		return !$required_empty && $is_sifra_valid && $are_alphanumeric;
	}
	
	public function get_all() {
		$result = NULL;
		if (!$result = $this->register->db_conn->query("SELECT * FROM sudije ORDER BY godina_pocetka")) {
			$this->register->infos->set_error($this->register->db_conn->connect_error);
		}
		return $result;
	}
	
	public function get_sudija($sifra) {
		if ($res = $this->register->db_conn->query('SELECT * FROM sudije WHERE sifra_sudije = "' .$sifra .'"')) {
			while ($row = $res->fetch_assoc()) {
				foreach($row as $key => $value) {
					$this->$key = $value;
				}
			}
			return 1;
		}
		return 0;
	}
	
	public function save($post) {
		$stmt = $this->register->db_conn->prepare('INSERT INTO sudije 
				(sifra_sudije, ime, prezime, godina_pocetka, mesto_stanovanja, automobil, ne_ekipama, ne_ligama, za_komesara)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('sssisisss', $post['required']['sifra_sudije'], $post['required']['ime'], $post['required']['prezime'],
				$post['required']['godina_pocetka'], $post['required']['mesto_stanovanja'], $post['required']['automobil'],
				$post['ne_ekipama'], $post['ne_ligama'], $post['za_komesara']);
		if (!$res = $stmt->execute()) {
			$this->register->infos->set_error($stmt->error);
		}
		return $res;
	}
	
	public function update($sifra, $post) {
		$stmt = $this->register->db_conn->prepare("UPDATE sudije SET
				sifra_sudije = ?, ime = ?, prezime = ?, godina_pocetka = ?, mesto_stanovanja = ?, automobil = ?,
				ne_ekipama = ?, ne_ligama= ?, za_komesara = ? WHERE sifra_sudije = ?");
		$stmt->bind_param('sssisissss', $post['required']['sifra_sudije'], $post['required']['ime'], $post['required']['prezime'],
				$post['required']['godina_pocetka'], $post['required']['mesto_stanovanja'], $post['required']['automobil'],
				$post['ne_ekipama'], $post['ne_ligama'], $post['za_komesara'], $sifra);
		if (!$res = $stmt->execute()) {
			$this->register->infos->set_error($stmt->error);
		}
		return $res;
	}
	
	public function delete($sifra) {
		$stmt = $this->register->db_conn->prepare("DELETE FROM sudije WHERE sifra_sudije = ?");
		$stmt->bind_param('s', $sifra);
		$res = $stmt->execute();
		$stmt->close();
		return $res;
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
		
	private static function get_all_na_utakmici($id_utakmice, $reg) {
	  $res = $reg->db_conn->query('SELECT id_podatka, sudija FROM pozicija_na_utakmici WHERE utakmica = ' .$id_utakmice);
	  $result = array();
	  while ($row = $res->fetch_assoc()) {
	    $result[$row['id_podatka']] = $row['sudija'];
	  }
	  return $result;
	}
	
	public static function save_sudije($id_utakmice, $sudije, $faulovi, $reg) {
	  include_once 'model/prekrsaj.model.php';
	  // all sudije already in database and check for changes:
	  $all_sudije = self::get_all_na_utakmici($id_utakmice, $reg);
	  foreach($sudije as $sifra_sudije => $pozicija_sudije) {
  	  if ($id_podatka = array_search($sifra_sudije, $all_sudije)) {
  	    // update sudija:
  	    $reg->db_conn->query('UPDATE pozicija_na_utakmici
  	      SET pozicija = "' .$pozicija_sudije .'" WHERE id_podatka = ' .$id_podatka);
  	    unset($all_sudije[$id_podatka]);
  	  }
  	  else {
  	    // save sudija:
  	    $stmt = $reg->db_conn->prepare('INSERT INTO pozicija_na_utakmici
    				(utakmica, sudija, pozicija) VALUES (?, ?, ?)');
  	    $stmt->bind_param('iss', $id_utakmice, $sifra_sudije, $pozicija_sudije);
  	    if ($stmt->execute()) {
  	      $reg->infos->set_error($stmt->error);
  	    }
  	    else {
  	      $reg->infos->set_info('Sudijske pozicije sacuvane.');
  	    }
  	  }
  	  // process the fouls:
  	  Prekrsaj::save_prekrsaji_sudije($id_utakmice, $sifra_sudije, $faulovi[$sifra_sudije], $reg);
	  }
	  if (!empty($all_sudije)) {
	    foreach($all_sudije as $id_podatka => $sifra_sudije) {
	      $reg->db_conn->query('DELETE FROM pozicija_na_utakmici WHERE id_podatka = ' .$id_podatka);
	      $req->db_conn->query('DELETE prekrsaji_utakmice, pregledanje_prekrsaja
	          FROM prekrsaji_utakmice
            INNER JOIN pregledanje_prekrsaja
            WHERE pregledanje_prekrsaja.id_prekrsaja = prekrsaji_utakmice.id_prekrsaja
            AND preksaji_utakmice.sudija = "' .$sifra_sudije .'"');
	    }
	  }
	}
	
}