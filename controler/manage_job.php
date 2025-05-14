
<?php
require_once '../model/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $job_name = trim($_POST['job_name'] ?? '');
        if ($job_name !== '') {
            $stmt = $pdo->prepare("INSERT INTO metiers (nom) VALUES (:nom)");
            $stmt->execute(['nom' => $job_name]);
        }
    } elseif ($action === 'edit') {
        $job_id = $_POST['job_id'] ?? '';
        $job_name = trim($_POST['job_name'] ?? '');
        if ($job_id !== '' && $job_name !== '') {
            $stmt = $pdo->prepare("UPDATE metiers SET nom = :nom WHERE id = :id");
            $stmt->execute(['nom' => $job_name, 'id' => $job_id]);
        }
    } elseif ($action === 'delete') {
        $job_id = $_POST['job_id'] ?? '';
        if ($job_id !== '') {
            $stmt = $pdo->prepare("DELETE FROM metiers WHERE id = :id");
            $stmt->execute(['id' => $job_id]);
        }
    }
}

header("Location: ../admin.php");
exit;
?>