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

if (isset($_GET["comment_id"]) && isset($_GET["post_id"])) {
    $commentModel = new Comment();
    $userId = $_SESSION["userId"];
    $username = $_SESSION["username"] ?? "-";
    $commentId = $_GET["comment_id"];
    $postId = $_GET["post_id"];

    $comment = $commentModel->getCommentById($commentId);
    
    if ($comment && $comment["USER_ID"] == $userId) {
        $commentModel->deleteComment($commentId, $userId);
        Logger::log("COMMENT_DELETED", ["comment_id" => $commentId, "post_id" => $postId, "user_id" => $userId, "username" => $username]);
    }

    header("Location: index.php?action=post&id=" . $postId);
    exit;
}

header("Location: index.php");
exit;
