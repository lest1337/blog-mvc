<div>
    <div id="post">
        <h2> <?= htmlspecialchars($post["TITLE"]) ?> </h2>
        <i> <?= htmlspecialchars($post["PUBLISH_DATE"]) ?> </i>
        <p> <?= htmlspecialchars($post["CONTENT"]) ?> </p>
    </div>
    
    <a id="back" href="./?action=default"> <- Accueil </a>
</div>
