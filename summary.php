<?php

// Pobranie wszystich wymaganych danych oraz wyświetlenie ich.

//Pobranie numeru eksperymentu z $_POST lub $_GET (w zależności w jaki sposób zmienna została przekazana) wraz z rzutowaniem na int (zapezpieczenie przed PHP Injection)
if (isset($_POST['experimentId'])) {
	$experimentId = (int)$_POST['experimentId'];
} else {
	$experimentId = (int)$_GET['experimentId'];
}

//Pobranie ilości dni z $_POST lub $_GET (w zależności w jaki sposób zmienna została przekazana) wraz z rzutowaniem na int (zapezpieczenie przed PHP Injection)
if (isset($_POST['days'])) {
	$days = (int)$_POST['days']; 
} else if (isset($_GET['days'])) {
	$days = (int)$_GET['days']; 
} else if(isset($_POST['show_only_result'])) {
	// Gdy prośba o wyświetlenie tylko wyników eksperymentu z poziomu panelu laborant czas jego trwania zostaje pobrany z bazy danych
	
	$sql = 'SELECT `ilosc_dni` 
			FROM `doswiadczenie10` 
			WHERE `id` = '.$experimentId.'
			AND LABORANT_id IS NOT NULL';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$result = $statement->fetch();
	
	if($result === false) {
		// Wszystkie eksperymenty mają ustawioną ilość dni (początkowo 0 które później jest zmieniane).
		// Jeżeli został rzucony wyjątek oznacza to że doświadczenie o podanym numerze id nie istnieje lub laborant go nie potwierdził!
		echo 'Podane doświadczenie nie istnieje lub nie zostało zapisane przez laboranta!';
		die();		
	}
	$days = $result['ilosc_dni'];

}

//Pobranie powierzchni z użytymi na nich nawozami.
$sql = 'SELECT phn.*, nawoz10.nazwa as NAWOZ_nazwa, nawoz10.wspolczynnik_wzrostu as NAWOZ_wspolczynnik_wzrostu, powierzchnia10.nazwa as POWIERZCHNIA_nazwa FROM `powierzchnia_has_nawoz10` as phn
		INNER JOIN `nawoz10` ON phn.NAWOZ_id = nawoz10.id 
		INNER JOIN `powierzchnia10` ON phn.POWIERZCHNIA_id = powierzchnia10.id 
		WHERE `DOSWIADCZENIE_id` = '.$experimentId;
$statement = $conn->prepare($sql);
$statement->execute();
$fertilizerOnFieds = $statement->fetchAll(PDO::FETCH_ASSOC);


//Dla każdej powarzchni pobranie obszarów wchodzących w jej skład wraz z danymi o zasadzonej tam roślinie.

$plantsOnAreasInFields = [];

// Pętla po wszystkich powierzchniach
foreach ($fertilizerOnFieds as $fertilizerOnFied) {
	
	// Pobranie obszarów wraz z danymi o zasadzonej tam roślinie
	$sql = 'SELECT ohr.*, 
				   obszar10.wielkosc as OBSZAR_wielkosc,
				   obszar10.nazwa as OBSZAR_nazwa,
				   roslina10.jednostka_wzrostu as ROSLINA_jednostka_wzrostu,
				   roslina10.nazwa as ROSLINA_nazwa
		    FROM `obszar_has_roslina10` as ohr
			INNER JOIN `obszar10` ON ohr.OBSZAR_id = obszar10.id 
			INNER JOIN `roslina10` ON ohr.ROSLINA_id = roslina10.id 
			WHERE `DOSWIADCZENIE_id` = '.$experimentId.'
			AND `POWIERZCHNIA_id` = '.$fertilizerOnFied['POWIERZCHNIA_id'].'
			ORDER BY `OBSZAR_id`';
	$statement = $conn->prepare($sql);
	$statement->execute();
	$plantsOnAreas = $statement->fetchAll(PDO::FETCH_ASSOC);
	$plantsOnAreasInFields[$fertilizerOnFied['POWIERZCHNIA_id']] = $plantsOnAreas;
}
?>

<header>

<b>WYNIKI:</b>
<br><br>

Numer eksperymentu: <b><?=$experimentId?></b>

<br><br>

Czas trwania eksperymentu: <b><?php
echo $days;
if ($days==1) {
	echo ' dzień';
} else {
	echo ' dni';
}
?></b>

<br><br>

<?php
foreach ($fertilizerOnFieds as $fertilizerOnFied) {
	echo '<hr>';
	echo 'Powierzchnia: <b>'.$fertilizerOnFied['POWIERZCHNIA_nazwa'].'</b><br>';
	echo 'Użyty nawóz: <b>'.$fertilizerOnFied['NAWOZ_nazwa'].'</b><br><br>';

	foreach ($plantsOnAreasInFields[$fertilizerOnFied['POWIERZCHNIA_id']] as $plantOnArea) {
		echo 'Obszar: "'.$plantOnArea['OBSZAR_nazwa'].'", o powierzchni: '.$plantOnArea['OBSZAR_wielkosc'];
		echo '<br>Roślina na obszarze: <b>'.$plantOnArea['ROSLINA_nazwa'].'</b>';
		echo '<br>Ilość rośliny po określonym czasie: <b>'.$plantOnArea['ilosc_przy_pomiarze'].'</b>';
		echo '<br><br>';
	}
}
?>
<hr><br>
</header>
