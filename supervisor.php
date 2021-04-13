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

try {
	include 'conn.php';

	// Pobranie wszystkich powierzchni
    $sql = 'SELECT * FROM `powierzchnia10`';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$fields = $statement->fetchAll(PDO::FETCH_ASSOC);

	// Pobranie wszystkich obszarów
    $sql = 'SELECT * FROM `obszar10`';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$areas = $statement->fetchAll(PDO::FETCH_ASSOC);

	// Utworzenie tablicy tablic zawierającej obszary dla każdej z powierzchni
	$areasOnFields = [];
	foreach($areas as $area) {
		$areasOnFields[$area['POWIERZCHNIA_id']][] = $area;
	}

	// Pobranie wszystkich nawozów
    $sql = 'SELECT * FROM `nawoz10`';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$fertilizers = $statement->fetchAll(PDO::FETCH_ASSOC);

	// Pobranie wszystkich roślin
    $sql = 'SELECT * FROM `roslina10`';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$plants = $statement->fetchAll(PDO::FETCH_ASSOC);

	// Testowe wyświetlenie zwracanych rekordów
	//echo '<pre>';
	//var_dump($areasOnFields);
	//echo '</pre>';
}
catch(PDOException $e) {
    echo "Błąd przy wykonaniu zapytania: ". $sql . "<br>" . $e->getMessage();
	die();
}

?>

<?php
// Wszystkie wybrane elementy formularza są przekazywane do pliku runtime.php za pomocą metody post
?>
<form action="runtime.php" method="post">
  <fieldset>
<header>
    <h3>PROSZĘ O WYPEŁNIENIE DANYCH DOŚWIADCZENIA</h3>
	<br>
	<?php
	// Pętla po wszystkich powierzchniach
	foreach($fields as $field) {
		$fieldName = $field['nazwa'];
		$fieldId = $field['id'];
		echo '<b>'.$fieldName.'</b>';
	?>
		<br>
		Nawóz:<br>
			<?php
			// Pętla po wszystkich nawozach
			foreach($fertilizers as $fertilizer) {
				echo '<label><input type="radio" value="'.$fertilizer['id'].'" name="fertilizer_'.$fieldId.'">'.$fertilizer['nazwa'].'</label>';
			}
			?><br><br>


		<?php
		// Pętla po tablicy tablic zawierającej obszary dla każdej z powierzchni
		foreach($areasOnFields[$fieldId] as $areaOnFields) {
		?>
			Roślina do posiania na "<?=$fieldName?>", na obszarze "<?= $areaOnFields['nazwa']?>", o rozmiarze "<?= $areaOnFields['wielkosc']?>":<br>
			<select name="area_<?= $areaOnFields['id']?>">
				<?php
				//Pętla po wszystkich roślinach
				foreach($plants as $plant) {
					echo '<option value="'.$plant['id'].'">'.$plant['nazwa'].'</option>';
				}
				?>
			</select><br>
		<?php
		}
		?>
		<br>
	<?php
	}
	?>
    <input type="submit" value="WYKONAJ">
  </fieldset>
</form>

</header>
</body>
</html>
