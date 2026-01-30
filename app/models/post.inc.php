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
        $stmt = $this->pdo->prepare("SELECT CONTENT, USER_ID, POST_ID FROM COMMENTS WHERE POST_ID = :postId");
        $stmt->execute([":postId" => $postId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}