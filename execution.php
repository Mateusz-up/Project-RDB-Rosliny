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

// Pobranie wszystich wymaganych danych, obliczenie wzrostu roślin w danym eksperymencie oraz zapisanie tej informacji do bazy danych.

$days = (int)$_POST['days']; //Pobranie danej z $_POST wraz z rzutowaniem na int (zapezpieczenie przed PHP Injection)
$experimentId = (int)$_POST['experimentId']; //Pobranie danej z $_POST wraz z rzutowaniem na int (zapezpieczenie przed PHP Injection)

// Aktualizacja doświadczenia o podaną liczbę dni
$sql = 'UPDATE `doswiadczenie10` SET `ilosc_dni` = '.$days.' WHERE `id` = '.$experimentId;
$conn->exec($sql);

//Pobranie powierzchni z użytymi na nich nawozami.
$sql = 'SELECT phn.*, nawoz10.nazwa as NAWOZ_nazwa, nawoz10.wspolczynnik_wzrostu as NAWOZ_wspolczynnik_wzrostu, powierzchnia10.nazwa as POWIERZCHNIA_nazwa FROM `powierzchnia_has_nawoz10` as phn
		INNER JOIN `nawoz10` ON phn.NAWOZ_id = nawoz10.id 
		INNER JOIN `powierzchnia10` ON phn.POWIERZCHNIA_id = powierzchnia10.id 
		WHERE `DOSWIADCZENIE_id` = '.$experimentId;
$statement = $conn->prepare($sql);
$statement->execute();
$fertilizerOnFieds = $statement->fetchAll(PDO::FETCH_ASSOC);


//Dla każdej powarzchni pobranie obszarów wchodzących w jej skład wraz z danymi o zasadzonej tam roślinie. Wewnątrz algorytm wyliczający wzrost rośliny.

// Pętla po wszystkich powierzchniach
foreach ($fertilizerOnFieds as $fertilizerOnFied) {

	// Pobranie obszarów wraz z danymi o zasadzonej tam roślinie
	$sql = 'SELECT ohr.*, 
				   obszar10.wielkosc as OBSZAR_wielkosc,
				   roslina10.jednostka_wzrostu as ROSLINA_jednostka_wzrostu 
		    FROM `obszar_has_roslina10` as ohr
			INNER JOIN `obszar10` ON ohr.OBSZAR_id = obszar10.id 
			INNER JOIN `roslina10` ON ohr.ROSLINA_id = roslina10.id 
			WHERE `DOSWIADCZENIE_id` = '.$experimentId.'
			AND `POWIERZCHNIA_id` = '.$fertilizerOnFied['POWIERZCHNIA_id'];
	$statement = $conn->prepare($sql);
	$statement->execute();
	$plantsOnAreas = $statement->fetchAll(PDO::FETCH_ASSOC);

	// Pętla po wszystkich obszarach w danej powierzchni
	foreach ($plantsOnAreas as &$plantOnArea){

		// Algorytm wyliczający wzrost rośliny - uwzględniający jednostkę wzrostu rośliny, współczynnik wzrostu dla nawozu oraz pole powierzchni obszaru na którym była posadzona
		$plantOnArea['ilosc_przy_pomiarze'] =
			(float)$plantOnArea['ROSLINA_jednostka_wzrostu'] * // Jednostka wzrostu rośliny pomnożona przez
			(float)$fertilizerOnFied['NAWOZ_wspolczynnik_wzrostu'] * // Współczynnik nawozu na danej powierzchni pomnożony przez
			(int)$plantOnArea['OBSZAR_wielkosc'] * // wielkość danego obszaru pomnożona przez
			$days; // ilość dni

		// Zapisanie tej informacji do bazy danych
		$sql = 'UPDATE `obszar_has_roslina10` SET `ilosc_przy_pomiarze` = '.$plantOnArea['ilosc_przy_pomiarze'].' WHERE `id` = '.$plantOnArea['id'];
		$conn->exec($sql);
	}
}


include 'summary.php';

?>


<center>
    <a href="lab_result.php?days=<?=$days?>&experimentId=<?=$experimentId?>"><b> <input type="submit" value="DO LABORANTA"</b></a>

</center>

</body>
</html>
