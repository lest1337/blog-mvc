<?php

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

function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}
