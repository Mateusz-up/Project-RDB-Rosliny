<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css" type="text/css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PROJEKT RBD</title>
</head>
<body>
<p align="right">
    <a href="index.php" class="main-link">WRÓĆ</a></p>


<?php

include 'conn.php';

$sql = 'INSERT INTO doswiadczenie10 (ilosc_dni) VALUES (0)';
$conn->exec($sql);
$experimentId = $conn->lastInsertId();
//echo 'Utworzono doświadczenie numer: '.$experimentId.'<br>';    

// $_POST to tablica asocjacyjna. Jej kluczami i wartościami w tym przypadku są stringi.
// $POST['area_1'] = 1;
// $POST['area_2'] = 3;
foreach ($_POST as $key => $value) {
	if (preg_match("/^fertilizer_(.)*/", $key)) {
		$fieldId = substr($key, 11);
		$fertilizerId = $value;
		
		$sql = 'INSERT INTO powierzchnia_has_nawoz10 (POWIERZCHNIA_id, NAWOZ_id, DOSWIADCZENIE_id) VALUES ('.$fieldId.', '.$fertilizerId.', '.$experimentId.')';
		$conn->exec($sql);
		//echo "Przypisano nawóz do pola.<br>";
	} else if (preg_match("/^area_(.)*/", $key)){
		$areaId = substr($key, 5);
		$plantId = $value;
		
		$sql = 'INSERT INTO obszar_has_roslina10 (OBSZAR_id, ROSLINA_id, DOSWIADCZENIE_id) VALUES ('.$areaId.', '.$plantId.', '.$experimentId.')';
		$conn->exec($sql);
		//echo "Przypisano roślinę do obszaru.<br>";
	}
}
?>

<form action="execution.php" method="post">
    <header>
  <fieldset>
    <h3>Odczekaj określoną ilość dni</h3>
    Ilość dni:<br>
    <input type="number"  required name="days" value="10"><br>
	<br>
	<input type="hidden" name="experimentId" value="<?=$experimentId?>">
    <input type="submit" value="ODCZEKAJ">
  </fieldset>
    </header>
</form>

</body>
</html>