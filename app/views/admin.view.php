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
    
    <div class="admin-tabs">
        <a href="./?action=admin&tab=posts" class="tab-btn <?= $activeTab === 'posts' ? 'active' : '' ?>">Articles</a>
        <a href="./?action=admin&tab=comments" class="tab-btn <?= $activeTab === 'comments' ? 'active' : '' ?>">Commentaires</a>
        <a href="./?action=admin&tab=users" class="tab-btn <?= $activeTab === 'users' ? 'active' : '' ?>">Utilisateurs</a>
    </div>
    
    <div class="admin-section">
        <div class="search-box">
            <input type="text" id="admin-search" placeholder="Rechercher..." value="<?= htmlspecialchars($searchQuery) ?>">
            <button class="search-btn" onclick="doSearch()">Rechercher</button>
            <?php if (!empty($searchQuery)): ?>
                <a href="./?action=admin&tab=<?= $activeTab ?>" class="clear-search">✕</a>
            <?php endif; ?>
            <span class="results-count"><?= $totalItems ?> résultat<?= $totalItems !== 1 ? 's' : '' ?></span>
        </div>
        
        <?php if ($activeTab === "posts"): ?>
            <form method="post" class="create-form">
                <input type="hidden" name="create_post" value="1">
                <div class="form-row">
                    <input type="text" name="title" placeholder="Titre de l'article" required>
                    <button type="submit">Créer</button>
                </div>
                <textarea name="content" placeholder="Contenu de l'article" rows="2" required></textarea>
            </form>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($displayItems as $post): ?>
                        <tr>
                            <td><?= $post["POST_ID"] ?></td>
                            <td><a href="index.php?action=post&id=<?= $post["POST_ID"] ?>"><?= htmlspecialchars($post["TITLE"]) ?></a></td>
                            <td><?= $post["PUBLISH_DATE"] ?></td>
                            <td>
                                <a href="index.php?action=admin&delete_post=<?= $post["POST_ID"] ?>" class="btn-delete" onclick="return confirm('Supprimer cet article?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($activeTab === "comments"): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Auteur</th>
                        <th>Article</th>
                        <th>Contenu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($displayItems as $comment): ?>
                        <tr>
                            <td><?= $comment["COMMENT_ID"] ?></td>
                            <td><?= htmlspecialchars($comment["USERNAME"]) ?></td>
                            <td><a href="index.php?action=post&id=<?= $comment["POST_ID"] ?>"><?= htmlspecialchars($comment["post_title"]) ?></a></td>
                            <td class="comment-content"><?= htmlspecialchars($comment["CONTENT"]) ?></td>
                            <td>
                                <a href="index.php?action=admin&delete_comment=<?= $comment["COMMENT_ID"] ?>&tab=comments" class="btn-delete" onclick="return confirm('Supprimer?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
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
                    <?php foreach ($displayItems as $user): ?>
                        <tr>
                            <td><?= $user["USER_ID"] ?></td>
                            <td><?= htmlspecialchars($user["USERNAME"]) ?></td>
                            <td><?= htmlspecialchars($user["EMAIL"]) ?></td>
                            <td><?= $user["IS_ADMIN"] ? "Oui" : "Non" ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="./?action=admin&tab=<?= $activeTab ?>&page=<?= $currentPage - 1 ?><?= !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" class="page-btn">&laquo;</a>
            <?php endif; ?>
            
            <?php 
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            if ($startPage > 1) {
                echo '<a href="./?action=admin&tab=' . $activeTab . '&page=1' . (!empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '') . '" class="page-btn">1</a>';
                if ($startPage > 2) echo '<span class="page-ellipsis">...</span>';
            }
            
            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <span class="page-current"><?= $i ?></span>
                <?php else: ?>
                    <a href="./?action=admin&tab=<?= $activeTab ?>&page=<?= $i ?><?= !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" class="page-btn"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($endPage < $totalPages): ?>
                <?php if ($endPage < $totalPages - 1) echo '<span class="page-ellipsis">...</span>'; ?>
                <a href="./?action=admin&tab=<?= $activeTab ?>&page=<?= $totalPages ?><?= !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" class="page-btn"><?= $totalPages ?></a>
            <?php endif; ?>
            
            <?php if ($currentPage < $totalPages): ?>
                <a href="./?action=admin&tab=<?= $activeTab ?>&page=<?= $currentPage + 1 ?><?= !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" class="page-btn">&raquo;</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function doSearch() {
    const query = document.getElementById('admin-search').value;
    const url = new URL(window.location.href);
    if (query) {
        url.searchParams.set('search', query);
    } else {
        url.searchParams.delete('search');
    }
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
}

