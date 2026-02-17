<?php
function rout($action) {
    $actions = array(
        "default" => "home.php",
        "post" => "post.php",
        "register" => "register.php",
        "login" => "login.php",
        "logout" => "logout.php",
        "search" => "search.php",
        "profil" => "profil.php"
    );

    if (array_key_exists($action, $actions)) {
        return $actions[$action];
    } else {
        return $actions["default"];
    }
}