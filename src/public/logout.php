<?php
declare(strict_types=1);
session_start();

try {
    // 2 - Connexion à la DB
    require_once 'public/db/connection.php';

    // 3 - Vérification des données
    
    include 'public/views/layout/header.view.php';
//    include 'public/views/layout/footer.view.php';
    unset($_SESSION['user']);
    session_destroy();
    http_response_code(302);
    header('location: index.php');
    
        // 3.2 - Pas d'injection SQL ?

    // 4 - vérifier si les données entrées sont pareilles que les données dans la db
    
    
    // 6 - Connexion automatique 
} catch (Exception $e) {
    echo $e->getMessage();
}