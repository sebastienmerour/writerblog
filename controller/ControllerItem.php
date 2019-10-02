<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';

/**
 * Contrôleur des actions liées aux articles
 *
 * @author Sébastien Merour
 */

class ControllerItem extends Controller {
    private $item;
    private $comment;
    /**
     * Constructeur
     */
    public function __construct() {
        $this->item = new Item();
        $this->comment = new Comment();
    }
    // Affiche les détails sur un article
    public function index() {
        $item_id = $this->request->getParameter("id");

        $item = $this->item->getItem($item_id);
        $comments = $this->comment->getComments($item_id);

        $this->generateView(array('item' => $item, 'comments' => $comments));
    }
    // Ajoute un commentaire sur un billet
    public function comment() {
        $item_id = $this->request->getParameter("id");
        $author= $this->request->getParameter("author");
        $content = $this->request->getParameter("content");

        $this->comment->addComment($author, $content, $item_id);

        // Exécution de l'action par défaut pour réafficher la liste des billets
        $this->executeAction("index");
    }
}
