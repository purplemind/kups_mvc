<?php

class ocenjivanjeController Extends baseController {
  
  public function display($action) {
    
    include_once 'model/sezona.model.php';
    include_once 'model/sudije.model.php';
    include_once 'model/utakmica.model.php';
  
    $sezona = new sezonaModel($this->register);
    $sve_sezone = $sezona->get_all();
    $this->register->template->sezone = $sve_sezone;
    
    $sudija = new sudijaModel($this->register);
    $sve_sudije = $sudija->get_all();
    $this->register->template->sudije = $sve_sudije;
    
    $content = "";
    
    if (isset($_POST['sacuvaj_promene_ocenjivanje'])) {
      include_once 'model/ocenjivanje.model.php';
      $ocenjivanje = new Ocenjivanje($this->register);
      $ocenjivanje->save($_POST);
      $utakmice_sudije = $sudija->get_utakmice_sudija($_POST['sudija'], $_POST['sezona']);
      $this->register->template->seted_sezona = $_POST['sezona'];
      $this->register->template->seted_sudija = $_POST['sudija'];
      $this->register->template->utakmice_sudije = $utakmice_sudije;
      $this->register->template->prekrsaji = $ocenjivanje->get_prekrsaji_sudije_na_utakmici($_POST['id_sudije'], $_POST['id_utakmice']);
      $this->register->template->id_sudije = $_POST['id_sudije'];
      $this->register->template->id_utakmice = $_POST['id_utakmice'];
      $this->register->template->prekrsaji_tpl = $this->register->template->load_template('ocene_prekrsaja');
    }
    
    if (isset($_POST['prikazi_utakmice'])) {
      if ($_POST['sudija'] != 'NaN' && $_POST['sezona'] != 'NaN') {
        $utakmice_sudije = $sudija->get_utakmice_sudija($_POST['sudija'], $_POST['sezona']);
        $this->register->template->seted_sezona = $_POST['sezona'];
        $this->register->template->seted_sudija = $_POST['sudija'];
        $this->register->template->utakmice_sudije = $utakmice_sudije;
      }
      else {
        $this->register->infos->set_error("Mora se odabrati sezona i sudija!");
      }
    }

    $args = explode('/', $action);
    if (isset($args[0]) && isset($args[1])) {
      $id_utakmice = $args[0];
      $id_sudije = $args[1];
      include_once 'model/ocenjivanje.model.php';
      $ocenjivanje = new Ocenjivanje($this->register);
      $this->register->template->prekrsaji = $ocenjivanje->get_prekrsaji_sudije_na_utakmici($id_sudije, $id_utakmice);
      $this->register->template->id_sudije = $id_sudije;
      $this->register->template->id_utakmice = $id_utakmice;
      //$this->register->template->prekrsaji_tpl = $this->register->template->load_template('ocene_prekrsaja');
      return $this->register->template->load_template('ocene_prekrsaja');
    }

    try {
      $content = $this->register->template->load_template('pregled_prekrsaja');
    } catch (Exception $e) {
      $this->register->infos->set_error($e->getMessage());
    }
    return $content;
  }
  
}