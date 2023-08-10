<?php
declare(strict_types=1);

session_start();

if (empty($_POST)) {
    // 1 - Afficher le formulaire

    include 'public/views/layout/header.view.php';
    include 'public/views/login.view.php';
    include 'public/views/layout/footer.view.php';
} else {
    try {
        // 2 - Connexion à la DB
        require_once 'public/db/connection.php';

        // 3 - Vérification des données
            // 3.1 - Pas vides ?
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
            throw new Exception('Formulaire non complet');
        }

            // 3.2 - Pas d'injection SQL ?
        $username = htmlspecialchars($_POST['username']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // 4 - vérifier si les données entrées sont pareilles que les données dans la db
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && $user['username'] === $username && password_verify($_POST['password'], $user['password'])){
            // Redirect to home page
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $username,
                'email' => $email
            ];
    
            http_response_code(302);
            header('location: index.php');
        }  
        // 6 - Connexion automatique
       
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}