<div id="comments">
    <h3>Commentaires</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <?php if ($currentUserId && $currentUserId == $comment["USER_ID"]): ?>
            <div class="comment own-comment" 
                 data-comment-id="<?= $comment["COMMENT_ID"] ?>" 
                 data-user-id="<?= $comment["USER_ID"] ?>"
                 data-post-id="<?= $comment["POST_ID"] ?>"
                 oncontextmenu="showCommentMenu(event, <?= $comment["COMMENT_ID"] ?>, <?= $comment["POST_ID"] ?>, '<?= htmlspecialchars(addslashes($comment["CONTENT"])) ?>')">
                <strong><?= htmlspecialchars($comment["USERNAME"]) ?></strong>
                <p><?= htmlspecialchars($comment["CONTENT"]) ?></p>
            </div>
            <?php else: ?>
            <div class="comment">
                <strong><?= htmlspecialchars($comment["USERNAME"]) ?></strong>
                <p><?= htmlspecialchars($comment["CONTENT"]) ?></p>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Pas encore de commentaire. Soyez le premier!</p>
    <?php endif; ?>
</div>

<div id="comment-menu" style="display:none; position:fixed; background:var(--bg-secondary); border:1px solid var(--border-color); z-index:1000; min-width:120px;">
    <div style="padding:10px 16px; cursor:pointer; color:var(--text-secondary);" onclick="editComment()">Modifier</div>
    <div style="padding:10px 16px; cursor:pointer; color:var(--error);" onclick="deleteComment()">Supprimer</div>
    <div style="padding:10px 16px; cursor:pointer; color:var(--text-dim);" onclick="hideCommentMenu()">Annuler</div>
</div>

<div id="edit-modal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.7);">
    <div style="background:var(--bg-secondary); border:1px solid var(--border-color); margin:10% auto; padding:24px; width:90%; max-width:500px; position:relative;">
        <span onclick="closeModal()" style="position:absolute; right:16px; top:12px; font-size:24px; cursor:pointer; color:var(--text-dim);">&times;</span>
        <h3 style="margin-top:0; color:var(--text-primary);">Modifier le commentaire</h3>
        <form method="post" action="index.php?action=edit_comment">
            <input type="hidden" name="comment_id" id="modal-comment-id">
            <input type="hidden" name="post_id" id="modal-post-id">
            <textarea name="content" id="modal-comment-content" required style="width:100%; min-height:100px; padding:12px; font-size:13px; font-family:inherit; color:var(--text-primary); background:var(--bg-input); border:1px solid var(--border-input); resize:vertical; outline:none;"></textarea>
            <button type="submit" style="margin-top:12px; padding:10px 20px; font-size:12px; color:var(--bg-primary); background:var(--success); border:none; cursor:pointer;">Enregistrer</button>
        </form>
    </div>
</div>

<?php if ($loggedIn): ?>
    <?php if ($isRestricted): ?>
    <div id="addComment">
        <p style="color: var(--error);">Votre compte est restreint. Vous ne pouvez pas commenter.</p>
    </div>
    <?php else: ?>
    <div id="addComment">
        <h3>Ajouter un commentaire</h3>
        <?php if (isset($error)): ?>
            <p style="color: var(--error);"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="comment_content" placeholder="Ecrivez votre commentaire ici" required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <?php endif; ?>
<?php else: ?>
<p><a href="index.php?action=login">Connectez-vous</a> pour laisser un commentaire.</p>
<?php endif; ?>

<script>
var currentCommentId = null;
var currentPostId = null;

function showCommentMenu(e, commentId, postId, content) {
    e.preventDefault();
    e.stopPropagation();
    currentCommentId = commentId;
    currentPostId = postId;
    
    var menu = document.getElementById('comment-menu');
    menu.style.display = 'block';
    menu.style.left = e.pageX + 'px';
    menu.style.top = e.pageY + 'px';
    
    menu.setAttribute('data-content', content);
}

function hideCommentMenu() {
    document.getElementById('comment-menu').style.display = 'none';
}

function editComment() {
    var menu = document.getElementById('comment-menu');
    var content = menu.getAttribute('data-content');
    
    document.getElementById('modal-comment-id').value = currentCommentId;
    document.getElementById('modal-post-id').value = currentPostId;
    document.getElementById('modal-comment-content').value = content;
    
    hideCommentMenu();
    document.getElementById('edit-modal').style.display = 'block';
}

function deleteComment() {
    if (confirm('Voulez-vous vraiment supprimer ce commentaire?')) {
        window.location.href = 'index.php?action=delete_comment&comment_id=' + currentCommentId + '&post_id=' + currentPostId;
    }
    hideCommentMenu();
}

function closeModal() {
    document.getElementById('edit-modal').style.display = 'none';
}

document.addEventListener('click', function(e) {
    if (!document.getElementById('comment-menu').contains(e.target)) {
        hideCommentMenu();
    }
    if (e.target.id === 'edit-modal') {
        closeModal();
    }
});
</script>
