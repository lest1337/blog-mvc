<?php
require_once "app/models/utilisateur.inc.php";
require_once "app/models/auth.inc.php";
require_once "app/models/logger.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedOn()) {
    header("Location: index.php?action=login");
    exit;
}

$userModel = new Utilisateur();
$user = $userModel->getUser($_SESSION["userId"]);
$error = null;
$success = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["update_profile"])) {
        $username = $_POST["username"] ?? "";
        $email = $_POST["email"] ?? "";

        if (empty($username) || empty($email)) {
            $error = "Veuillez remplir tous les champs";
        } else {
            $userModel->updateUser($_SESSION["userId"], $username, $email);
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $user = $userModel->getUser($_SESSION["userId"]);
            Logger::log("PROFILE_UPDATED", ["user_id" => $_SESSION["userId"], "username" => $username]);
            $success = "Profil mis à jour avec succès";
        }
    } elseif (isset($_POST["update_password"])) {
        $currentPassword = $_POST["current_password"] ?? "";
        $newPassword = $_POST["new_password"] ?? "";
        $confirmPassword = $_POST["confirm_password"] ?? "";

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error = "Veuillez remplir tous les champs";
        } elseif ($newPassword !== $confirmPassword) {
            $error = "Les mots de passe ne correspondent pas";
        } elseif (strlen($newPassword) < 12) {
            $error = "Le mot de passe doit contenir au moins 12 caractères";
        } elseif (!preg_match("/[A-Z]/", $newPassword)) {
            $error = "Le mot de passe doit contenir au moins une majuscule";
        } elseif (!preg_match("/[a-z]/", $newPassword)) {
            $error = "Le mot de passe doit contenir au moins une minuscule";
        } elseif (!preg_match("/[0-9]/", $newPassword)) {
            $error = "Le mot de passe doit contenir au moins un chiffre";
        } elseif (!preg_match("/[!@#$%^&*()_+\-=\[\]{};':\"\\\\|,.<>\/?]/", $newPassword)) {
            $error = "Le mot de passe doit contenir au moins un caractère spécial";
        } else {
            $user = $userModel->getUserById($_SESSION["userId"]);
            if (password_verify($currentPassword, $user["PSSWRD"])) {
                $userModel->updatePassword($_SESSION["userId"], $newPassword);
                Logger::log("PASSWORD_CHANGED", ["user_id" => $_SESSION["userId"]]);
                $success = "Mot de passe mis à jour avec succès";
            } else {
                Logger::log("PASSWORD_CHANGE_FAILED", ["user_id" => $_SESSION["userId"], "reason" => "wrong_current_password"]);
                $error = "Mot de passe actuel incorrect";
            }
        }
    }
}

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/profil.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
