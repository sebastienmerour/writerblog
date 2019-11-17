<?php
require_once 'Framework/Model.php';
/**
 * Fournit les fonctions liées aux commentaires
 *
 * @author Sébastien Merour
 */
class Comment extends Model {
  public
  $number_of_comments,
  $comments_current_page,
  //$comments_count,
  $number_of_comments_by_page = 5;

    public function start()
    {
    $url =  $_SERVER['REQUEST_URI'];
    $urlcontent = parse_url($url, PHP_URL_QUERY);
    preg_match_all("/\d+/", $urlcontent, $number);
    $first_comment = (int) end($number[0]);
    if (!empty($comments_start)) {
        $comments_start = (int) $first_comment;
    } else {
        $comments_start = 0;
    }
    return $comments_start;
    }


  // Calculer le nombre de Commentaires d'un article en particulier :
  public function countComments($item_id)
  {
      $sql                        = 'SELECT COUNT(id) as counter FROM comments WHERE id_item = ?';
      $this->comments_count       = $this->dbConnect($sql, array(
          $item_id
      ));
      $comments                   = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments         = $comments['counter'];
      return $number_of_comments;
  }
  // Create
  // Création d'un commentaire :
  public function insertComment($item_id, $author, $content)
  {
      $sql           = 'INSERT INTO comments(id_item, author, content, date_creation) VALUES(?, ?, ?, NOW())';
      $comment = $this->dbConnect($sql, array(
          $item_id,
          $author,
          $content
      ));

      $messages['confirmation'] = 'Votre commentaire a bien été ajouté !';
      if (!empty($messages)) {
          $_SESSION['messages'] = $messages;
          header('Location: ../item/'.$item_id .'#comments');
          exit;
      }
  }
  // Création d'un commentaire d'un utilisateur connecté :
  public function insertCommentLoggedIn($item_id, $user_id, $author, $content)
  {
      $user_id       = $_SESSION['id_user'];
      $sql           = 'INSERT INTO comments(id_item, id_user, author, content, date_creation) VALUES(?, ?, ?, ?, NOW())';
      $comment = $this->dbConnect($sql, array(
          $item_id,
          $user_id,
          $author,
          $content
      ));
      $messages['confirmation'] = 'Votre commentaire a bien été ajouté !';
      if (!empty($messages)) {
          $_SESSION['messages'] = $messages;
          header('Location: ../item/indexuser/'.$item_id .'/1#comments');
          exit;
      }
  }
  // Afficher la liste des commentaires d'un Article :
  public function getComments($item_id)
  {
      $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
      $sql                        = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ?
      ORDER BY date_creation
      DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
      $comments                  = $this->dbConnect($sql, array(
          $item_id
      ));
      return $comments;
  }

// Pagination des commentaires sur un article :
  public function getPaginationComments($item_id, $comments_current_page)
  {
      $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
      $sql                        = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ?
      ORDER BY date_creation
      DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
      $comments                  = $this->dbConnect($sql, array(
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
  // Modification d'un commentaire depuis le Front
  public function changeComment($content)
  {
      $q = explode("/", $_SERVER['REQUEST_URI']);
      $valuei = $q[4];
      $valuec = $q[5];
      $item = (int)$valuei;
      $comment= (int)$valuec;
      $content           = !empty($_POST['content']) ? trim($_POST['content']) : null;
      $sql        = 'UPDATE comments SET content = :content, date_creation = NOW() WHERE id = :id';
      $newComment = $this->dbConnect($sql, array(
        ':id' => $comment,
        ':content' => $content
      ));
    // Ici on affiche le message de confirmation :
    $commentmessages['confirmation'] = 'Merci ! Le commentaire a bien été modifié !';
    if (!empty($commentmessages)) {
        $_SESSION['messages'] = $commentmessages;
        header('Location: /writerblog/item/readcomment/' . $item . '/'.  $comment);
        exit;
    }
}
  // Modification d'un commentaire depuis l'Admin
  public function changeCommentAdmin($content)
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
  // Obtenir l'ID du commentaire pour une modification du commentaire en Front :
  public function getCommentId()
  {
    $q = explode("/", $_SERVER['REQUEST_URI']);
    $value = $q[5];
    $id_comment = (int)$value;
    return $id_comment;
  }


  // Obtenir la page courante des commentaires sur un article en particulier :
  public function getCommentsCurrentPageFromItem()
  {
    $q = explode("/", $_SERVER['REQUEST_URI']);
    $value = $q[4];
    $comments_current_page = (int)$value;
    return $comments_current_page;
  }

  // Obtenir la page courante des commentaires :
  public function getCommentsCurrentPage()
  {
    $q = explode("/", $_SERVER['REQUEST_URI']);
    $value = $q[5];
    $comments_current_page = (int)$value;
    return $comments_current_page;
  }

  // Obtenir la page courante des commentaires sur un article en particulier avec user connecté :
  public function getCommentsCurrentPageFromItemUser()
  {
    $q = explode("/", $_SERVER['REQUEST_URI']);
    $value = $q[6];
    $comments_current_page = (int)$value;
    return $comments_current_page;
  }

  // Obtenir le nombre de pages des commentaires sur un article en particulier :
  public function getNumberOfCommentsPagesFromItem($item_id)
  {
      $number_of_comments       = $this->countComments($item_id);
      // Calculer le nombre de pages nécessaires :
      $number_of_comments_pages   = ceil($number_of_comments / $this->number_of_comments_by_page);
      return $number_of_comments_pages;

  }

  // Calculer le nombre total de Pages de Commentaires pour l'admin :
  public function getNumberOfCommentsPagesFromAdmin()
  {
      $total_comments_count   = $this->getTotalOfComments();
      // Calculer le nombre de pages nécessaires :
      $number_of_comments_pages = ceil($total_comments_count /  $this->number_of_comments_by_page);
      return $number_of_comments_pages;

  }

  // Calculer le nombre total de commentaires pour l'admin :
  public function getTotalOfComments()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments';
      $comments             = $this->dbConnect($sql);
      $this->comments_count = $comments->fetch(\PDO::FETCH_ASSOC);
      $total_comments_count = $this->comments_count['counter'];
      return $total_comments_count;
  }

  // Afficher la liste complète de tous les commentaires en Admin :
  public function selectComments($comments_current_page)
  {
      $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
      $sql            = 'SELECT comments.id, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%imin\') AS date_update,
     users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
      $comments = $this->dbConnect($sql);
      return $comments;
  }
}
