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


<center>
<b><h3>PANEL LABORANTA - WYNIKI</h3></b>
<br><br>
</center>

<?php

include 'conn.php';
include 'summary.php';

if (!isset($_POST['show_only_result'])) {

	//Pobranie id'ków wszystkich eksperymentów zapisanych przez laboranta
	$sql = 'SELECT * FROM `laborant10`';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$labData = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="lab.php" method="post">
  <fieldset>
    <h3><b>Zapisanie danych eksperymentu</b></h3>
	Wybierz swoje imię i nazwisko:<br>
	<select name="labId">
		<?php
		foreach ($labData as $lab) {
			echo '<option value="'.$lab['id'].'">'.$lab['imie'].' '.$lab['nazwisko'].'</option>';
		}
		?>
	</select>
	<br>
	<input type="hidden" name="experimentId" value="<?=$experimentId?>">
	<input type="hidden" name="save" value="true">
    <input type="submit" value="ZAPISZ">
  </fieldset>
</form>

<?php
} else {
?>

<center>
<a href="lab.php"><b> <input type="submit" value="DO LABORANTA"</b></a>

</center>

<?php
}
?>
<br><br><br><br><br>

</body>
</html>
