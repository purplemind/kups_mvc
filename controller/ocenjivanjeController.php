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
    
    /*
    $utakmica = new utakmicaModel($this->register);
    $utakmice_sudije = $utakmica->get_utakmice_sudija($sudija, $sezona)
    */
    $content = "";
    try {
      $content = $this->register->template->load_template('pregled_prekrsaja');
    } catch (Exception $e) {
      $this->register->infos->set_error($e->getMessage());
    }
    
    return $content;
  }
  
}