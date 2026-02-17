<?php
require_once "app/models/auth.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isLoggedOn();
?>
<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" herf="assets/images/CSB.ico">
    <title>Le CSBlog</title>
</head>
<!-- Navbar -->
<div id="navbar">
     <ul>
    <li><a href="./?action=default"> Home </a></li>
    <?php if (!$loggedIn): ?>
    <li><a href="./?action=register"> Register </a></li>
    <li><a href="./?action=login"> Log In </a></li>
    <?php else: ?>
    <li><a href="./?action=logout"> Log Out (<?= htmlspecialchars($_SESSION["username"] ?? "") ?>)</a></li>
    <?php endif; ?>
    <li><a href="./?action=aboutus"> About us </a></li>
 </ul>
</div>
<hr>
