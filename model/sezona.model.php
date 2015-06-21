<?php
class sezonaModel {
	
	public $godina;
	public $naziv;
	private $register;
	
	public function __construct($register) {
		$this->register = $register;
		$this->godina = date('Y');
		$this->naziv = '';
	}
	
	private function validate($post) {
	  $pattern = '/^[\w\p{L}\p{N}\p{Pd}\s\,\.\-]+$/u';
	  return isset($post['godina-sezone'])
	    && isset($post['naziv-sezone'])
	    && ctype_digit($post['godina-sezone'])
	    && preg_match($pattern, $post['naziv-sezone']);
	}
	
	/**
	 * Save posted data into database.
	 * 
	 * @param array $post Form posted data
	 * @return 0 if it failed
	 */
	public function save($post) {
	  if (!$this->validate($post)) {
	    $this->register->infos->set_error("Oba polja moraju biti popunjena!");
	    return 0;
	  }
	  
	  if (!$stmt = $this->register->db_conn->prepare('INSERT INTO sezona (godina_sezone, naziv_sezone) VALUES (?, ?)')) {
	    $this->register->infos->set_error("Greška u radu sa bazom podataka broj: " . $this->register->db_conn->errno . ". Podatak nije sačuvan.");
	    return 0;
	  }
	  
	  $stmt->bind_param('is', $post['godina-sezone'], $post['naziv-sezone']);
	  if (!$stmt->execute()) {
	    $this->register->infos->set_error("Greška u radu sa bazom podataka broj: " . $this->register->db_conn->errno . ". Podatak nije sačuvan.");
	  	if ($this->register->db_conn->errno == 1062) {
	      $this->register->infos->set_error("Godina sezone već postoji!");
	    }
	    return 0;
	  }
    $stmt->close();
    
	  $this->register->infos->set_info("Podaci su sačuvani.");
    return 1;
  }
	
  /**
   * Change data for specified Sezona
   *
   * @param array $post Form posted data
   * @return 0 if it failed
   */
	public function update($post) {
		if (!$this->validate($post)) {
	    $this->register->infos->set_error("Oba polja moraju biti popunjena!");
	    return 0;
	  }
	  
		if(!$stmt = $this->register->db_conn->prepare("UPDATE sezona SET godina_sezone = ?, naziv_sezone = ? WHERE godina_sezone = ?")) {
	    $this->register->infos->set_error("Greška u radu sa bazom podataka broj: " . $this->register->db_conn->errno . ". Podatak nije sačuvan.");
	    return 0;
		}
	  
		$stmt->bind_param('isi', $post['godina-sezone'], $post['naziv-sezone'], $this->godina);
		if (!$stmt->execute()) {
		  $this->register->infos->set_error("Greška u radu sa bazom podataka broj: " . $this->register->db_conn->errno . ". Podatak nije sačuvan.");
		  return 0;
		}
		$stmt->close();
		
		$this->register->infos->set_info("Podaci su promenjeni.");
		return 1;
	}
	
	/**
	 * Delete all related content: fouls, matches, official position on matches
	 * for specified Sezona
	 *  
	 * @param int Godina sezone
	 * @return 0 if it failed
	 */
	public function delete($god) {
		if (empty($god)) {
		  $this->register->infos->set_error("Nije odabrana sezona!");
		  return 0;
		}
		
		$query = "DELETE sezona, utakmice, prekrsaji_utakmice, pozicija_na_utakmici, pregledanje_prekrsaja
		    FROM sezona
		    INNER JOIN utakmice
		    INNER JOIN prekrsaji_utakmice
		    INNER JOIN pozicija_na_utakmici
		    INNER JOIN pregledanje_prekrsaja
		    WHERE utakmice.godina_sezone = sezona.godina_sezone 
		    AND prekrsaji_utakmice.sifra_utakmice = utakmice.sifra_utakmice
		    AND pozicija_na_utakmici.utakmica = utakmice.sifra_utakmice
		    AND pregledanje_prekrsaja.id_prekrsaja = prekrsaji_utakmice.id_prekrsaja
		    AND sezona.godina_sezone = ?";
		
		if(!($stmt = $this->register->db_conn->prepare($query))) {
		  $this->register->infos->set_error("Greška u radu sa bazom podataka broj: " . $this->register->db_conn->errno . ". Podatak nije sačuvan.");
		  return 0;
		}
		
		$stmt->bind_param('i', $god);
		if(!$stmt->execute()) {
		  $this->register->infos->set_error("Greška u radu sa bazom podataka broj: " . $this->register->db_conn->errno . ". Podatak nije sačuvan.");
		  return 0;
		}
  	$stmt->close();

  	$this->register->infos->set_info("Sezona $god i svi relavatni podaci su obrisani.");
  	return 1;
	}
	
	/**
	 * Retrieve data from database for specified godina  
	 * 
	 * @param int $godina Godina sezone
	 * @return sezonaModel this, otherweise NULL
	 */
	public function load_sezona($godina) {
	  if (empty($godina)) {
	    return NULL;
	  } 
	  
	  if (!$stmt = $this->register->db_conn->prepare("SELECT * FROM sezona WHERE godina_sezone = ?")) {
	    return NULL;
	  }
	  
	  $stmt->bind_param('s', $godina);
	  if (!$stmt->execute()) {
	    return NULL;
	  }
	  $stmt->bind_result($col1, $col2);
	  $stmt->fetch();
	  $this->godina = $col1;
	  $this->naziv = $col2;
	  $stmt->close();
	  
	  return $this;
	}
	
	public function get_all() {
		$result = NULL;
		if (!$result = $this->register->db_conn->query("SELECT * FROM sezona ORDER BY godina_sezone DESC")) {
			$this->register->infos->set_error($this->register->db_conn->connect_error);
		}
		return $result;
	}
	
	public function get_sezona($god) {
		$stmt = $this->register->db_conn->prepare("SELECT * FROM sezona WHERE godina_sezone = ?");
		$stmt->bind_param('s', $god);
		$stmt->execute();
		$stmt->bind_result($col1, $col2);
		$stmt->fetch();
		$this->godina = $col1;
		$this->naziv = $col2;
		$stmt->close();
	}
		
	public static function all_sezone($reg) {
	  $result = array();
	  if (!$res = $reg->db_conn->query("SELECT godina_sezone, naziv_sezone FROM sezona ORDER BY godina_sezone DESC")) {
	    $reg->infos->set_error($reg->db_conn->connect_error);
	  }
	  else {
	    while ($row = $res->fetch_assoc()) {
	      $result[] = $row;	      	      
	    }
	  }
	  return $result;
	}
}