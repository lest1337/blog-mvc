<?php
require_once "app/models/comment.inc.php";
require_once "app/models/utilisateur.inc.php";
require_once "app/models/auth.inc.php";
require_once "app/models/logger.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = null;
$loggedIn = isLoggedOn();
$currentUserId = $_SESSION["userId"] ?? null;

if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_content"]) && isset($_GET["id"])) {
    $commentModel = new Comment();
    $userModel = new Utilisateur();

    $commentContent = $_POST["comment_content"];
    $postId = $_GET["id"];
    $userId = $_SESSION["userId"];
    $username = $_SESSION["username"] ?? "-";

    if (!empty(trim($commentContent))) {
        $commentModel->addComment($postId, $userId, $commentContent);
        Logger::log("COMMENT_CREATED", ["post_id" => $postId, "user_id" => $userId, "username" => $username]);
        header("Location: index.php?action=post&id=" . $postId);
        exit;
    } else {
        $error = "Le commentaire ne peut pas être vide";
    }
}

require_once "app/views/comment.view.php";
