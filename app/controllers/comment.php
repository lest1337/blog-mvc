<?php
require_once "app/models/comment.inc.php";
require_once "app/models/utilisateur.inc.php";

if (isset($_GET["comment_content"]) && isset($_GET["id"])) {
    $commentModel = new Comment();
    $userModel = new Utilisateur();

    $commentContent = $_GET["comment_content"];
    $postId = $_GET["id"];
    $userId = $userModel->getCurrentUserId();

    $commentModel->addComment($postId, $userId, $commentContent);
}

require_once "app/views/comment.view.php";