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
        $comments_current_page = $this->comment->getCommentsCurrentPageFromItem();
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
      $comments_current_page = $this->comment->getCommentsCurrentPageFromItemUser();
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
        // Exécution de l'action par défaut pour réafficher la liste des billets
        $this->executeAction("index");
    }


    public function createcommentloggedin()
    {
        $user_id = $_SESSION['id_user'];
        $item_id = $this->request->getParameter("id");
        $author= $this->request->getParameter("author");
        $content = $this->request->getParameter("content");
        $this->comment->insertCommentLoggedIn($item_id, $user_id, $author, $content);
        // Exécution de l'action par défaut pour réafficher la liste des billets
        $this->executeAction("indexuser");
    }

    // Read :
    // Affichage d'un commentaire
    public function readcomment()
    {
      $item_id = $this->request->getParameter("id");
      $id_comment = $this->request->getParameter("id_comment");
      $comments = $this->comment->getComments($item_id);
      $comment = $this->comment->getComment($id_comment);
      $default = "default.png";
      $this->generateView(array(
      'item' => $item,
      'comments' => $comments,
      'comment' => $comment,
      'default'=> $default
    ));
    }

    // Update :
    // Modification d'un commentaire
    public function updatecomment()
    {
      $comment = $this->request->getParameter("id");
      $this->comment->changeComment($content);
      $comment = $this->comment->getItem($id_comment);
      if ($comment  === false) {
          throw new Exception('Impossible de modifier le commentaire !');
      }
      else {
        $messages['confirmation'] = 'Le commentaire a bien été modifié !';
        $this->generateadminView();
      }
    }




}
