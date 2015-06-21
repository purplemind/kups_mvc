<?php

class Ocenjivanje {
  
  private $register;
  
  function __construct($register) {
    $this->register = $register;
  }
  
  /**
   * Validate form posted value 
   * 
   * @param array $post Posted value from form within "ocene_prekrsaja.tpl.php"
   */
  private static function is_valid_post($post) {
    return isset($post['id_utakmice']) && ctype_digit($post['id_utakmice'])
      && isset($post['id_sudije']) && ctype_alnum($post['id_sudije']);  
  }
  
  public function save($post) {
    if (self::is_valid_post($post)) {
      $prekrsaji = $this->get_prekrsaji_sudije_na_utakmici($post['id_sudije'], $post['id_utakmice']);
      foreach ($prekrsaji as $id_prekrsaja => $prekrsaj) {
        if (isset($post['prekrsaj_' . $id_prekrsaja])) {
          if ($stmt = $this->register->db_conn->prepare('UPDATE pregledanje_prekrsaja
            SET ocena_prekrsaja = ?
            WHERE id_prekrsaja = ?')) {
            $stmt->bind_param('si', $post['prekrsaj_' . $id_prekrsaja], $id_prekrsaja);
            $stmt->execute();
            $stmt->close();
          }
          else {
            $this->register->infos->set_error("Prekrsaj " .$prekrsaj ." nije sacuvan. Doslo je do greske");
            return 0;
          }
        }
      }
      $this->register->infos->set_info("Prekrsaji su sacuvani!");
      return 1;
    }

    $this->register->infos->set_error("Odabrane opcije za sudiju i utakmicu nisu validne!");
    return 0;
  }
  
  /**
   * Get all fouls by named official on named match
   * 
   * @param string $id_sudije
   * @param int $id_utakmice
   * @return array of fouls
   */
  public function get_prekrsaji_sudije_na_utakmici($id_sudije, $id_utakmice) {
    $result = array();

    if ($stmt = $this->register->db_conn->prepare("SELECT pu.id_prekrsaja,
        pu.sifra_faula, faulovi.naziv_faula, pp.ocena_prekrsaja 
	      FROM prekrsaji_utakmice as pu
	      INNER JOIN faulovi ON faulovi.sifra_faula = pu.sifra_faula
        INNER JOIN pregledanje_prekrsaja as pp ON pp.id_prekrsaja = pu.id_prekrsaja
	      WHERE sifra_utakmice = ? AND sudija = ?")) {
	      $stmt->bind_param('is', $id_utakmice, $id_sudije);
	      $stmt->execute();
	      $stmt->bind_result($id_prekrsaja, $sifra_faula, $naziv_faula, $ocena_prekrsaja);
	      while ($stmt->fetch()) {
	        $result[$id_prekrsaja] = array (
	          'id_prekrsaja' => $id_prekrsaja,
	          'sifra_faula' => $sifra_faula,
	          'naziv_faula' => $naziv_faula,
	          'ocena_faula' => $ocena_prekrsaja,
	        );
	      }
    }
        
    return $result;
  }
    
}