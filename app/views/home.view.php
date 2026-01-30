<?php foreach ($posts as $post): ?>
    <div class="post">
        <a href="./?action=post&id=<?= $post["POST_ID"] ?>" ><?= $post["TITLE"] ?></a>
        <p><?= $post["CONTENT"] ?></p>
        <i><?= $post["PUBLISH_DATE"] ?></i>
    </div>
<?php endforeach; ?>