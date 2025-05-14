<?php
require_once '../model/connect.php'; // Ce fichier doit retourner l'instance PDO dans $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données du formulaire
    $personne = trim($_POST['nom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $sujet    = trim($_POST['sujet'] ?? '');
    $contenu  = trim($_POST['message'] ?? '');
    
    // Vérifier que tous les champs nécessaires sont remplis
    if ($personne !== '' && $email !== '' && $sujet !== '' && $contenu !== '') {
        $sql = "INSERT INTO emails (personne, email, sujet, contenu) 
                VALUES (:personne, :email, :sujet, :contenu)";
        $stmt = $pdo->prepare($sql);
        $executed = $stmt->execute([
            'personne' => $personne,
            'email'    => $email,
            'sujet'    => $sujet,
            'contenu'  => $contenu
        ]);
        
        if ($executed) {
            echo "<script>
                    alert('Votre message a été envoyé');
                    window.location.href='../index.php';
                  </script>";
            exit;
        } else {
            echo "<script>alert('Erreur lors de l\'envoi de votre message');</script>";
        }
    } else {
        echo "<script>alert('Veuillez remplir tous les champs');</script>";
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>