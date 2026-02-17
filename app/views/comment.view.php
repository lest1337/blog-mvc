<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<div id="comments">
    <h3>Commentaires</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <strong><?= htmlspecialchars($comment["USERNAME"]) ?></strong>
                <p><?= htmlspecialchars($comment["CONTENT"]) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Pas encore de commentaire. Soyez le premier!</p>
    <?php endif; ?>
</div>

<?php if ($loggedIn): ?>
<div id="addComment">
    <h3>Ajouter un commentaire</h3>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="comment_content" placeholder="Ecrivez votre commentaire ici" required>
        <button type="submit">Envoyer</button>
    </form>
</div>
<?php else: ?>
<p><a href="index.php?action=login">Connectez-vous</a> pour laisser un commentaire.</p>
<?php endif; ?>
