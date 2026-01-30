<?php
require_once "app/models/post.inc.php";

$postModel = new Post();
$posts = $postModel->getPosts();

require_once "app/views/header.view.php";
require_once "app/views/home.view.php";
require_once "app/views/footer.view.php";