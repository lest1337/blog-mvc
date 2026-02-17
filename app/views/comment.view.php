<div id="comments">
    <h3>Commentaires</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment" 
                 data-comment-id="<?= $comment["COMMENT_ID"] ?>" 
                 data-user-id="<?= $comment["USER_ID"] ?>"
                 data-post-id="<?= $comment["POST_ID"] ?>">
                <strong><?= htmlspecialchars($comment["USERNAME"]) ?></strong>
                <p data-comment-content="<?= htmlspecialchars($comment["CONTENT"]) ?>"><?= htmlspecialchars($comment["CONTENT"]) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Pas encore de commentaire. Soyez le premier!</p>
    <?php endif; ?>
</div>

<div id="context-menu" class="context-menu">
    <ul>
        <li id="ctx-edit">Modifier</li>
        <li id="ctx-delete">Supprimer</li>
    </ul>
</div>

<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3>Modifier le commentaire</h3>
        <form id="edit-comment-form" method="post" action="index.php?action=edit_comment">
            <input type="hidden" name="comment_id" id="modal-comment-id">
            <input type="hidden" name="post_id" id="modal-post-id">
            <textarea name="content" id="modal-comment-content" required></textarea>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>

<?php if ($loggedIn): ?>
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
<?php else: ?>
<p><a href="index.php?action=login">Connectez-vous</a> pour laisser un commentaire.</p>
<?php endif; ?>

<style>
.context-menu {
    display: none;
    position: fixed;
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    z-index: 1000;
    min-width: 120px;
}

.context-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.context-menu li {
    padding: 10px 16px;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 13px;
}

.context-menu li:hover {
    background-color: var(--border-color);
    color: var(--text-primary);
}

.context-menu li#ctx-delete:hover {
    color: var(--error);
}

.modal {
    display: none;
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
}

.modal-content {
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    margin: 10% auto;
    padding: 24px;
    width: 90%;
    max-width: 500px;
    position: relative;
}

.modal-content h3 {
    margin-top: 0;
    color: var(--text-primary);
    font-size: 16px;
    margin-bottom: 16px;
}

.modal-content textarea {
    width: 100%;
    min-height: 100px;
    padding: 12px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-primary);
    background-color: var(--bg-input);
    border: 1px solid var(--border-input);
    resize: vertical;
    outline: none;
}

.modal-content textarea:focus {
    border-color: var(--text-primary);
}

.modal-content button {
    margin-top: 12px;
    padding: 10px 20px;
    font-size: 12px;
    font-family: inherit;
    color: var(--bg-primary);
    background-color: var(--success);
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.modal-content button:hover {
    background-color: var(--accent);
}

.close-modal {
    position: absolute;
    right: 16px;
    top: 12px;
    font-size: 24px;
    font-weight: bold;
    color: var(--text-dim);
    cursor: pointer;
}

.close-modal:hover {
    color: var(--text-primary);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contextMenu = document.getElementById('context-menu');
    const editModal = document.getElementById('edit-modal');
    const closeModal = document.querySelector('.close-modal');
    const editForm = document.getElementById('edit-comment-form');
    const currentUserId = <?= json_encode($_SESSION["userId"] ?? null) ?>;
    
    let selectedComment = null;

    document.querySelectorAll('.comment').forEach(comment => {
        comment.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            
            const commentUserId = parseInt(this.dataset.userId);
            
            if (currentUserId !== commentUserId) {
                return;
            }
            
            selectedComment = this;
            
            contextMenu.style.display = 'block';
            contextMenu.style.left = e.pageX + 'px';
            contextMenu.style.top = e.pageY + 'px';
        });
    });

    document.addEventListener('click', function(e) {
        if (!contextMenu.contains(e.target)) {
            contextMenu.style.display = 'none';
        }
        if (!editModal.contains(e.target) || e.target === closeModal) {
            editModal.style.display = 'none';
        }
    });

    document.getElementById('ctx-edit').addEventListener('click', function() {
        if (!selectedComment) return;
        
        const commentId = selectedComment.dataset.commentId;
        const postId = selectedComment.dataset.postId;
        const content = selectedComment.querySelector('p').dataset.commentContent;
        
        document.getElementById('modal-comment-id').value = commentId;
        document.getElementById('modal-post-id').value = postId;
        document.getElementById('modal-comment-content').value = content;
        
        contextMenu.style.display = 'none';
        editModal.style.display = 'block';
    });

    document.getElementById('ctx-delete').addEventListener('click', function() {
        if (!selectedComment) return;
        
        const commentId = selectedComment.dataset.commentId;
        const postId = selectedComment.dataset.postId;
        
        if (confirm('Voulez-vous vraiment supprimer ce commentaire?')) {
            window.location.href = 'index.php?action=delete_comment&comment_id=' + commentId + '&post_id=' + postId;
        }
        
        contextMenu.style.display = 'none';
    });

    closeModal.addEventListener('click', function() {
        editModal.style.display = 'none';
    });
});
</script>
