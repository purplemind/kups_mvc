<?php

class utakmicaModel {
	
	private $register;
	
	public $godina_sezone;
	public $datum;
	public $vreme_pocetka;
	public $sifra_lige;
	public $domacin;
	public $gost;
	public $domacin_ht_golova;
	public $gost_ht_golova;
	public $domacin_ft_golova;
	public $gost_ft_golova;
	public $broj_ot;
	public $trajanje_ot;
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
		$this->vreme_pocetka = '';
		$this->sifra_lige = '';
		$this->domacin = '';
		$this->gost = '';
		$this->domacin_ht_golova = 0;
		$this->gost_ht_golova = 0;
		$this->domacin_ft_golova = 0;
		$this->gost_ft_golova = 0;
		$this->broj_ot = 0;
		$this->trajanje_ot = 0;
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
	
	public function set_first_step($post) {
		//@todo: valid!
		$this->godina_sezone = $post['required']['godina_sezone'];
		$this->datum = strtotime(DateTime::createFromFormat('d/m/Y', $post['required']['datum'])->format('m/d/Y'));
		$this->vreme_pocetka = $post['required']['vreme_pocetka'];
		$this->sifra_lige = $post['required']['sifra_lige'];
		return array(
			'godina_sezone' => $this->godina_sezone,
			'datum' => $this->datum,
			'vreme_pocetka' => $this->vreme_pocetka,
			'sifra_lige' => $this->sifra_lige,	
		);
	}
	
}