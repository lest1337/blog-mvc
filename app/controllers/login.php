<?php
require_once "app/models/utilisateur.inc.php";
require_once "app/models/auth.inc.php";
require_once "app/models/logger.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        $userModel = new Utilisateur();
        $user = $userModel->getUserByMail($email);

        if ($user && password_verify($password, $user["PSSWRD"])) {
            $_SESSION["userId"] = $user["USER_ID"];
            $_SESSION["email"] = $user["EMAIL"];
            $_SESSION["username"] = $user["USERNAME"];
            $_SESSION["isAdmin"] = $user["IS_ADMIN"] ?? 0;
            
            Logger::log("LOGIN_SUCCESS", ["email" => $email, "user_id" => $user["USER_ID"]]);
            
            header("Location: index.php");
            exit;
        } else {
            Logger::log("LOGIN_FAILED", ["email" => $email]);
            $error = "Email ou mot de passe incorrect";
        }
    }
}

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/login.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
