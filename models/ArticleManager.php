<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager 
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles() : array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }
    
    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id) : ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article) : void 
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article) : void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article) : void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id) : void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Ajoute une vue à un article donné.
     *
     * @param int $id L'identifiant de l'article.
     * @return void
     */
    public function addView($id) : void
    {
        $sql = "INSERT INTO article (id, nb_views) VALUES (:id, :nb_views) ON DUPLICATE KEY UPDATE nb_views = nb_views + 1;";
        $this->db->query($sql, [
            'id' => $id,
            'nb_views' => 1
        ]);
    }

    /**
     * Récupère le nombre de commentaires pour un ID d'article donné.
     *
     * @param int $id L'identifiant de l'article.
     * @return int|null Le nombre de commentaires pour l’ID d’article donné. Renvoie null si aucun commentaire n'est trouvé.
     */
    public function getNbCommentByArticleId($id)  : int|null
    {
        $sql = "SELECT COUNT(*) AS nb_comment FROM comment WHERE id_article = :id";
        $result = $this->db->query($sql, ['id' => $id]);

        $nbComment = $result->fetch()['nb_comment'];

        if ($nbComment == null){
            return $nbComment = 0;
        }

        return $nbComment;
    }

    /**
     * Trie le tableau d'articles en fonction de la cible et de l'ordre spécifiés.
     *
     * @param array $articles Le tableau des articles à trier.
     * @param string $target La propriété cible pour trier les articles par ('title', 'date', 'view', 'comment').
     * @param string $order L'ordre dans lequel les articles doivent être triés('ASC', 'DESC').
     * @return array|null
     */
    public function sortArticles(array $articles, string $target, string $order): ?array
    {
        if ($target === 'title') {

            if ($order === 'ASC') {
                function sortTitleAsc($a, $b): int
                {
                    return strcmp($a->getTitle(), $b->getTitle()) ;
                };
                usort($articles, "sortTitleAsc");

            } else {
                function sortTitleDesc($a, $b): int
                {
                    return strcmp($b->getTitle(), $a->getTitle()) ;
                };
                usort($articles, "sortTitleDesc");

            }

        } elseif ($target === 'date') {

            if ($order === 'ASC') {
                function sortDateAsc($a, $b): int
                {
                    return strcmp($a->getDateCreationFrenchFormat(), $b->getDateCreationFrenchFormat()) ;
                };
                usort($articles, "sortDateAsc");

            } else {
                function sortDateDesc($a, $b): int
                {
                    return strcmp($b->getDateCreationFrenchFormat(), $a->getDateCreationFrenchFormat()) ;
                };

                usort($articles, "sortDateDesc");
            }

        } elseif ($target === 'view') {

            if ($order === 'ASC') {
                function sortViewAsc($a, $b): int
                {
                    return strcmp($a->getNbViews(), $b->getNbViews()) ;
                };

                usort($articles, "sortViewAsc");

            } else {
                function sortViewDesc($a, $b): int
                {
                    return strcmp($b->getNbViews(), $a->getNbViews()) ;
                };

                usort($articles, "sortViewDesc");
            }

        } elseif ($target === 'comment') {

            if ($order === 'ASC') {
                function sortCommentAsc($a, $b): int
                {
                    return strcmp($a->getNbComment(), $b->getNbComment()) ;
                };

                usort($articles, "sortCommentAsc");

            } else {
                function sortCommentDesc($a, $b): int
                {
                    return strcmp($b->getNbComment(), $a->getNbComment()) ;
                };

                usort($articles, "sortCommentDesc");
            }

        } else {
            return $articles;
        }

        return $articles;
    }
}