<?php
require_once 'Framework/Model.php';
/**
 * Fournit les services d'accès aux genres musicaux
 *
 * @author Sébastien Merour
 */
class Comment extends Model {

  public $comments_count, $comments_start;

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
      $sql                        = 'SELECT comments.id, comments.id_user AS user_com, comments.author, comments.content,
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
      
}
