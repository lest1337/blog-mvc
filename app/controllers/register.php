<?php
require_once "app/models/utilisateur.inc.php";
require_once "app/models/logger.inc.php";

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
    } elseif (strlen($password) < 12) {
        $error = "Le mot de passe doit contenir au moins 12 caractères";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Le mot de passe doit contenir au moins une majuscule";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $error = "Le mot de passe doit contenir au moins une minuscule";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $error = "Le mot de passe doit contenir au moins un chiffre";
    } elseif (!preg_match("/[!@#$%^&*()_+\-=\[\]{};':\"\\\\|,.<>\/?]/", $password)) {
        $error = "Le mot de passe doit contenir au moins un caractère spécial";
    } else {
        $userModel = new Utilisateur();
        $existingUser = $userModel->getUserByMail($email);
        
        if ($existingUser) {
            Logger::log("REGISTER_FAILED", ["email" => $email, "reason" => "email_exists"]);
            $error = "Un compte avec cet email existe déjà";
        } else {
            $userModel->addUser($username, $email, $password);
            Logger::log("REGISTER_SUCCESS", ["email" => $email, "username" => $username]);
            $success = "Compte créé avec succès! Vous pouvez maintenant vous connecter.";
        }
    }
}

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/register.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
