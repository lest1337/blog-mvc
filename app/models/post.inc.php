<?php
include_once "db.inc.php";

class Post {
    private PDO $pdo;
    function __construct() { $this->pdo = getPdo(); }

    function getPosts() {
        $stmt = $this->pdo->prepare("SELECT POST_ID, TITLE, CONTENT, PUBLISH_DATE FROM POSTS");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getSinglePost($postId) {
        $stmt = $this->pdo->prepare("SELECT POST_ID, TITLE, CONTENT, PUBLISH_DATE FROM POSTS WHERE POST_ID = :postId");
        $stmt->execute([":postId" => $postId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getComments($postId) {
        $stmt = $this->pdo->prepare("SELECT c.CONTENT, c.USER_ID, c.POST_ID, u.USERNAME FROM COMMENTS c JOIN USERS u ON c.USER_ID = u.USER_ID WHERE c.POST_ID = :postId");
        $stmt->execute([":postId" => $postId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}