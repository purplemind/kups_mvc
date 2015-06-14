<?php 

class Prekrsaj {
  
  private $register;
  
  public function __construct($register) {
    $this->register = $register;
  }

  private static function get_all_sa_utakmice_za_sudiju($id_utakmice, $id_sudije, $reg) {
    $result = array();
    
    $res = $reg->db_conn->query('SELECT id_prekrsaja, sifra_faula FROM prekrsaji_utakmice
      WHERE sifra_utakmice = ' .$id_utakmice .'
      AND sudija = "' .$id_sudije .'"');
    if ($res->num_rows > 0) {
      while ($row = $res->fetch_assoc()) {
        $result[$row['id_prekrsaja']] = $row['sifra_faula'];
      }
    }
        
    return $result;
  }
  
  /**
   * 
   * @param unknown $id_utakmice
   * @param array $prekrsaji - prekrsaji sudije, $prekrsaji[0] = sifra_prekrsaja ... 
   * @param unknown $reg
   */
  public static function save_prekrsaji_sudije($id_utakmice, $id_sudije, $prekrsaji, $reg) {
    
    $prekrsaji_u_bazi = Prekrsaj::get_all_sa_utakmice_za_sudiju($id_utakmice, $id_sudije, $reg);
    foreach($prekrsaji as $index => $sifra_faula) {
      // already in database => only unset the element from $prekrsaji_u_bazi
      if ($id_prekrsaja = array_search($sifra_faula, $prekrsaji_u_bazi)) {
        unset($prekrsaji_u_bazi[$id_prekrsaja]);
      }
      // no in database => save it:
      else {
        $reg->db_conn->query('INSERT INTO prekrsaji_utakmice (sifra_utakmice, sudija, sifra_faula)
          VALUES (' .$id_utakmice .', "' .$id_sudije .'", "' .$sifra_faula .'")');
        $id_prekrsaja = $reg->db_conn->insert_id;
        $reg->db_conn->query('INSERT INTO pregledanje_prekrsaja VALUES(' .$id_prekrsaja .', "NaN")');
      }
    }
    
    // delete rest of fouls from database:
    foreach($prekrsaji_u_bazi as $id_prekrsaja => $sifra_faula) {
      $reg->db_conn->query('DELETE prekrsaji_utakmice, pregledanje_prekrsaja
          FROM prekrsaji_utakmice
          INNER JOIN pregledanje_prekrsaja
          WHERE pregledanje_prekrsaja.id_prekrsaja = prekrsaji_utakmice.id_prekrsaja
          AND prekrsaji_utakmice.id_prekrsaja =' .$id_prekrsaja);
    } 
  }
  
}
?>