<?php 
    /** 
     * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
     * Et un formulaire pour ajouter un article. 
     */
?>

<div class="nav-container">
    <a class="<?= $section === 'edition' ? 'active' : '' ?>" href="index.php?action=admin&section=edition"><h2>Edition des articles</h2></a>
    <a class="<?= $section === 'monitoring' ? 'active' : '' ?>" href="index.php?action=admin&section=monitoring"><h2>Statistiques des articles</h2></a>
</div>


<?php
    if ($section === 'monitoring') { ?>
        <div class="admin-monitoring">
            <table class="table-Monitoring">
                <thead>
                    <tr>
                        <th>Titre de l'article</th>
                        <th>Date de création</th>
                        <th>Nombre de vue</th>
                        <th>Commentaire(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $key => $article) { ?>
                        <tr class="monitoring-line <?= $key%2 ? 'light' : '' ?>">
                            <td><?= $article->getTitle() ?></td>
                            <td><?= $article->getDateCreationFrenchFormat() ?></td>
                            <td><?= $article->getNbViews() ?></td>
                            <td><?= $article->getNbComment() ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="admin-article">
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

