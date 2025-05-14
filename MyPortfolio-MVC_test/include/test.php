<?php
    $pdo = require 'connect.php';
    $sql = 'SELECT * FROM utilisateur';
    $statement = $pdo->query($sql);
    $user_data = $statement->fetch(PDO::FETCH_ASSOC);
    print_r($user_data["nom"]);
?>