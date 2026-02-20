<?php
require_once "app/models/post.inc.php";

$postModel = new Post();

$postsPerPage = 5;
$page = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
$offset = ($page - 1) * $postsPerPage;

$totalPosts = $postModel->getPostCount();
$totalPages = ceil($totalPosts / $postsPerPage);

$posts = $postModel->getPosts($postsPerPage, $offset);

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/home.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
