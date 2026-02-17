<?php
require_once "app/models/post.inc.php";
require_once "app/models/utilisateur.inc.php";
require_once "app/models/auth.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$postModel = new Post();
$userModel = new Utilisateur();
$loggedIn = isLoggedOn();

if (isset($_GET["id"])) {
    $post = $postModel->getSinglePost($_GET["id"]);
    $comments = $postModel->getComments($_GET["id"]);
} else {
    die();
};

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/post.view.php"; ?>
<?php require_once "app/controllers/comment.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
