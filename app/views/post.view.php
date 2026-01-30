<div id="">
    <div id="post">
        <h2> <?= $post["TITLE"] ?> </h2>
        <i> <?= $post["PUBLISH_DATE"] ?> </i>
        <p> <?= $post["CONTENT"] ?> </p>
    </div>
    
    <div id="comments">
        <?php foreach ($comments as $comment):
            $currentUser = $userModel->getUser($comment["USER_ID"]);
        ?>

        <div id="comment">
        
        <h3> <?= $currentUser["USERNAME"] ?> </h3>
        <p> <?= $comment["CONTENT"] ?> </p>
        </div>

        <?php endforeach; ?>
    </div>

    <a id="back" href="./?action=default"> <- Accueil </a>
</div>