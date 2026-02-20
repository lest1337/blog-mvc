<?php
require_once "app/models/comment.inc.php";
require_once "app/models/auth.inc.php";
require_once "app/models/logger.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedOn()) {
    header("Location: index.php?action=login");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_id"]) && isset($_POST["content"])) {
    $commentModel = new Comment();
    $userId = $_SESSION["userId"];
    $username = $_SESSION["username"] ?? "-";
    $commentId = $_POST["comment_id"];
    $content = $_POST["content"];
    $postId = $_POST["post_id"] ?? null;

    $comment = $commentModel->getCommentById($commentId);
    
    if ($comment && $comment["USER_ID"] == $userId && !empty(trim($content))) {
        $commentModel->updateComment($commentId, $userId, trim($content));
        Logger::log("COMMENT_EDITED", ["comment_id" => $commentId, "post_id" => $postId, "user_id" => $userId, "username" => $username]);
    }

    if ($postId) {
        header("Location: index.php?action=post&id=" . $postId);
    } else {
        header("Location: index.php");
    }
    exit;
}

header("Location: index.php");
exit;
