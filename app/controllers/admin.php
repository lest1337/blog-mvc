<?php
require_once "app/models/utilisateur.inc.php";
require_once "app/models/post.inc.php";
require_once "app/models/comment.inc.php";
require_once "app/models/auth.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedOn()) {
    header("Location: index.php?action=login");
    exit;
}

if (!isAdmin()) {
    header("Location: index.php");
    exit;
}

$userModel = new Utilisateur();
$postModel = new Post();
$commentModel = new Comment();

$stats = [
    "users" => $userModel->getUserCount(),
    "posts" => $postModel->getPostCount(),
    "comments" => $postModel->getCommentCount()
];

$allComments = $commentModel->getAllComments();
$users = $userModel->getAllUsers();

if (isset($_GET["delete_comment"])) {
    $commentId = $_GET["delete_comment"];
    $commentModel->deleteCommentById($commentId);
    header("Location: index.php?action=admin");
    exit;
}

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/admin.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
