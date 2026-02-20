<div id="admin">
    <h1>Panel Admin</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number"><?= $stats["users"] ?></span>
            <span class="stat-label">Utilisateurs</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $stats["posts"] ?></span>
            <span class="stat-label">Articles</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $stats["comments"] ?></span>
            <span class="stat-label">Commentaires</span>
        </div>
    </div>
    
    <div class="admin-section">
        <h2>Gestion des commentaires</h2>
        
        <div class="search-box">
            <input type="text" id="comment-search" placeholder="Rechercher un commentaire ou utilisateur..." oninput="filterComments()">
            <div class="search-results-count" id="results-count"></div>
        </div>
        
        <?php if (!empty($allComments)): ?>
            <table class="admin-table" id="comments-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Auteur</th>
                        <th>Article</th>
                        <th>Contenu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="comments-tbody">
                    <?php foreach ($allComments as $comment): ?>
                        <tr class="comment-row" data-username="<?= strtolower(htmlspecialchars($comment["USERNAME"])) ?>" data-content="<?= strtolower(htmlspecialchars($comment["CONTENT"])) ?>">
                            <td><?= $comment["COMMENT_ID"] ?></td>
                            <td class="comment-author"><?= htmlspecialchars($comment["USERNAME"]) ?></td>
                            <td><a href="index.php?action=post&id=<?= $comment["POST_ID"] ?>"><?= htmlspecialchars($comment["post_title"]) ?></a></td>
                            <td class="comment-content"><?= htmlspecialchars($comment["CONTENT"]) ?></td>
                            <td>
                                <a href="index.php?action=admin&delete_comment=<?= $comment["COMMENT_ID"] ?>" class="btn-delete" onclick="return confirm('Supprimer ce commentaire?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="no-data" id="no-results" style="display:none;">Aucun résultat</p>
        <?php else: ?>
            <p class="no-data">Aucun commentaire</p>
        <?php endif; ?>
    </div>
    
    <div class="admin-section">
        <h2>Utilisateurs</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user["USER_ID"] ?></td>
                        <td><?= htmlspecialchars($user["USERNAME"]) ?></td>
                        <td><?= htmlspecialchars($user["EMAIL"]) ?></td>
                        <td><?= $user["IS_ADMIN"] ? "Oui" : "Non" ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
#admin {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

#admin h1 {
    font-size: 24px;
    margin-bottom: 24px;
    color: var(--text-primary);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

.stat-card {
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    padding: 24px;
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 36px;
    font-weight: bold;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.stat-label {
    font-size: 12px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.admin-section {
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    padding: 24px;
    margin-bottom: 24px;
}

.admin-section h2 {
    font-size: 16px;
    margin: 0 0 20px 0;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 12px;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.search-box input {
    flex: 1;
    padding: 10px 14px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-primary);
    background-color: var(--bg-input);
    border: 1px solid var(--border-input);
    outline: none;
}

.search-box input:focus {
    border-color: var(--text-primary);
}

.search-box input::placeholder {
    color: var(--text-dim);
}

.search-results-count {
    font-size: 12px;
    color: var(--text-muted);
    white-space: nowrap;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.admin-table th,
.admin-table td {
    padding: 10px 12px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.admin-table th {
    color: var(--text-muted);
    font-weight: normal;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
}

.admin-table td {
    color: var(--text-secondary);
}

.admin-table .comment-content {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.comment-row.hidden {
    display: none;
}

.btn-delete {
    color: var(--error);
    font-size: 12px;
}

.btn-delete:hover {
    text-decoration: underline;
}

.no-data {
    color: var(--text-muted);
    text-align: center;
    padding: 20px;
}
</style>

<script>
function filterComments() {
    const searchInput = document.getElementById('comment-search').value.toLowerCase().trim();
    const rows = document.querySelectorAll('.comment-row');
    const noResults = document.getElementById('no-results');
    const table = document.getElementById('comments-table');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const username = row.dataset.username;
        const content = row.dataset.content;
        
        if (searchInput === '' || username.includes(searchInput) || content.includes(searchInput)) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });
    
    if (visibleCount === 0) {
        noResults.style.display = 'block';
        table.style.display = 'none';
    } else {
        noResults.style.display = 'none';
        table.style.display = 'table';
    }
    
    document.getElementById('results-count').textContent = searchInput ? `${visibleCount} résultat${visibleCount !== 1 ? 's' : ''}` : '';
}
</script>
