<?php
require_once 'Framework/Model.php';
/**
 * Fournit les fonctions liées aux commentaires
 *
 * @author Sébastien Merour
 */
class Comment extends Model {

  public $comments_count, $comments_start;


  public function countComments($item_id)
  {
      $sql                        = 'SELECT COUNT(id) as counter FROM comments WHERE id_item = ?';
      $this->comments_count       = $this->dbConnect($sql, array(
          $item_id
      ));
      $number_of_comments_by_page = 5;
      $comments                   = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments         = $comments['counter'];
      // Calculer le nombre de pages nécessaires :
      $number_of_comments_pages   = ceil($number_of_comments / $number_of_comments_by_page);

      // Vérifier quelle est la page active :
      if (isset($_GET['commentspage'])) {
          $comments_current_page = (int) $_GET['commentspage'];
      } else {
          $comments_current_page = 1;
      }

      // Définir à partir de quel N° d'item chaque page doit commencer :
      $this->comments_start = (int) (($comments_current_page - 1) * $number_of_comments_by_page);

  }


  // Create
  // Création d'un commentaire :
  public function insertComment($item_id, $author, $content)
  {
      $sql           = 'INSERT INTO comments(id_item, author, content, date_creation) VALUES(?, ?, ?, NOW())';
      $affectedLines = $this->dbConnect($sql, array(
          $item_id,
          $author,
          $content
      ));

      if ($affectedLines === false) {
          // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
          throw new Exception('Impossible d\'ajouter le commentaire !');
      }
      return $affectedLines;
  }
  // Création d'un commentaire d'un utilisateur connecté :
  public function insertCommentLoggedIn($item_id, $user_id, $author, $content)
  {
      $user_id       = $_SESSION['id_user'];
      $sql           = 'INSERT INTO comments(id_item, id_user, author, content, date_creation) VALUES(?, ?, ?, ?, NOW())';
      $affectedLines = $this->dbConnect($sql, array(
          $item_id,
          $user_id,
          $author,
          $content
      ));
      if ($affectedLines === false) {
          // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
          throw new Exception('Impossible d\'ajouter le commentaire !');
      }
      return $affectedLines;
  }


  // Afficher la liste des commentaires d'un Article :
  public function getComments($item_id)
  {
      $number_of_comments_by_page = 5;
      $sql                        = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ?
      ORDER BY date_creation
      DESC LIMIT ' . $this->comments_start . ', ' . $number_of_comments_by_page . '';
      $comments                   = $this->dbConnect($sql, array(
          $item_id
      ));
      return $comments;
  }
  // Affichage d'un commentaire pour le modifier ensuite :
  public function getComment($id_comment)
  {

      $sql     = 'SELECT comments.id, comments.id_user AS user_com, comments.author, comments.content,
        DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr,
        DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
        users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
        FROM comments
        LEFT JOIN users
        ON comments.id_user = users.id_user
        WHERE comments.id = ?
        ';
      $req     = $this->dbConnect($sql, array(
          $id_comment
      ));
      $comment = $req->fetch();
      return $comment;
  }




  // Update
  // Modification d'un commentaire :
  public function changeComment($content)
  {
      $comment = $_GET['id'];
      $content           = !empty($_POST['content']) ? trim($_POST['content']) : null;

      $sql        = 'UPDATE comments SET content = :content, date_creation = NOW() WHERE id = :id';
      $newComment = $this->dbConnect($sql, array(
        ':id' => $comment,
        ':content' => $content
      ));
    // Ici on affiche le message de confirmation :
    $commentmessages['confirmation'] = 'Merci ! Votre commentaire a bien été modifié !';
    if (!empty($commentmessages)) {
        $_SESSION['messages'] = $commentmessages;
        header('Location: ../readcomment/' . $comment);
        exit;
    }
}

// Delete
// Suppression d'un commentaire :
public function eraseComment($id_comment)
{
    $sql = 'DELETE FROM comments WHERE id = ' . (int) $id_comment;
    $req = $this->dbConnect($sql);
    $req->execute();

    // Ici on affiche le message de confirmation :
    $itemmessages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
    if (!empty($itemmessages)) {
        $_SESSION['messages'] = $itemmessages;
        header('Location: ../');
        exit;
    }
}




  // Calculs

  // Obtenir la page courante des commentaires sur un article en particulier :
  public function getCommentsCurrentPageFromItem()
  {
      $sql = 'SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ';
      $this->comments_count = $this->dbConnect($sql, array(
          $_GET[int]
      )) or die(print_r($db->errorInfo()));
      $number_of_comments_by_page = 5;

      $comments        = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $counter         = $comments['counter'];
      // Calculer le nombre de pages nécessaires :
      $number_of_pages = ceil($counter / $number_of_comments_by_page);

      // Vérifier quelle est la page active :
      if (isset($_GET[int])) {
          $comments_current_page = (int) $_GET['page'];
      } else {
          $comments_current_page = 1;
      }
      return $comments_current_page;
  }

  // Obtenir le nombre de pages des commentaires sur un article en particulier :
  public function getNumberOfCommentsPagesFromItem()
  {
      $number_of_comments_by_page = 5;
      $sql                        = 'SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ';
      $this->comments_count = $this->dbConnect($sql, array(
          $_GET['id']
      )) or die(print_r($db->errorInfo()));
      $comments                 = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments       = $comments['counter'];
      // Calculer le nombre de pages nécessaires :
      $number_of_comments_pages = ceil($number_of_comments / $number_of_comments_by_page);
      return $number_of_comments_pages;
  }

  // Calculer le nombre de Commentaires d'un article en particulier :
  public function getNumberOfCommentsFromItem()
  {
      $sql = 'SELECT COUNT(id) as counter FROM comments WHERE id_item = ? ';
      $this->comments_count = $this->dbConnect($sql, array(
          $_GET['id']
      )) or die(print_r($db->errorInfo()));
      $comments           = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments = $comments['counter'];
      return $number_of_comments;
  }

  // Calculer le nombre total de Pages de Commentaires pur l'admin :
  public function getNumberOfCommentsPages()
  {
      $number_of_comments_by_page = 10;
      $sql                        = 'SELECT COUNT(id) as counter FROM comments';
      $this->comments_count       = $this->dbConnect($sql);
      $comments                   = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments         = $comments['counter'];

      // Calculer le nombre de pages nécessaires :
      $number_of_comments_pages = ceil($number_of_comments / $number_of_comments_by_page);
      return $number_of_comments_pages;
  }

  // Calculer le nombre total de commentaires :
  public function getNumberOfComments()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments';
      $comments             = $this->dbConnect($sql);
      $this->comments_count = $comments->fetch(\PDO::FETCH_ASSOC);
      $total_comments_count = $this->comments_count['counter'];
      return $total_comments_count;

  }

  public function selectComments()
  {
      $number_of_comments_by_page = 5;
      $sql                        = 'SELECT COUNT(id) AS countercom FROM comments';
      $comments_count             = $this->dbConnect($sql);
      $comments                   = $comments_count->fetch(\PDO::FETCH_ASSOC);

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
      $this->comments_start = (int) (($current_comments_page - 1) * $number_of_comments_by_page);

      $sql2             = 'SELECT comments.id, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
     users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $this->comments_start . ', ' . $number_of_comments_by_page . '';
      $request_comments = $this->dbConnect($sql2);
      return $request_comments;
  }



}
