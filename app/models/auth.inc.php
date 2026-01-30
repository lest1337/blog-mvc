<?php
include_once "app/models/utilisateur.inc.php";

function login($email, $password) {
    if (!isset($_SESSION)) {
        session_start();
    }

    $userModel = new Utilisateur();
    $user = $userModel->getUserByMail($email);
    $userPassword = $user["PSSWRD"];

    if ($password == $userPassword) {
        $_SESSION["userId"] = $user["USER_ID"];
        $_SESSION["email"] = $user["EMAIL"];
        $_SESSION["password"] = $user["PSSWRD"];
    }
}

function isLoggedOn() {
    $res = false;

    if (isset($_SESSION["email"])) {
        $userModel = new Utilisateur();
        $user = $userModel->getUserByMail($_SESSION["email"]);

        if ($user["PASSWRD"] == $_SESSION["password"] && $user["EMAIL"] == $_SESSION["email"]) {
            $res = true;
        }
    }
    return $res;
}