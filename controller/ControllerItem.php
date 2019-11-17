<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';


/**
 * Contrôleur des actions liées aux articles
 *
 * @author Sébastien Merour
 */

class ControllerItem extends Controller {
    private $item;
    private $comment;
    private $user;
    /**
     * Constructeur
     */
    public function __construct() {
        $this->item = new Item();
        $this->comment = new Comment();
        $this->user = new User();
    }


    // Affichage d'un seul item avec ses commentaires - pour user inconnu
    public function index() {
        $item_id = $this->request->getParameter("id");
        $item = $this->item->getItem($item_id);
        $number_of_items  = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $number_of_comments =  $this->comment->countComments($item_id);
        $comments_current_page = 1;
        $page_previous_comments = $comments_current_page - 1;
        $page_next_comments = $comments_current_page + 1;
        $comments = $this->comment->getPaginationComments($item_id, $comments_current_page);
        $default = "default.png";
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
        $this->generateView(array(
          'item' => $item,
          'number_of_items' => $number_of_items,
          'number_of_items_pages' => $number_of_items_pages,
          'comments' => $comments,
          'default'=> $default,
          'comments_current_page' => $comments_current_page,
          'page_previous_comments' => $page_previous_comments,
          'page_next_comments' => $page_next_comments,
          'number_of_comments' => $number_of_comments,
          'number_of_comments_pages' => $number_of_comments_pages
        ));
    }

    // Affichage d'un seul item avec ses commentaires - pour user inconnu
    public function indexlist() {
        $item_id = $this->request->getParameter("id");
        $item = $this->item->getItem($item_id);
        $number_of_items  = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $number_of_comments =  $this->comment->countComments($item_id);
        $comments_current_page = $this->comment->getCommentsCurrentPage();
        $page_previous_comments = $comments_current_page - 1;
        $page_next_comments = $comments_current_page + 1;
        $comments = $this->comment->getPaginationComments($item_id, $comments_current_page);
        $default = "default.png";
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
        $this->generateView(array(
          'item' => $item,
          'number_of_items' => $number_of_items,
          'number_of_items_pages' => $number_of_items_pages,
          'comments' => $comments,
          'default'=> $default,
          'comments_current_page' => $comments_current_page,
          'page_previous_comments' => $page_previous_comments,
          'page_next_comments' => $page_next_comments,
          'number_of_comments' => $number_of_comments,
          'number_of_comments_pages' => $number_of_comments_pages
        ));
    }




    // Affichage d'un seul item avec ses commentaires - pour user connecté
    public function indexuser()
    {
      $item_id = $this->request->getParameter("id");
      $item = $this->item->getItem($item_id);
      $user = $this->user->getUser($_SESSION['id_user']);
      $number_of_items  = $this->item->count();
      $number_of_items_pages = $this->item->getNumberOfPages();
      $number_of_comments =  $this->comment->countComments($item_id);
      $comments_current_page = $this->comment->getCommentsCurrentPage();
      $page_previous_comments = $comments_current_page - 1;
      $page_next_comments = $comments_current_page + 1;
      $comments = $this->comment->getPaginationComments($item_id, $comments_current_page);
      $default = "default.png";
      $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
      $this->generateView(array(
        'item' => $item,
        'number_of_items' => $number_of_items,
        'number_of_items_pages' => $number_of_items_pages,
        'user' => $user,
        'comments' => $comments,
        'default'=> $default,
        'comments_current_page' => $comments_current_page,
        'page_previous_comments' => $page_previous_comments,
        'page_next_comments' => $page_next_comments,
        'number_of_comments' => $number_of_comments,
        'number_of_comments_pages' => $number_of_comments_pages
      ));
    }

    // COMMENTS //
    // Create
    // Ajout d'un nouveau commentaire :
    public function createcomment()
    {
        $item_id = $this->request->getParameter("id");
        $author= $this->request->getParameter("author");
        $content = $this->request->getParameter("content");
        $this->comment->insertComment($item_id, $author, $content);
    }


    public function createcommentloggedin()
    {
        $user_id = $_SESSION['id_user'];
        $item_id = $this->request->getParameter("id");
        $author= $this->request->getParameter("author");
        $content = $this->request->getParameter("content");
        $this->comment->insertCommentLoggedIn($item_id, $user_id, $author, $content);
    }

    // Read :
    // Affichage d'un commentaire
    public function readcomment()
    {
      $item_id = $this->item->getItemId();
      $item = $this->item->getItem($item_id);
      $number_of_items  = $this->item->count();
      $number_of_items_pages = $this->item->getNumberOfPages();
      $number_of_comments =  $this->comment->countComments($item_id);
      $comments_current_page = 1;
      $page_previous_comments = $comments_current_page - 1;
      $page_next_comments = $comments_current_page + 1;
      $comments = $this->comment->getPaginationComments($item_id, $comments_current_page);
      $id_comment = $this->comment->getCommentId();
      $comment = $this->comment->getComment($id_comment);
      $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
      $default = "default.png";
      $this->generateView(array(
      'comment' => $comment,
      'item' => $item,
      'number_of_items' => $number_of_items,
      'number_of_items_pages' => $number_of_items_pages,
      'comments_current_page' => $comments_current_page,
      'comments' => $comments,
      'default'=> $default,
      'page_previous_comments' => $page_previous_comments,
      'page_next_comments' => $page_next_comments,
      'number_of_comments' => $number_of_comments,
      'number_of_comments_pages' => $number_of_comments_pages
    ));
    }


    // Update :
    // Modification d'un commentaire
    public function updatecomment()
    {
      $id_comment = $this->comment->getCommentId();
      $comment = $this->comment->getComment($id_comment);
      $content = $comment['content'];
      $this->comment->changeComment($content);
      $comment = $this->comment->getItem($id_comment);
      if ($comment  === false) {
          throw new Exception('Impossible de modifier le commentaire !');
      }
      else {
        $messages['confirmation'] = 'Le commentaire a bien été modifié !';
        $this->generateView();
      }
    }


    // Signaler un commentaire
    public function reportcomment()
    {
      $item_id = $this->item->getItemId();
      $item = $this->item->getItem($item_id);
      $number_of_items  = $this->item->count();
      $number_of_items_pages = $this->item->getNumberOfPages();
      $number_of_comments =  $this->comment->countComments($item_id);
      $comments_current_page = 1;
      $page_previous_comments = $comments_current_page - 1;
      $page_next_comments = $comments_current_page + 1;
      $comments = $this->comment->getPaginationComments($item_id, $comments_current_page);
      $id_comment = $this->comment->getCommentId();
      $comment = $this->comment->getComment($id_comment);
      $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
      $this->comment->reportBadComment($id_comment);
      $default = "default.png";
      $this->generateView(array(
      'comment' => $comment,
      'item' => $item,
      'number_of_items' => $number_of_items,
      'number_of_items_pages' => $number_of_items_pages,
      'comments_current_page' => $comments_current_page,
      'comments' => $comments,
      'default'=> $default,
      'page_previous_comments' => $page_previous_comments,
      'page_next_comments' => $page_next_comments,
      'number_of_comments' => $number_of_comments,
      'number_of_comments_pages' => $number_of_comments_pages
    ));
    }






}
