<?php
// filepath: c:\xampp\htdocs\p\MyPortfolio-MVC_test\controler/manage_projet.php
require_once '../model/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $project_id = intval($_POST['project_id'] ?? 0);
        if ($project_id > 0) {
            // La suppression des associations dans projet_technologies est gérée par la contrainte ON DELETE CASCADE
            $stmt = $pdo->prepare("DELETE FROM projets WHERE id = :id");
            $stmt->execute(['id' => $project_id]);
        }
    }
}
header("Location: ../admin.php#project-list-section");
exit;
?>