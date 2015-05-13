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
	
	public function save($god, $naz) {
		if (!empty($god) && !empty($naz)) {
			$stmt = $this->register->db_conn->prepare('INSERT INTO sezona (godina_sezone, naziv_sezone) VALUES (?, ?)');
			$stmt->bind_param('is', $god, $naz);
			$res = $stmt->execute();
			return $res;
		}
		return 0;
	}
	
	public function update($god, $naz) {
		if (!empty($god) && !empty($naz)) {
			$stmt = $this->register->db_conn->prepare("UPDATE sezona SET godina_sezone = ?, naziv_sezone = ? WHERE godina_sezone = ?");
			$stmt->bind_param('isi', $god, $naz, $this->godina);
			$res = $stmt->execute();
			$stmt->close();
			return $res;
		}
		return 0;
	}
	
	public function delete($god) {
		if (!empty($god)) {
			$stmt = $this->register->db_conn->prepare("DELETE FROM sezona WHERE godina_sezone = ?");
			$stmt->bind_param('i', $god);
			$res = $stmt->execute();
			$stmt->close();
			return $res;
		}
		return 0;
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
		
}