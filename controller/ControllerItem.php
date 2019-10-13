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
        $number_of_items  = $this->item->getNumberOfItems();
        $items_current_page = $this->item->getCurrentPage();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $comments = $this->comment->countComments($item_id);
        $comments = $this->comment->getComments($item_id);
        $default = "default.png";
        $comments_current_page = $this->comment->getNumberOfComments();
        $number_of_comments =  $this->comment->getNumberOfCommentsFromItem();
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem();
        $this->generateView(array(
          'item' => $item,
          'number_of_items' => $number_of_items,
          'items_current_page' => $items_current_page,
          'number_of_items_pages' => $number_of_items_pages,
          'comments' => $comments,
          'default'=> $default,
          'comments_current_page' => $comments_current_page,
          'number_of_comments' => $number_of_comments,
          'number_of_comments_pages' => $number_of_comments_pages
        ));
    }
    // Affichage d'un seul item avec ses commentaires - pour user connecté
    public function indexuser()
    {
      $item_id = $this->request->getParameter("id");
      $item = $this->item->getItem($item_id);
      $number_of_items  = $this->item->getNumberOfItems();
      $items_current_page = $this->item->getCurrentPage();
      $number_of_items_pages = $this->item->getNumberOfPages();
      $user = $this->user->getUser($_SESSION['id_user']);
      $comments = $this->comment->countComments($item_id);
      $comments = $this->comment->getComments($item_id);
      $default = "default.png";
      $comments_current_page = $this->comment->getNumberOfComments();
      $number_of_comments =  $this->comment->getNumberOfCommentsFromItem();
      $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem();
      $this->generateView(array(
        'item' => $item,
        'number_of_items' => $number_of_items,
        'items_current_page' => $items_current_page,
        'number_of_items_pages' => $number_of_items_pages,
        'user' => $user,
        'comments' => $comments,
        'default'=> $default,
        'comments_current_page' => $comments_current_page,
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

}
