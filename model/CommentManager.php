<?php
namespace SM\Blog\Model;
require_once __DIR__ . '/../model/Manager.php';

class CommentManager extends Manager
{

    // Create
    // Création d'un commentaire :
    public function insertComment($item_id, $author, $content_comment)
    {
        $db            = $this->dbConnect();
        $comments      = $db->prepare('INSERT INTO comments(id_item, author, content_comment, date_comment) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array(
            $item_id,
            $author,
            $content_comment
        ));
        if ($affectedLines === false) {
            // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        return $affectedLines;
    }
    // Création d'un commentaire d'un utilisateur connecté :
    public function insertCommentLoggedIn($item_id, $user_id, $author, $content_comment)
    {
        $db            = $this->dbConnect();
        $user_id = $_SESSION['id_user'];
        $comments      = $db->prepare('INSERT INTO comments(id_item, id_user, author, content_comment, date_comment) VALUES(?, ?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array(
            $item_id,
            $user_id,
            $author,
            $content_comment
        ));
        if ($affectedLines === false) {
            // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        return $affectedLines;
    }
    // Read
    // Afficher la liste des Commentaires :
    public function selectComments()
    {
        $db                         = $this->dbConnect();
        $number_of_comments_by_page = 5;
        $comments_count             = $db->prepare('SELECT COUNT(id) AS countercom FROM comments');
        $comments_count->execute();
        $comments = $comments_count->fetch(\PDO::FETCH_ASSOC);

        $counter_comments = $comments['countercom'];

        // Calculer le nombre de pages nécessaires :
        $number_of_comments_pages = ceil($counter_comments / $number_of_comments_by_page);

        // Vérifier quelle est la page active :
        if (isset($_GET['commentspage'])) {
            $current_comments_page = (int) $_GET['commentspage'];
        } else {
            $current_comments_page = 1;
        }

        // Définir à partir de quel N° de commmentaire chaque page doit commencer :
        $start = (int) (($current_comments_page - 1) * $number_of_comments_by_page);

        $request_comments = $db->query('SELECT comments.id, comments.id_user, comments.author, comments.content_comment,
      DATE_FORMAT(comments.date_comment, \'%d/%m/%Y à %Hh%imin\') AS date_comment_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
       users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      ORDER BY date_comment DESC LIMIT ' . $start . ', ' . $number_of_comments_by_page . '');
        return $request_comments;
    }

    // Affichage d'un commentaire pour le modifier ensuite :
    public function getComment($id_comment)
    {
        $db       = $this->dbConnect();
        $req      = $db->prepare('SELECT comments.id, comments.id_user AS user_com, comments.author, comments.content_comment,
          DATE_FORMAT(comments.date_comment, \'%d/%m/%Y à %Hh%imin\') AS date_comment_fr,
          DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
          users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
          FROM comments
          LEFT JOIN users
          ON comments.id_user = users.id_user
          WHERE comments.id = ?
          ');
        $req->execute(array(
            $id_comment
        ));
        $comment                  = $req->fetch();
        return $comment;
    }


    // Afficher la liste des commentaires d'un Article :
    public function getComments($item_id)
    {
      $db                         = $this->dbConnect();
      $number_of_comments_by_page = 5;
      $comments_count             = $db->prepare('SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ');
      $comments_count->execute(array(
          $_GET['id']
      )) or die(print_r($db->errorInfo()));
      $number_of_comments = $comments_count->fetch(\PDO::FETCH_ASSOC);
      $counter            = $number_of_comments['counter'];

      // Calculer le nombre de pages nécessaires :
      $number_of_comments_pages = ceil($counter / $number_of_comments_by_page);

        // Vérifier quelle est la page active :
        if (isset($_GET['page'])) {
            $comments_current_page = (int) $_GET['page'];
        } else {
            $comments_current_page = 1;
        }

        // Définir à partir de quel N° d'item chaque page doit commencer :
        $start = (int) (($comments_current_page - 1) * $number_of_comments_by_page);
        $comments = $db->prepare('SELECT comments.id, comments.id_user AS user_com, comments.author, comments.content_comment,
          DATE_FORMAT(comments.date_comment, \'%d/%m/%Y à %Hh%imin\') AS date_comment_fr,
          DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
          users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
          FROM comments
          LEFT JOIN users
          ON comments.id_user = users.id_user
          WHERE id_item = ?
          ORDER BY date_comment
          DESC LIMIT ' . $start . ', ' . $number_of_comments_by_page . '');
        $comments->execute(array(
            $item_id
        ));
        return $comments;
    }

    // Update
    // Modification d'un commentaire :
    public function changeComment($id_comment, $comment)
    {
        $db         = $this->dbConnect();
        $req        = $db->prepare('UPDATE comments SET content_comment = ?, date_comment = NOW() WHERE id = ?');
        $newComment = $req->execute(array(
            $comment,
            $id_comment
        ));
        if ($newComment === false) {
            // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        // Ici on affiche le message de confirmation :
        return $newComment;
    }

    // Delete
    // Suppression d'un commentaire :
    public function eraseComment($id_comment)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ' . (int) $id_comment);
        $req->execute();
    }

    // Calculs
    // Obtenir la page courante des commentaires sur un article en particulier :
    public function getCommentsCurrentPageFromItem()
    {
        $db                         = $this->dbConnect();
        $number_of_comments_by_page = 5;
        $comments_count             = $db->prepare('SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ');
        $comments_count->execute(array(
            $_GET['id']
        )) or die(print_r($db->errorInfo()));
        $comments = $comments_count->fetch(\PDO::FETCH_ASSOC);
        $counter  = $comments['counter'];

        // Calculer le nombre de pages nécessaires :
        $number_of_pages = ceil($counter / $number_of_comments_by_page);

        // Vérifier quelle est la page active :
        if (isset($_GET['page'])) {
            $comments_current_page = (int) $_GET['page'];
        } else {
            $comments_current_page = 1;
        }
        return $comments_current_page;
    }

    // Obtenir le nombre de pages des commentaires sur un article en particulier :
    public function getNumberOfCommentsPagesFromItem()
    {
        $db                         = $this->dbConnect();
        $number_of_comments_by_page = 5;
        $comments_count             = $db->prepare('SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ');
        $comments_count->execute(array(
            $_GET['id']
        )) or die(print_r($db->errorInfo()));
        $comments = $comments_count->fetch(\PDO::FETCH_ASSOC);
        $counter  = $comments['counter'];

        // Calculer le nombre de pages nécessaires :
        $number_of_comments_pages = ceil($counter / $number_of_comments_by_page);
        return $number_of_comments_pages;
    }

    // Calculer le nombre de Commentaires d'un article en particulier :
    public function getNumberOfCommentsFromItem()
    {
        $db             = $this->dbConnect();
        $comments_count = $db->prepare('SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ');
        $comments_count->execute(array(
            $_GET['id']
        )) or die(print_r($db->errorInfo()));
        $comments           = $comments_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_comments = $comments['counter'];
        return $number_of_comments;
    }

    // Calculer le nombre total de Pages de Commentaires :
    public function getNumberOfCommentsPages()
    {
        $db                         = $this->dbConnect();
        $number_of_comments_by_page = 5;
        $comments_count             = $db->prepare('SELECT COUNT(id) AS counter FROM comments');
        $comments_count->execute();
        $comments = $comments_count->fetch(\PDO::FETCH_ASSOC);
        $counter  = $comments['counter'];

        // Calculer le nombre de pages nécessaires :
        $number_of_comments_pages = ceil($counter / $number_of_comments_by_page);
        return $number_of_comments_pages;
    }

    // Calculer le nombre total de commentaires :
    public function getNumberOfComments()
    {
        $db             = $this->dbConnect();
        $comments_count = $db->prepare('SELECT COUNT(id) as counter FROM comments');
        $comments_count->execute();
        $comments           = $comments_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_comments = $comments['counter'];
        return $number_of_comments;
    }

}
