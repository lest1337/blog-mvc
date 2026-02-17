<?php
require_once "app/models/auth.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isLoggedOn();
?>
<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" href="assets/images/csb.png">
    <title>Le CSBlog</title>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        })();
    </script>
</head>
<!-- Navbar -->
<div id="navbar">
    <div class="navbar-content">
        <ul class="nav-links">
            <li><a href="./?action=default">Home</a></li>
            <?php if (!$loggedIn): ?>
            <li><a href="./?action=register">Register</a></li>
            <li><a href="./?action=login">Log In</a></li>
            <?php else: ?>
            <li><a href="./?action=logout">Log Out (<?= htmlspecialchars($_SESSION["username"] ?? "") ?>)</a></li>
            <?php endif; ?>
            <li><a href="./?action=aboutus">About us</a></li>
        </ul>
        <div class="nav-right">
            <form class="search-form" action="./?action=search" method="get">
                <input type="hidden" name="action" value="search">
                <input type="text" name="q" placeholder="Search...">
            </form>
            <button class="theme-toggle" onclick="toggleTheme()">Light</button>
        </div>
    </div>
</div>
<hr>
<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        if (newTheme === 'dark') {
            html.removeAttribute('data-theme');
        } else {
            html.setAttribute('data-theme', newTheme);
        }
        
        localStorage.setItem('theme', newTheme);
        
        document.querySelector('.theme-toggle').textContent = newTheme === 'light' ? 'Dark' : 'Light';
    }

    (function() {
        const savedTheme = localStorage.getItem('theme');
        document.querySelector('.theme-toggle').textContent = savedTheme === 'light' ? 'Dark' : 'Light';
    })();
</script>
