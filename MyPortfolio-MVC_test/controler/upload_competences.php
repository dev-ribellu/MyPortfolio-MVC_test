<?php
require_once '../model/connect.php';
require_once '../model/homeModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $names = $_POST['competence_name'] ?? [];
    $levels = $_POST['competence_level'] ?? [];
    
    $competences = [];
    foreach ($names as $index => $name) {
        $name = trim($name);
        if (!empty($name)) {
            $competences[] = [
                'nom' => $name,
                'niveau' => $levels[$index] ?? ''
            ];
        }
    }
    
    $homeModel = new HomeModel($pdo);
    if ($homeModel->updateCompetences($competences)) {
        echo "<script>alert('Compétences mises à jour'); window.location.href='../admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erreur lors de la mise à jour'); window.location.href='../admin.php';</script>";
        exit;
    }
}
?>