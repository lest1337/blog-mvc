<?php
require_once "app/models/utilisateur.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = null;
$success = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        $userModel = new Utilisateur();
        $existingUser = $userModel->getUserByMail($email);
        
        if ($existingUser) {
            $error = "Un compte avec cet email existe déjà";
        } else {
            $userModel->addUser($username, $email, $password);
            $success = "Compte créé avec succès! Vous pouvez maintenant vous connecter.";
        }
    }
}

require_once "app/views/header.view.php";
require_once "app/views/register.view.php";
require_once "app/views/footer.view.php";
