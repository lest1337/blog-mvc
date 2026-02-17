<?php
include_once "app/models/db.inc.php";
include_once "app/models/utilisateur.inc.php";

class Comment {
    private PDO $pdo;
    private Utilisateur $user;

    function __construct()
    {
        $this->pdo = getPdo();
        // $this->user => Ajouter l'utilisateur courant
    }

    function addComment($postId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO COMMENTS (POST_ID, USER_ID, CONTENT) VALUES (:postId, :userId, :Content)");
        $stmt->execute([
            ":postId" => $postId,
            ":userId" => 1,
            ":content" => $content
        ]);
    }
}