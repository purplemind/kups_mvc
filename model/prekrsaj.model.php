<?php 

class Prekrsaj {
  
  private $register;
  
  public function __construct($register) {
    $this->register = $register;
  }
  
  public function get_all($sezona, $sudija) {
    $this->register->db_conn->query("SELECT * FROM  ORDER BY godina_sezone DESC");
  }
}

?>