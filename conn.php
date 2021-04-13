<?php

$servername = "localhost";
 $db_user = "root";
    $db_password = "";
    $db_name = "eksperymenty";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_user, $db_password);
	// Ustawienie PDO error mode dla wyjątków
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	// Ustawienie domyślnego kodowania dla zapytań
    $sql = "SET NAMES 'UTF8'";
	$statement = $conn->prepare($sql);
	$statement->execute();
}
catch(PDOException $e) {
    echo "<center><b>Błąd połączenia z bazą danych!</b></center><br>Komunikat błędu: ".$e->getMessage();
	die();
}
?>
