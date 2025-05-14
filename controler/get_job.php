<?php
header('Content-Type: application/json');
require_once '../model/connect.php';; // Assurez-vous que $pdo est bien instancié

$query = $pdo->query("SELECT nom FROM metiers ORDER BY id ASC");
$metiers = $query->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($metiers);
?>