<?php
include "app/controllers/main.php";

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "default";
}

$file = rout($action);
require_once "app/controllers/" . $file;