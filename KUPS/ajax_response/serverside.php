<?php
	switch ($_GET['action']) {
		case 'get_klubovi':
			get_klubovi($_GET['sifra_lige']);
			break;
	}
	
function get_klubovi($sifra_lige) {
	include_once "app/db.class.php";
	$mysqli = (new DB)->db_conn();
	$sifra_lige = strip_tags(trim($sifra_lige));
	$qry_res = $mysqli->query('SELECT sifra_kluba, naziv_kluba FROM klubovi WHERE sifra_lige = "' .$sifra_lige .'"');
	$res = array();
	while ($row = $qry_res->fetchAssoc()) {
		$res['sifra_kluba'] = $row['sifra_kluba'];
		$res['naziv_kluba'] = $row['naziv_kluba'];
	}
	$mysqli->close();
	print json_encode($res);
}
?>