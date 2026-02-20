<?php if (isset($searchQuery) && $searchQuery !== ""): ?>
    <div id="search-results">
        <p>Results for: "<?= htmlspecialchars($searchQuery) ?>"</p>
    </div>
<?php endif; ?>

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <a href="./?action=post&id=<?= $post["POST_ID"] ?>" ><?= htmlspecialchars($post["TITLE"]) ?></a>
            <p><?= htmlspecialchars($post["CONTENT"]) ?></p>
            <i><?= htmlspecialchars($post["PUBLISH_DATE"]) ?></i>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-results">
        <p>No posts found.</p>
    </div>
<?php endif; ?>

<?php if (!isset($searchQuery) || $searchQuery === ""): ?>
<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="./?action=default&page=<?= $page - 1 ?>" class="page-btn">&laquo; Prev</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
            <span class="page-current"><?= $i ?></span>
        <?php elseif ($i <= 3 || $i > $totalPages - 3 || abs($i - $page) <= 1): ?>
            <a href="./?action=default&page=<?= $i ?>" class="page-btn"><?= $i ?></a>
        <?php elseif ($i == 4 && $page > 4): ?>
            <span class="page-ellipsis">...</span>
        <?php elseif ($i == $totalPages - 3 && $page < $totalPages - 3): ?>
            <span class="page-ellipsis">...</span>
        <?php endif; ?>
    <?php endfor; ?>
    
    <?php if ($page < $totalPages): ?>
        <a href="./?action=default&page=<?= $page + 1 ?>" class="page-btn">Next &raquo;</a>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<style>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 20px;
    flex-wrap: wrap;
}

.page-btn, .page-current, .page-ellipsis {
    padding: 6px 12px;
    font-size: 13px;
    color: var(--text-secondary);
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
}

.page-btn {
    color: var(--accent);
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
