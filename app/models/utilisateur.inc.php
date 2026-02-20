<?php
include_once "db.inc.php";
include_once "auth.inc.php";

class Utilisateur {
    private PDO $pdo;
    function __construct() { $this->pdo = getPdo(); }

    function addUser($username, $email, $psswd) {
        $stmt = $this->pdo->prepare("INSERT INTO USERS (USERNAME, EMAIL, PSSWRD) VALUES(:username, :email, :psswd)");
        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":psswd" => password_hash($psswd, CRYPT_SHA256) ]);
    }

    function getCurrentUserId() {
        if (isLoggedOn()) {
            return $_SESSION["userId"];
        }
    }

    function getUser($id) {
        $stmt = $this->pdo->prepare("SELECT USER_ID, USERNAME, EMAIL, IS_ADMIN, IS_RESTRICTED FROM USERS WHERE USER_ID = :id");
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getUserByMail($email) {
        $stmt = $this->pdo->prepare("SELECT USER_ID, USERNAME, EMAIL, PSSWRD, IS_ADMIN, IS_RESTRICTED FROM USERS WHERE EMAIL = :email");
        $stmt->execute([":email" => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT USER_ID, USERNAME, EMAIL, IS_ADMIN, IS_RESTRICTED FROM USERS WHERE USER_ID = :id");
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateUser($id, $username, $email) {
        $stmt = $this->pdo->prepare("UPDATE USERS SET USERNAME = :username, EMAIL = :email WHERE USER_ID = :id");
        $stmt->execute([
            ":id" => $id,
            ":username" => $username,
            ":email" => $email
        ]);
    }

    function updatePassword($id, $newPassword) {
        $stmt = $this->pdo->prepare("UPDATE USERS SET PSSWRD = :psswd WHERE USER_ID = :id");
        $stmt->execute([
            ":id" => $id,
            ":psswd" => password_hash($newPassword, CRYPT_SHA256)
        ]);
    }

    function getUserCount() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM USERS");
        return $stmt->fetch(PDO::FETCH_ASSOC)["count"];
    }

    function getUsersPaginated($limit = 20, $offset = 0) {
        $stmt = $this->pdo->prepare("SELECT USER_ID, USERNAME, EMAIL, IS_ADMIN, IS_RESTRICTED FROM USERS ORDER BY USER_ID LIMIT :limit OFFSET :offset");
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function restrictUser($id) {
        $stmt = $this->pdo->prepare("UPDATE USERS SET IS_RESTRICTED = 1 WHERE USER_ID = :id AND IS_ADMIN = 0");
        $stmt->execute([":id" => $id]);
    }

    function unrestrictUser($id) {
        $stmt = $this->pdo->prepare("UPDATE USERS SET IS_RESTRICTED = 0 WHERE USER_ID = :id");
        $stmt->execute([":id" => $id]);
    }

    function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM COMMENTS WHERE USER_ID = :id");
        $stmt->execute([":id" => $id]);

        $stmt = $this->pdo->prepare("DELETE FROM USERS WHERE USER_ID = :id AND IS_ADMIN = 0");
        $stmt->execute([":id" => $id]);
    }

    function getAllUsers() {
        $stmt = $this->pdo->query("SELECT USER_ID, USERNAME, EMAIL, IS_ADMIN, IS_RESTRICTED FROM USERS ORDER BY USER_ID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}