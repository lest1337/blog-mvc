<?php
include_once "db.inc.php";

class Utilisateur {
    private PDO $pdo;
    function __construct() { $this->pdo = getPdo(); }

    function addUser($username, $email, $psswd) {
        $stmt = $this->pdo->prepare("INSERT INTO USERS (USERNAME, EMAIL, PSSWRD) VALUES(:username, :email, :psswd)");
        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":psswd" => $psswd ]);
    }

    function getUser($id) {
        $stmt = $this->pdo->prepare("SELECT USER_ID, USERNAME, EMAIL FROM USERS WHERE USER_ID = :id");
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}