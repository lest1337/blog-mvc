<?php
require_once "app/models/comment.inc.php";
require_once "app/models/utilisateur.inc.php";
require_once "app/models/auth.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = null;
$loggedIn = isLoggedOn();

if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_content"]) && isset($_GET["id"])) {
    $commentModel = new Comment();
    $userModel = new Utilisateur();

    $commentContent = $_POST["comment_content"];
    $postId = $_GET["id"];
    $userId = $_SESSION["userId"];

    if (!empty(trim($commentContent))) {
        $commentModel->addComment($postId, $userId, $commentContent);
        header("Location: index.php?action=post&id=" . $postId);
        exit;
    } else {
        $error = "Le commentaire ne peut pas être vide";
    }
}

require_once "app/views/comment.view.php";
