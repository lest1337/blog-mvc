<?php
require_once "app/models/post.inc.php";

$postModel = new Post();
$query = $_GET["q"] ?? "";

if (!empty($query)) {
    $posts = $postModel->search($query);
    $searchQuery = $query;
} else {
    $posts = $postModel->getPosts();
    $searchQuery = "";
}

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/home.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
