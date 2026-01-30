<?php
function rout($action) {
    $actions = array(
        "default" => "home.php",
        "post" => "post.php"
    );

    if (array_key_exists($action, $actions)) {
        return $actions[$action];
    } else {
        return $actions["default"];
    }
}