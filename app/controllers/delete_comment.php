<?php
require_once "app/models/comment.inc.php";
require_once "app/models/auth.inc.php";

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
    $commentId = $_GET["comment_id"];
    $postId = $_GET["post_id"];

    $comment = $commentModel->getCommentById($commentId);
    
    if ($comment && $comment["USER_ID"] == $userId) {
        $commentModel->deleteComment($commentId, $userId);
    }

    header("Location: index.php?action=post&id=" . $postId);
    exit;
}

header("Location: index.php");
exit;
