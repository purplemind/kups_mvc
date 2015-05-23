<?php

class utakmicaModel {
	
	private $register;
	
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
	
	public function get_utakmice_sudija($sudija, $sezona) {
	  $result = array();
	  $this->register->db_conn->prepare("SELECT utk.domacin, utk.gost, utk.sifra_utakmice
      FROM utakmice AS utk
      INNER JOIN pozicija_na_utakmici AS pnu ON pnu.utakmica = utk.sifra_utakmice
      WHERE pnu.sudija = ?
      AND utk.godina_sezone = ?
      ORDER BY utk.godina_sezone DESC ");
	  $stmt->bind_param('si', $sudija, $sezona);
	  if (!$res = $stmt->execute()) {
	    $this->register->infos->set_error($stmt->error);
	  }
	  else {
	    while($row = $res->fetch_assoc()) {
	      $result[] = array (
	        'sifra_utakmice' => $row['sifra_utakmice'],
	        'domacin' => $row['domacin'],
	        'gost' => $row['gost'],
	      );
	    }
	  }
	  
	  return $result;
	}
	
}