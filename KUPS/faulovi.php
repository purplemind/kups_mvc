<?php
	include_once 'app/db.class.php';
	
	$db = new DB;
	$mysqli = $db->connect();
	
	$f = @fopen('faulovi.txt', 'r');
	if ($f) {
		$stmt = $mysqli->prepare('INSERT INTO faulovi (sifra_faula, naziv_faula) VALUES (?, ?)');
		while (($line = fgets($f)) !== false) {
			list($foul_id, $foul_name) = explode(' ', $line, 2);
			echo $foul_id . " -> " . $foul_name . '<br />';
			$stmt->bind_param('ss', $foul_id, $foul_name);
			$stmt->execute();
		}
		$stmt->close();
		fclose($f);
	}