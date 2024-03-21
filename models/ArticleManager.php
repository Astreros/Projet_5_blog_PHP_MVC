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
     * On sait si l'article est un nouvel article, car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article) : void 
    {
        if ($article->getId() === -1) {
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
    public function addView(int $id) : void
    {
        $sql = "UPDATE article SET nb_views = nb_views + 1 WHERE id = :id;";
        $this->db->query($sql, [
            'id' => $id
        ]);
    }

    /**
     * Récupère le nombre de commentaires pour un ID d'article donné.
     *
     * @param int $id L'identifiant de l'article.
     * @return int|null Le nombre de commentaires pour l’ID d’article donné. Renvoie null si aucun commentaire n'est trouvé.
     */
    public function getNbCommentByArticleId(int $id)  : int|null
    {
        $sql = "SELECT COUNT(*) AS nb_comment FROM comment WHERE id_article = :id";
        $result = $this->db->query($sql, ['id' => $id]);

        $nbComment = $result->fetch()['nb_comment'];

        if ($nbComment === null){
            return 0;
        }

        return $nbComment;
    }


    /**
     * Récupère les articles de la base de données en fonction de la cible et de l'ordre sélectionné par l'utilisateur
     *
     * @param string $target La cible de tri. Valeurs possibles : 'view', 'title', 'date', 'comment'
     * @param string $order L'ordre de tri. Valeurs possibles : 'DESC' (décroissant), toute autre valeur sera par défaut croissant
     * @return array|null Un tableau d'objets Article triés selon la cible et l'ordre spécifiés, ou null si la cible n'est pas valide
     */
    public function getSortArticles(string $target, string $order): ?array
    {
        $sql = null;

        $targets['view'] = 'article.nb_views';
        $targets['title'] = 'article.title';
        $targets['date'] = 'article.date_creation';
        $targets['comment'] = 'nbComments';

        $sql = "SELECT article.title, article.date_creation, article.nb_views,
                        (SELECT COUNT(*) FROM comment WHERE comment.id_article = article.id) AS nbComments
                        FROM blog_forteroche.article 
                        ORDER BY $targets[$target]" ;

        if ($order === 'DESC') {
            $sql .= " DESC";
        }

        $result = $this->db->query($sql);
        $sortedArticles = [];

        while ($article = $result->fetch()) {
            $sortedArticles[] = new Article($article);
        }

        return $sortedArticles;
    }
}