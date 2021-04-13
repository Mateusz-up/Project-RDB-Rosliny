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
<header>

<center>
<?php

include 'conn.php';

// Jeżeli prośba o zapisanie eksperymentu
if (isset($_POST['save'])) {

	// Pobranie id laboranta i id eksperymentu z przekazanych danych
	$labId = (int)$_POST['labId'];
	$experimentId = (int)$_POST['experimentId'];

	// Uzupełnienie informacji o doświadczeniu danymi laboranta
	$sql = 'UPDATE `doswiadczenie10` SET `LABORANT_id` = '.$labId.' WHERE `id` = '.$experimentId;
	$conn->exec($sql);

	echo '<u>ZAPISANO EKSPERYMENT NUMER :'.$experimentId.'!</u><br><br>';
}

//Pobranie id'ków wszystkich eksperymentów zapisanych przez laboranta
$sql = 'SELECT id FROM `doswiadczenie10` WHERE `LABORANT_id` IS NOT NULL';
$statement = $conn->prepare($sql);
$statement->execute();
$labIds = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<b><h3>PANEL LABORANTA</h3></b>
<br><br>
</center>

<form action="lab_result.php" method="post">
  <fieldset>
    <h3>WYŚWIETL ZAPISANY EKSPERYMENT</b></h3>
    Wybierz numer eksperymentu:<br>
	<select name="experimentId">
		<?php
		// Wyświetlenie w pętli wszystkich możliwych ekperymentów
		foreach ($labIds as $labId) {
			echo '<option value="'.$labId['id'].'">'.$labId['id'].'</option>';
		}
		?>
	</select>
	<input type="hidden" name="show_only_result" value="true">
	<br>
    <input type="submit" value="WYŚWIETL">
  </fieldset>
</form>

</header>
</body>
</html>
