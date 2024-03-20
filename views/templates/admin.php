<?php 
    /** 
     * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
     * Et un formulaire pour ajouter un article. 
     */
?>

<div class="nav-container">
    <a class="<?= $section !== 'monitoring' ? 'active' : '' ?>" href="index.php?action=admin&section=edition"><h2>Edition des articles</h2></a>
    <a class="<?= $section === 'monitoring' ? 'active' : '' ?>" href="index.php?action=admin&section=monitoring"><h2>Statistiques des articles</h2></a>
</div>


<?php
    if ($section === 'monitoring') { ?>
        <div class="admin-monitoring">
            <table class="table-Monitoring">
                <!-- En fonction de la cible du tri et de l'ordre du tri (ASC ou DESC) les icons sont masqués -->
                <thead>
                    <tr>
                        <th class="<?= $target !== 'title' ? 'hidden' : ''?>"><a href="index.php?action=admin&section=monitoring&target=title&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Titre de l'article  <?= $order === 'ASC' ? '<i class="fa-solid fa-sort-down"></i>' : '<i class="fa-solid fa-sort-up"></i>'?></a></th>
                        <th class="<?= $target !== 'date' ? 'hidden' : ''?>"><a href="index.php?action=admin&section=monitoring&target=date&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Date de création<?= $order === 'ASC' ? '<i class="fa-solid fa-sort-down"></i>' : '<i class="fa-solid fa-sort-up"></i>'?></a></th>
                        <th class="<?= $target !== 'view' ? 'hidden' : ''?>"><a href="index.php?action=admin&section=monitoring&target=view&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Nombre de vue<?= $order === 'ASC' ? '<i class="fa-solid fa-sort-down"></i>' : '<i class="fa-solid fa-sort-up"></i>'?></a></th>
                        <th class="<?= $target !== 'comment' ? 'hidden' : ''?>"><a href="index.php?action=admin&section=monitoring&target=comment&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Commentaires<?= $order === 'ASC' ? '<i class="fa-solid fa-sort-down"></i>' : '<i class="fa-solid fa-sort-up"></i>'?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sortedArticles as $key => $article) { ?>
                        <tr class="monitoring-line <?= $key%2 ? 'light' : '' ?>">
                            <td><?= $article->getTitle() ?></td>
                            <td><?= $article->getDateCreationFrenchFormat() ?></td>
                            <td><?= $article->getNbViews() ?></td>
                            <td><?= $article->getNbComments() ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="admin-article">
            <?php foreach ($articles as $key => $article) { ?>
                <div class="articleLine <?= $key%2 ? 'light' : '' ?>">
                    <div class="title"><?= $article->getTitle() ?></div>
                    <div class="content"><?= $article->getContent(200) ?></div>
                    <div><a class="submit" href="index.php?action=showUpdateArticleForm&id=<?= $article->getId() ?>">Modifier</a></div>
                    <div><a class="submit" href="index.php?action=deleteArticle&id=<?= $article->getId() ?>" <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer cet article ?") ?> >Supprimer</a></div>
                </div>
            <?php } ?>
        </div>

        <a class="submit" href="index.php?action=showUpdateArticleForm">Ajouter un article</a>
    <?php } ?>

