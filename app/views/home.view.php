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
