<?php
include_once "app/models/db.inc.php";
include_once "app/models/utilisateur.inc.php";

class Comment {
    private PDO $pdo;

    function __construct()
    {
        $this->pdo = getPdo();
    }

    function addComment($postId, $userId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO COMMENTS (POST_ID, USER_ID, CONTENT) VALUES (:postId, :userId, :content)");
        $stmt->execute([
            ":postId" => $postId,
            ":userId" => $userId,
            ":content" => $content
        ]);
    }
}