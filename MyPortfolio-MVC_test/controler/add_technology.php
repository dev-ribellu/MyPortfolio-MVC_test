<?php
header('Content-Type: application/json');
require_once '../model/connect.php';

$techName = trim($_POST['tech_name'] ?? '');
if ($techName === '') {
    echo json_encode(['error' => 'Veuillez saisir le nom de la technologie']);
    exit;
}

// Insère uniquement si elle n'existe pas déjà
$sql = "INSERT IGNORE INTO technologies (nom) VALUES (:nom)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['nom' => $techName]);
$tech_id = $pdo->lastInsertId();
if ($tech_id == 0) {
  // Si la technologie existe déjà, récupérer son id
  $stmt = $pdo->prepare("SELECT id FROM technologies WHERE nom = :nom LIMIT 1");
  $stmt->execute(['nom' => $techName]);
  $existingTech = $stmt->fetch(PDO::FETCH_ASSOC);
  $tech_id = $existingTech['id'];
}

echo json_encode(['success' => true, 'id' => $tech_id, 'nom' => $techName]);
exit;
?>