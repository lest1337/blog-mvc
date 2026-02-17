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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_id"]) && isset($_POST["content"])) {
    $commentModel = new Comment();
    $userId = $_SESSION["userId"];
    $commentId = $_POST["comment_id"];
    $content = $_POST["content"];
    $postId = $_POST["post_id"] ?? null;

    $comment = $commentModel->getCommentById($commentId);
    
    if ($comment && $comment["USER_ID"] == $userId && !empty(trim($content))) {
        $commentModel->updateComment($commentId, $userId, trim($content));
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
