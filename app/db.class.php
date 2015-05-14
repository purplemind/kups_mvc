<?php
class DB {
	
	private $db_host;
	private $db_name;
	private $db_username;
	private $db_pass;
	private $mysqli;
	
	public function __construct() {
		if ($conf = parse_ini_file('settings.ini')) {
			foreach ($conf as $key => $value) {
				if (empty($value)) $value = ''; 
				$this->$key = $value; 
			}
		}
		else {
			//@todo: umetni u greske!
		}
	}
	
	public function __destruct() {
		$this->mysqli->close();
	}
	
	/**
	 * Connect to MySQL database and on success return mysqli connection
	 * 
	 * @return NULL | mysqli connection
	 */
	public function connect() {
		$this->mysqli = new mysqli($this->db_host, $this->db_username, $this->db_pass, $this->db_name);
		if ($this->mysqli->connect_errno) {
			//@todo: umetni u greske i mozda exit()
			return NULL;
		}
		$this->mysqli->query("SET NAMES 'utf8'");
		return $this->mysqli;
	}
	
}

?>
