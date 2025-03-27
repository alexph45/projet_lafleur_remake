<?php


$host = 'localhost'; //hôte de la bdd
$dbname = 'remake'; //nom de la bdd
$username = 'root';//nom d'utilisateur pour la connexion à la bdd
$password = '';//mot de passe pour la connexion à la bdd

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}