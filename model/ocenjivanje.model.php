<?php

class Ocenjivanje {
  
  private $register;
  
  function __construct($register) {
    $this->register = $register;
  }
  
  public function save($post) {
    //@todo: validate
    $prekrsaji = $this->get_prekrsaji_sudije_na_utakmici($post['id_sudije'], $post['id_utakmice']);
    foreach ($prekrsaji as $id_prekrsaja => $prekrsaj) {
      if (isset($post['prekrsaj_' . $id_prekrsaja])) {
        $res = $this->register->db_conn->query('UPDATE pregledanje_prekrsaja
          SET ocena_prekrsaja = "' . $post['prekrsaj_' . $id_prekrsaja] .'" WHERE id_prekrsaja = ' . $id_prekrsaja);
        if (!$res) {
          $this->register->infos->set_error("Prekrsaj " .$prekrsaj ." nije sacuvan. Greska: " .$this->register->db_conn->error);
          return;
        }
      }
    }
    $this->register->infos->set_info("Prekrsaji su sacuvani!");
  }
  
  public function get_prekrsaji_sudije_na_utakmici($id_sudije, $id_utakmice) {
    $result = array();
     
    $res = $this->register->db_conn->query("SELECT pu.id_prekrsaja, pu.sifra_faula, faulovi.naziv_faula, pp.ocena_prekrsaja 
	      FROM prekrsaji_utakmice as pu
	      INNER JOIN faulovi ON faulovi.sifra_faula = pu.sifra_faula
        INNER JOIN pregledanje_prekrsaja as pp ON pp.id_prekrsaja = pu.id_prekrsaja
	      WHERE sifra_utakmice = " . $id_utakmice .
        " AND sudija = '" . $id_sudije . "'");
    while ($row = $res->fetch_assoc()) {
      $result[$row['id_prekrsaja']] = array (
        'id_prekrsaja' => $row['id_prekrsaja'],
        'sifra_faula' => $row['sifra_faula'],
        'naziv_faula' => $row['naziv_faula'],
        'ocena_faula' => $row['ocena_prekrsaja'],
      );
    }
     
    return $result;
  }
    
}