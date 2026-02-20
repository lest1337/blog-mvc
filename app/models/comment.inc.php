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

    function getAllComments() {
        $stmt = $this->pdo->query("SELECT c.COMMENT_ID, c.CONTENT, c.USER_ID, c.POST_ID, c.POST_ID as post_title, u.USERNAME, p.TITLE as post_title FROM COMMENTS c JOIN USERS u ON c.USER_ID = u.USER_ID JOIN POSTS p ON c.POST_ID = p.POST_ID ORDER BY COMMENT_ID DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCommentsPaginated($limit = 20, $offset = 0) {
        $stmt = $this->pdo->prepare("SELECT c.COMMENT_ID, c.CONTENT, c.USER_ID, c.POST_ID, u.USERNAME, p.TITLE as post_title FROM COMMENTS c JOIN USERS u ON c.USER_ID = u.USER_ID JOIN POSTS p ON c.POST_ID = p.POST_ID ORDER BY COMMENT_ID DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteCommentById($commentId) {
        $stmt = $this->pdo->prepare("DELETE FROM COMMENTS WHERE COMMENT_ID = :commentId");
        $stmt->execute([":commentId" => $commentId]);
    }
}