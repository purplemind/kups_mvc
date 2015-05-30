<?php

class utakmicaModel {
	
	private $register;
	
	public $sifra_utakmice;
	public $godina_sezone;
	public $datum;
	public $sifra_lige;
	public $domacin;
	public $gost;
	public $domacin_golova;
	public $gost_golova;
	public $pregled;
	public $pregledana;

	private function init() {
		$this->godina_sezone = date('Y');
		$this->datum = time();
		$this->sifra_lige = '';
		$this->domacin = '';
		$this->gost = '';
		$this->domacin_golova = 0;
		$this->gost_golova = 0;
		$this->pregled = 0;
		$this->pregledana = 0;
	}
	
	public function __construct($register) {
		$this->register = $register;
		$this->init();
	}
	
	public function save($post) {
	  // @todo: Validate post
		$this->godina_sezone = $post['required']['godina_sezone'];
		$this->datum = DateTime::createFromFormat('d/m/Y', $post['required']['datum'])->format('Y-m-d');
		$this->sifra_lige = $post['required']['sifra_lige'];
		$this->domacin = $post['required']['domacin'];
		$this->domacin_golova = $post['required']['poena_domacin'];
		$this->gost = $post['required']['gost'];
		$this->gost_golova = $post['required']['poena_gost'];
		$this->pregled = $post['pregledanje'];
		$this->pregledana = 'nije';
		$broj_sudija = $post['broj_sudija'];
		$sudija = array();
		$prekrsaji = array(); // index - sudija ID, value - array of fouls
		for ($i = 1; $i <= $broj_sudija; $i++) {
		  $sudija[$post['required']['sudija_' . $i]] = $post['required']['pozicija_' . $i]; 
		  $broj_prekrsaja = $post['broj_prekrsaja_sudija_' . $i];
		  $prekrsaji[$post['required']['sudija_' . $i]] = array();
		  for ($j = 1; $j <= $broj_prekrsaja; $j++) {
		    // i - sudija, j - prekrsaj
		    $prekrsaji[$post['required']['sudija_' . $i]][] = $post['prekrsaj_' . $i . '_' . $j];
		  }
		}
		
		$stmt = $this->register->db_conn->prepare('INSERT INTO utakmice
				(godina_sezone, datum, sifra_lige, domacin, gost, domacin_ft_golova, gost_ft_golova, trazi_se_pregled, pregledana)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('issssiiis', $this->godina_sezone, $this->datum, $this->sifra_lige, $this->domacin, $this->gost,
		    $this->domacin_golova, $this->gost_golova, $this->pregled, $this->pregledana);
		if (!$res = $stmt->execute()) {
		  $this->register->infos->set_error($stmt->error);
		}
		else {
		  $this->register->infos->set_info('Podaci utakmice su sacuvani.');
		  $sifra_utakmice = $stmt->insert_id;
		  $stmt->close();
		  foreach($sudija as $sifra_sudije => $pozicija_sudije) {
  		  $stmt = $this->register->db_conn->prepare('INSERT INTO pozicija_na_utakmici
  				(utakmica, sudija, pozicija) VALUES (?, ?, ?)');
  		  $stmt->bind_param('iss', $sifra_utakmice, $sifra_sudije, $pozicija_sudije);
  		  if (!$res = $stmt->execute()) {
  		    $this->register->infos->set_error($stmt->error);
  		  }
  		  else {
  		    $this->register->infos->set_info('Podaci o sudijama su sacuvani.');
  		  }
		  }
		}
		
		// sacuvaj prekrsaje: save($prekrsaji, $sifra_utakmice)
		if (isset($sifra_utakmice)) {
  		foreach($prekrsaji as $sifra_sudije => $faulovi_sudije) {
  		  foreach($faulovi_sudije as $index => $value) {
  		    $stmt = $this->register->db_conn->prepare('INSERT INTO prekrsaji_utakmice
  				  (sifra_utakmice, sifra_faula, sudija) VALUES (?, ?, ?)');
  		    $stmt->bind_param('iss', $sifra_utakmice, $value, $sifra_sudije);
  		    if (!$res = $stmt->execute()) {
  		      $this->register->infos->set_error($stmt->error);
  		    }
  		    else {
  		      $this->register->infos->set_info('Prekrsaj: ' . $value . ' , sudije: ' . $sifra_sudije . ' je sacuvan.');
  		    }
  		  }
  		}
		}
	}
	
	public function get_all($limit_start, $limit_end) {
	  $result = array();
	  $res = $this->register->db_conn->query('SELECT * FROM utakmice LIMIT ' .$limit_start .', ' .$limit_end);
	  include_once 'model/klub.php';
	  $klub = new klubModel($this->register);
	  $i = 0;
	  while ($row = $res->fetch_assoc()) {
	    $result[$i] = array();
	    foreach($row as $index => $value) {
	     $result[$i][$index] = $value;
	    }
	    $klub->get_klub($row['domacin']);
	    $result[$i]['domacin'] = $klub->naziv_kluba; 
	    $klub->get_klub($row['gost']);
	    $result[$i]['gost'] = $klub->naziv_kluba; 
	    $i++; 
	  }
	  return $result;
	}
	
	public function get_all_at_sezona($sezona, $limit_start, $limit_end) {
	  $result = array();
	  $res = $this->register->db_conn->query('SELECT * FROM utakmice
	    WHERE godina_sezone = ' . $sezona
	    .' LIMIT ' .$limit_start .', ' .$limit_end);
	  include_once 'model/klub.php';
	  $klub = new klubModel($this->register);
	  $i = 0;
	  while ($row = $res->fetch_assoc()) {
	    $result[$i] = array();
	    foreach($row as $index => $value) {
	      $result[$i][$index] = $value;
	    }
	    $klub->get_klub($row['domacin']);
	    $result[$i]['domacin'] = $klub->naziv_kluba; 
	    $klub->get_klub($row['gost']);
	    $result[$i]['gost'] = $klub->naziv_kluba; 
	    $i++;
	  }
	  return $result;
	}
	
	public function get_all_at_liga($liga, $limit_start, $limit_end) {
	  $result = array();
	  $res = $this->register->db_conn->query('SELECT * FROM utakmice
	    WHERE sifra_lige = "' . $liga .'"
	     LIMIT ' .$limit_start .', ' .$limit_end);
	  include_once 'model/klub.php';
	  $klub = new klubModel($this->register);
	  $i = 0;
	  while ($row = $res->fetch_assoc()) {
	    $result[$i] = array();
	    foreach($row as $index => $value) {
	      $result[$i][$index] = $value;
	    }
	    $klub->get_klub($row['domacin']);
	    $result[$i]['domacin'] = $klub->naziv_kluba; 
	    $klub->get_klub($row['gost']);
	    $result[$i]['gost'] = $klub->naziv_kluba; 
	    $i++;
	  }
	  return $result;
	}
	
	public function get_all_at_sezona_liga($sezona, $liga, $limit_start, $limit_end) {
	  $result = array();
	  $res = $this->register->db_conn->query('SELECT * FROM utakmice
	    WHERE godina_sezone = ' . $sezona
	    .' AND sifra_lige = "' . $liga .'"  
	     LIMIT ' .$limit_start .', ' .$limit_end);
	  include_once 'model/klub.php';
	  $klub = new klubModel($this->register);
	  $i = 0;
	  while ($row = $res->fetch_assoc()) {
	    $result[$i] = array();
	    foreach($row as $index => $value) {
	      $result[$i][$index] = $value;
	    }
	    $klub->get_klub($row['domacin']);
	    $result[$i]['domacin'] = $klub->naziv_kluba; 
	    $klub->get_klub($row['gost']);
	    $result[$i]['gost'] = $klub->naziv_kluba; 
	    $i++;
	  }
	  return $result;
	}
	
	public function get_utakmica($sifra_utakmice) {
	  $res = $this->register->db_conn->query('SELECT * FROM utakmice WHERE sifra_utakmice = "' .$sifra_utakmice .'"');
	  if ($res->num_rows > 0) {
	    $row = $res->fetch_assoc();
	    $this->sifra_utakmice = $row['sifra_utakmice'];
	    $this->godina_sezone = $row['godina_sezone'];
	    $this->datum = $row['datum'];
	    $this->sifra_lige = $row['sifra_lige'];
	    $this->domacin = $row['domacin'];
	    $this->gost = $row['gost'];
	    $this->domacin_golova = $row['domacin_ft_golova'];
	    $this->gost_golova = $row['gost_ft_golova']; 
	  }
	}
	
	public function get_sudije() {
	  $result = array();
	  $res = $this->register->db_conn->query('SELECT pozicija_na_utakmici.*, sudije.ime, sudije.prezime, sudije.sifra_sudije
	      FROM pozicija_na_utakmici
	      INNER JOIN sudije ON sudije.sifra_sudije = pozicija_na_utakmici.sudija 
	      WHERE pozicija_na_utakmici.utakmica = ' .$this->sifra_utakmice);
	  while($row = $res->fetch_assoc()) {
	    $result[] = $row;
	  }
	  return $result;
	}
	
	public function get_prekrsaji_sudije($sifra_sudije) {
	  $result = array();
	  $res = $this->register->db_conn->query('SELECT * FROM prekrsaji_utakmice
	      WHERE sifra_utakmice = ' .$this->sifra_utakmice .' AND sudija = "' .$sifra_sudije .'"');
	  while ($row = $res->fetch_assoc()) {
	    $result[] = $row;
	  }
	  return $result;
	}
}