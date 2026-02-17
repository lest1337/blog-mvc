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

    function updateComment($commentId, $userId, $content) {
        $stmt = $this->pdo->prepare("UPDATE COMMENTS SET CONTENT = :content WHERE COMMENT_ID = :commentId AND USER_ID = :userId");
        $stmt->execute([
            ":commentId" => $commentId,
            ":userId" => $userId,
            ":content" => $content
        ]);
    }

    function deleteComment($commentId, $userId) {
        $stmt = $this->pdo->prepare("DELETE FROM COMMENTS WHERE COMMENT_ID = :commentId AND USER_ID = :userId");
        $stmt->execute([
            ":commentId" => $commentId,
            ":userId" => $userId
        ]);
    }

    function getCommentById($commentId) {
        $stmt = $this->pdo->prepare("SELECT COMMENT_ID, CONTENT, USER_ID, POST_ID FROM COMMENTS WHERE COMMENT_ID = :commentId");
        $stmt->execute([":commentId" => $commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}