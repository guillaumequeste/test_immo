<?php

// DSN :
$host = "localhost";
$db = "test_immo";
$username = "root";
$password = "root";
$charset = "utf8mb4";
$port = "3306";

$dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

try
{
	// On se connecte à MySQL
	$pdo = new PDO($dsn, $username, $password, $opt);
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer