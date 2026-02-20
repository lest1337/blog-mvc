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

$itemsPerPage = 15;
$searchQuery = $_GET["search"] ?? "";
$activeTab = $_GET["tab"] ?? "posts";

$posts = $postModel->getAllPosts();
$allComments = $commentModel->getAllComments();
$users = $userModel->getAllUsers();

if (!empty($searchQuery)) {
    $searchLower = strtolower($searchQuery);
    
    $posts = array_filter($posts, function($p) use ($searchLower) {
        return strpos(strtolower($p["TITLE"]), $searchLower) !== false || 
               strpos(strtolower($p["CONTENT"]), $searchLower) !== false;
    });
    
    $allComments = array_filter($allComments, function($c) use ($searchLower) {
        return strpos(strtolower($c["USERNAME"]), $searchLower) !== false || 
               strpos(strtolower($c["CONTENT"]), $searchLower) !== false;
    });
    
    $users = array_filter($users, function($u) use ($searchLower) {
        return strpos(strtolower($u["USERNAME"]), $searchLower) !== false || 
               strpos(strtolower($u["EMAIL"]), $searchLower) !== false;
    });
    
    $posts = array_values($posts);
    $allComments = array_values($allComments);
    $users = array_values($users);
}

$currentPage = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;

if ($activeTab === "posts") {
    $totalItems = count($posts);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $offset = ($currentPage - 1) * $itemsPerPage;
    $displayItems = array_slice($posts, $offset, $itemsPerPage);
} elseif ($activeTab === "comments") {
    $totalItems = count($allComments);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $offset = ($currentPage - 1) * $itemsPerPage;
    $displayItems = array_slice($allComments, $offset, $itemsPerPage);
} else {
    $totalItems = count($users);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $offset = ($currentPage - 1) * $itemsPerPage;
    $displayItems = array_slice($users, $offset, $itemsPerPage);
}

if (isset($_GET["delete_comment"])) {
    $commentId = $_GET["delete_comment"];
    $commentModel->deleteCommentById($commentId);
    header("Location: index.php?action=admin" . ($activeTab !== "posts" ? "&tab=" . $activeTab : ""));
    exit;
}

if (isset($_GET["delete_post"])) {
    $postId = $_GET["delete_post"];
    $postModel->deletePost($postId);
    header("Location: index.php?action=admin");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create_post"])) {
    $title = $_POST["title"] ?? "";
    $content = $_POST["content"] ?? "";
    
    if (!empty($title) && !empty($content)) {
        $postModel->createPost($title, $content);
        header("Location: index.php?action=admin");
        exit;
    }
}

require_once "app/views/header.view.php";
?>
<main>
<?php require_once "app/views/admin.view.php"; ?>
</main>
<?php require_once "app/views/footer.view.php"; ?>
