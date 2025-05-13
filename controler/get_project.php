<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

header('Content-Type: application/json');
require_once '../model/connect.php';
require_once '../model/homeModel.php';
require_once 'homeControler.php';

if (!isset($_GET['project_id']) || !is_numeric($_GET['project_id'])) {
    echo json_encode(['error' => 'ID de projet non renseigné ou invalide']);
    exit;
}

$project_id = (int) $_GET['project_id'];

$homeModel = new HomeModel($pdo);
$homeController = new HomeController($homeModel);

// Récupérer le projet
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = :id");
$stmt->execute(['id' => $project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    echo json_encode(['error' => 'Projet non trouvé']);
    exit;
}

// Récupère les technologies associées (ici on renvoie leurs identifiants)
$stmt = $pdo->prepare("SELECT technologie_id FROM projet_technologies WHERE projet_id = :id");
$stmt->execute(['id' => $project_id]);
$tech_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

$response = [
    'titre' => $project['titre'],
    'description' => $project['description'],
    'image_url' => $project['image_url'],
    'technologies' => $tech_ids
];

echo json_encode($response);
?>