<?php
require_once '../model/connect.php';
require_once '../model/homeModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données du formulaire
    $data = [
        'prenom_nom'    => trim($_POST['nom'] ?? ''),
        'description'   => trim($_POST['description'] ?? ''),
        'telephone'     => trim($_POST['telephone'] ?? ''),
        'adresse'       => trim($_POST['adresse'] ?? ''),
        'date_naissance'=> $_POST['date_naissance'] ?? null,
        'experience'    => trim($_POST['experience'] ?? ''),
        'statut'        => trim($_POST['statut'] ?? '')
    ];
    
    // Gestion de l'upload de la photo "A Propos"
    if (isset($_FILES['photo_a_propos']) && $_FILES['photo_a_propos']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../images/';
        $newFileName = time() . '_' . basename($_FILES['photo_a_propos']['name']);
        $targetFile = $uploadDir . $newFileName;
        if (move_uploaded_file($_FILES['photo_a_propos']['tmp_name'], $targetFile)) {
            $data['photo_a_propos'] = "images/" . $newFileName;
        }
    }
    
    $homeModel = new HomeModel($pdo);
    
    if ($homeModel->updateAPropos($data)) {
        echo "<script>alert('Section A Propos mise à jour'); window.location.href='../admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erreur lors de la mise à jour de la section A Propos'); window.location.href='../admin.php';</script>";
        exit;
    }
}
?>