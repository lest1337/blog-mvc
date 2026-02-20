<?php
require_once "app/models/logger.inc.php";

function isLoggedOn()
{
    $res = false;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["userId"])) {
        $res = true;
    }
    return $res;
}

function isAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) {
        return true;
    }
    return false;
}

function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION["userId"] ?? null;
    $username = $_SESSION["username"] ?? "-";
    
    if ($userId) {
        Logger::log("LOGOUT", ["user_id" => $userId, "username" => $username]);
    }

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}
