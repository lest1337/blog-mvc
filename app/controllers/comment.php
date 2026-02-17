<?php
require_once "app/models/comment.inc.php";

if (isset($_GET["comment_content"]) && isset($_GET["id"])) {
    $commentContent = $_GET["comment_content"];
    $postId = $_GET["id"];

    $commentModel = new Comment();
    $commentModel->addComment($postId, $commentContent);
}