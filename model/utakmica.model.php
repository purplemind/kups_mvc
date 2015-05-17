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
	public $sudija_R;
	public $sudija_U;
	public $sudija_HL;
	public $sudija_LJ;
	public $sudija_SJ;
	public $sudija_BJ;
	public $sudija_FJ;

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
		$this->sudija_R = '';
		$this->sudija_U = '';
		$this->sudija_HL = '';
		$this->sudija_LJ = '';
		$this->sudija_SJ = '';
		$this->sudija_BJ = '';
		$this->sudija_FJ = '';
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
		$prekrsaji = array(); // index - sudija ID, value - array of fouls
		for ($i = 1; $i <= $broj_sudija; $i++) {
		  $pozicija_sudije = 'sudija_' . $post['required']['pozicija_' . $i];
		  $this->$pozicija_sudije = $post['required']['sudija_' . $i];
		  $broj_prekrsaja = $post['broj_prekrsaja_sudija_' . $i];
		  $prekrsaji[$post['required']['sudija_' . $i]] = array();
		  for ($j = 1; $j <= $broj_prekrsaja; $j++) {
		    $prekrsaji[$post['required']['sudija_' . $i]][] = $post['prekrsaj_' . $i . '_' . $j];
		  }
		}
		
		$stmt = $this->register->db_conn->prepare('INSERT INTO utakmice
				(godina_sezone, datum, sifra_lige, domacin, gost, domacin_ft_golova, gost_ft_golova, trazi_se_pregled,
		    pregledana, sudija_R, sudija_U, sudija_HL, sudija_LJ, sudija_SJ, sudija_FJ, sudija_BJ)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('issssiiissssssss', $this->godina_sezone, $this->datum, $this->sifra_lige, $this->domacin, $this->gost,
		    $this->domacin_golova, $this->gost_golova, $this->pregled, $this->pregledana, $this->sudija_R, $this->sudija_U,
		    $this->sudija_HL, $this->sudija_LJ, $this->sudija_SJ, $this->sudija_FJ, $this->sudija_BJ);
		if (!$res = $stmt->execute()) {
		  $this->register->infos->set_error($stmt->error);
		}
		else {
		  $this->register->infos->set_info('Podaci utakmice su sacuvani.');
		}
		
		// sacuvaj prekrsaje: save($prekrsaji, $sifra_utakmice)
		$sifra_utakmice = $stmt->insert_id;
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