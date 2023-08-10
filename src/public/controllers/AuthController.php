<?php
declare (strict_types=1);
require_once 'public/db/Database.php';

class AuthController{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function register($post){
        if (empty($post)) {
            include 'public/views/layout/header.view.php';
            include 'public/views/register.view.php';
            include 'public/views/layout/footer.view.php';
        } else {
            try {
                // 2 - Connexion à la DB
                require_once 'public/db/Database.php';

                // 3 - Vérification des données
                    // 3.1 - Pas vides ?
                if (empty($post['username']) || empty($post['email']) || empty($post['password'])) {
                    throw new Exception('Formulaire non complet');
                }

                    // 3.2 - Pas d'injection SQL ?
                $username = htmlspecialchars($post['username']);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

                // 4 - Hasher le mot de passe
                $passwordHash = password_hash($post['password'], PASSWORD_DEFAULT);
                // 5 - Ajout à la base de données
                $stmt = $this->db->query(
                    "
                        INSERT INTO users (username, email, password) 
                        VALUES (?, ?, ?)
                    ",
                    [$username, $email, $passwordHash]
                );
                // 6 - Connexion automatique
                $_SESSION['user'] = [
                    'id' => $this->db->lastInsertId(),
                    'username' => $username,
                    'email' => $email
                ];

                // Redirect to home page
                http_response_code(302);
                header('location: index.php');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    public function login(){
        //
    }
    public function logout(){

    }
}