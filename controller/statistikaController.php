<?php

class statistikaController Extends baseController {

  public function display($action) {
    
    require_once __SITE_PATH .'/model/sudije.model.php';
    require_once __SITE_PATH .'/model/sezona.model.php';
    
    $this->register->template->sudije = sudijaModel::all_sudije($this->register);
    $this->register->template->sezone = sezonaModel::all_sezone($this->register);
    
    if (isset($_POST['statistika'])) {
      if ($_POST['sudija'] == 'NaN' || $_POST['sezona'] == 'NaN') {
        $this->register->infos->set_error('Mora se odabrati sudija i sezona!');
      }
      else {
        $this->register->template->seted_sudija = $_POST['sudija'];
        $this->register->template->seted_sezona = $_POST['sezona'];
        $this->register->template->po_ligama = sudijaModel::statistika_po_ligama($this->register, $_POST['sudija'], $_POST['sezona']);
        $this->register->template->po_pozicijama = sudijaModel::statistika_po_pozicijama($this->register, $_POST['sudija']);
        $this->register->template->po_ocenama = sudijaModel::statistika_po_ocenama($this->register, $_POST['sudija']);
      }
    }
    
    $content = $this->register->template->load_template('statistika');
    return $content;
  }
  
}