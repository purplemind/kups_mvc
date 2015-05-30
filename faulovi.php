<?php
	include_once 'app/db.class.php';
	
	$db = new DB;
	$mysqli = $db->connect();
	
	// FAULOVI
	$f = @fopen('faulovi.txt', 'r');
	if ($f) {
		$stmt = $mysqli->prepare('INSERT INTO faulovi (sifra_faula, naziv_faula) VALUES (?, ?)');
		while (($line = fgets($f)) !== false) {
			list($foul_id, $foul_name) = explode(' ', $line, 2);
			echo $foul_id . " -> " . $foul_name . '<br />';
			$stmt->bind_param('ss', $foul_id, rtrim($foul_name));
			$stmt->execute();
		}
		$stmt->close();
		fclose($f);
	}
	
	// LIGE
	$f = @fopen('lige.txt', 'r');
	if ($f) {
	  $stmt = $mysqli->prepare('INSERT INTO lige (sifra_lige, naziv_lige) VALUES (?, ?)');
	  while (($line = fgets($f)) !== false) {
	    list($liga_id, $liga_name) = explode(' ', $line, 2);
	    echo $liga_id . " -> " . $liga_name . '<br />';
	    $stmt->bind_param('ss', $liga_id, rtrim($liga_name));
	    $stmt->execute();
	  }
	  $stmt->close();
	  fclose($f);
  }

  // KLUBOVI
  $f = @fopen('klubovi.txt', 'r');
  if ($f) {
    $stmt = $mysqli->prepare('INSERT INTO klubovi (sifra_kluba, naziv_kluba, sifra_lige) VALUES (?, ?, ?)');
    while (!feof($f)) {
      $liga = fgets($f);
      $liga = rtrim($liga);
      $broj_klubova = (int)fgets($f);
      echo 'Liga: ' .$liga .' broji ' .$broj_klubova .' klubova<br />';
      while (($broj_klubova--) > 0) {
        $line = fgets($f);
        list($sifra_kluba, $naziv_kluba) = explode('-', $line, 2);
        echo $sifra_kluba . " -> " . $naziv_kluba . '<br />';
        $stmt->bind_param('sss', $sifra_kluba, rtrim($naziv_kluba), $liga);
        if (!$stmt->execute()) {
          echo 'Neka greska u statement-u: ' . $stmt->error .'<br />'; 
        }
      }
    }
    $stmt->close();
    fclose($f);
  }
?>