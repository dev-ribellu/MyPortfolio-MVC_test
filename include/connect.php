<?php
    require "config.php";

    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
    try {  
        $pdo = new PDO($dsn, $user, $pass);
        if ($pdo) {
            return $pdo;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>