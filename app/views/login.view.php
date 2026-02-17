<div>
    <h1>Se connecter</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="index.php?action=login" method="post">
        <div id="register">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </div>
    </form>
    <p>Pas de compte? <a href="index.php?action=register">S'inscrire</a></p>
</div>
