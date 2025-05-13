<?php
require_once '../model/connect.php';
require_once '../model/homeModel.php';
require_once 'homeControler.php';

$homeModel = new HomeModel($pdo);
$homeController = new HomeController($homeModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = trim($_POST['project_id'] ?? '');
    $titre = trim($_POST['titre_projet'] ?? '');
    $description = trim($_POST['description_projet'] ?? '');

    if ($titre === '' || $description === '') {
        echo "<script>alert('Veuillez remplir tous les champs obligatoires');window.history.back();</script>";
        exit;
    }

    // Gestion de l'upload de l'image si fourni
    $image_url = '';
    if (isset($_FILES['image_projet']) && $_FILES['image_projet']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image_projet']['tmp_name'];
        $fileName = $_FILES['image_projet']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = time().'_'.md5($fileName).'.'.$fileExtension;
        $uploadFileDir = '../images/projects/';
        $dest_path = $uploadFileDir.$newFileName;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $image_url = 'images/projects/'.$newFileName;
        }
    }

    // Si un id est fourni, mise à jour du projet ; sinon, insertion d'un nouveau projet
    if ($project_id !== '') {
        if ($image_url !== '') {
            $sql = "UPDATE projets SET titre = :titre, description = :description, image_url = :image_url WHERE id = :id";
            $params = ['titre' => $titre, 'description' => $description, 'image_url' => $image_url, 'id' => $project_id];
        } else {
            $sql = "UPDATE projets SET titre = :titre, description = :description WHERE id = :id";
            $params = ['titre' => $titre, 'description' => $description, 'id' => $project_id];
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        if ($image_url === '') {
            $image_url = 'images/default.jpg'; // Par défaut si aucune image n'est uploadée
        }
        $sql = "INSERT INTO projets (titre, description, image_url) VALUES (:titre, :description, :image_url)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['titre' => $titre, 'description' => $description, 'image_url' => $image_url]);
        $project_id = $pdo->lastInsertId();
    }

    // Vider les associations existantes si mise à jour
    $stmt = $pdo->prepare("DELETE FROM projet_technologies WHERE projet_id = :id");
    $stmt->execute(['id' => $project_id]);

    // Association des technologies existantes sélectionnées
    if (isset($_POST['technologies']) && is_array($_POST['technologies'])) {
        foreach ($_POST['technologies'] as $tech_id) {
            $sql = "INSERT INTO projet_technologies (projet_id, technologie_id) VALUES (:projet_id, :technologie_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['projet_id' => $project_id, 'technologie_id' => $tech_id]);
        }
    }

    // Ajout d'une nouvelle technologie si renseignée et association au projet
    $nouvelleTech = trim($_POST['nouvelle_technologie'] ?? '');
    if ($nouvelleTech !== '') {
        $sql = "INSERT IGNORE INTO technologies (nom) VALUES (:nom)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => $nouvelleTech]);
        $tech_id = $pdo->lastInsertId();
        if ($tech_id == 0) {
            $stmt = $pdo->prepare("SELECT id FROM technologies WHERE nom = :nom LIMIT 1");
            $stmt->execute(['nom' => $nouvelleTech]);
            $existingTech = $stmt->fetch(PDO::FETCH_ASSOC);
            $tech_id = $existingTech['id'];
        }
        $sql = "INSERT INTO projet_technologies (projet_id, technologie_id) VALUES (:projet_id, :technologie_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['projet_id' => $project_id, 'technologie_id' => $tech_id]);
    }

    echo "<script>alert('Projet traité avec succès');window.location.href='../admin.php';</script>";
    exit;
} else {
    header("Location: ../admin.php");
    exit;
}
?>