document.getElementById('admin-search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        doSearch();
    }
});
</script>

<style>
#admin {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
    padding-bottom: 40px;
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
    margin-bottom: 24px;
}

.stat-card {
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    padding: 20px;
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: bold;
    color: var(--text-primary);
    margin-bottom: 6px;
}

.stat-label {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.admin-tabs {
    display: flex;
    gap: 4px;
    margin-bottom: 16px;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 0;
}

.tab-btn {
    padding: 12px 20px;
    font-size: 13px;
    color: var(--text-muted);
    text-decoration: none;
    border: 1px solid transparent;
    border-bottom: none;
    margin-bottom: -1px;
    background: var(--bg-secondary);
    border-radius: 4px 4px 0 0;
}

.tab-btn:hover {
    color: var(--text-secondary);
    background: var(--bg-secondary);
}

.tab-btn.active {
    color: var(--text-primary);
    background: var(--bg-secondary);
    border-color: var(--border-color);
    border-bottom-color: var(--bg-secondary);
}

.admin-section {
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    padding: 20px;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.search-box input {
    flex: 1;
    min-width: 200px;
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

.search-btn {
    padding: 10px 16px;
    font-size: 12px;
    font-family: inherit;
    color: var(--bg-primary);
    background-color: var(--success);
    border: none;
    cursor: pointer;
}

.search-btn:hover {
    background-color: var(--accent);
}

.clear-search {
    padding: 4px 8px;
    color: var(--text-muted);
    text-decoration: none;
}

.clear-search:hover {
    color: var(--error);
}

.results-count {
    font-size: 12px;
    color: var(--text-muted);
    margin-left: auto;
}

.create-form {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.form-row {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
}

.create-form input[type="text"] {
    flex: 1;
    padding: 10px 14px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-primary);
    background-color: var(--bg-input);
    border: 1px solid var(--border-input);
    outline: none;
}

.create-form input[type="text"]:focus {
    border-color: var(--text-primary);
}

.create-form textarea {
    width: 100%;
    padding: 10px 14px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-primary);
    background-color: var(--bg-input);
    border: 1px solid var(--border-input);
    outline: none;
    resize: vertical;
    box-sizing: border-box;
}

.create-form textarea:focus {
    border-color: var(--text-primary);
}

.create-form button {
    padding: 10px 20px;
    font-size: 12px;
    font-family: inherit;
    color: var(--bg-primary);
    background-color: var(--success);
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    white-space: nowrap;
}

.create-form button:hover {
    background-color: var(--accent);
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
    font-size: 10px;
    letter-spacing: 1px;
}

.admin-table td {
    color: var(--text-secondary);
}

.admin-table .comment-content {
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn-delete {
    color: var(--error);
    font-size: 12px;
}

.btn-delete:hover {
    text-decoration: underline;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.page-btn, .page-current, .page-ellipsis {
    padding: 6px 10px;
    font-size: 12px;
    color: var(--text-secondary);
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    text-decoration: none;
}

.page-btn:hover {
    border-color: var(--text-primary);
    color: var(--text-primary);
}

.page-current {
    background-color: var(--text-primary);
    color: var(--bg-primary);
    border-color: var(--text-primary);
}

.page-ellipsis {
    border: none;
    background: transparent;
}
</style>
