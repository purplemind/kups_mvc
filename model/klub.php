<?php
class klubModel {

  private $register;

  public $sifra_kluba;
  public $naziv_kluba;
  public $sifra_lige;

  public function __construct($register) {
    $this->register = $register;
  }
  
  public function get_klub($sifra_kluba) {
    $res = $this->register->db_conn->query('SELECT * FROM klubovi WHERE sifra_kluba = "' .$sifra_kluba .'"');
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      $this->sifra_kluba = $row['sifra_kluba'];
      $this->naziv_kluba = $row['naziv_kluba'];
      $this->sifra_lige = $row['sifra_lige'];
    }
  }
}
?>