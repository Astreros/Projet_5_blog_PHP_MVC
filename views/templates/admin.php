<?php 
    /** 
     * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
     * Et un formulaire pour ajouter un article. 
     */
?>

<a href="index.php?action=admin&section=edition"><h2>Edition des articles</h2></a>

<a href="index.php?action=admin&section=monitoring"><h2>Monitoring du site</h2></a>

<?php
    if ($section === 'monitoring') { ?>
        <div class="adminArticle">
            <?php foreach ($articles as $article) { ?>
                <div class="articleLine">
                    <div class="title"><?= $article->getTitle() ?></div>
                    <div class="content"><?= $article->getDateCreationFrenchFormat() ?></div>
                    <div class="content"><?= $article->getNbViews() ?></div>
                    <div class="content"><?= $article->getNbComment() ?></div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="adminArticle">
            <?php foreach ($articles as $article) { ?>
                <div class="articleLine">
                    <div class="title"><?= $article->getTitle() ?></div>
                    <div class="content"><?= $article->getContent(200) ?></div>
                    <div><a class="submit" href="index.php?action=showUpdateArticleForm&id=<?= $article->getId() ?>">Modifier</a></div>
                    <div><a class="submit" href="index.php?action=deleteArticle&id=<?= $article->getId() ?>" <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer cet article ?") ?> >Supprimer</a></div>
                </div>
            <?php } ?>
        </div>

        <a class="submit" href="index.php?action=showUpdateArticleForm">Ajouter un article</a>
    <?php } ?>

