<?php
require_once '../model/connect.php';
require_once '../model/homeModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation de la donnée "nom"
    $nom = trim($_POST['nom'] ?? '');
    
    // Gérer l'upload de l'image
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Le dossier d'upload est situé en dehors du dossier controler
        $uploadDir = '../images/'; // chemin absolu relatif depuis controler à images
        // Crée un nouveau nom de fichier unique
        $newFileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $newFileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Enregistrez le chemin relatif par rapport à l'index.php
            $imagePath = "images/" . $newFileName;
        }
    }

    // Mettre à jour la table "Accueil" via le modèle
    $homeModel = new HomeModel($pdo);
    
    // Exemple avec la méthode updateAccueil du modèle
    if ($homeModel->updateAccueil($nom, $imagePath)) {
        echo "<script>alert('Accueil mis à jour'); window.location.href='../admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erreur lors de la mise à jour'); window.location.href='../admin.php';</script>";
        exit;
    }
}
?>