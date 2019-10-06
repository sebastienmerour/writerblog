<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';

class ControllerUser extends Controller {
    private $user;
    private $item;
    public function __construct() {
        $this->user = new User();
        $this->item = new Item();
    }

    // Affichage du Profil d'un utilisateur :
    function index() {
      $user_id = $this->request->getParameter("id");
      $user = $this->user->getUser($user_id);
      $items = $this->item->count();
      $number_of_items  = $this->item->getNumberOfItems();
      $number_of_items_pages = $this->item->getNumberOfPages();
      $this->generateView(array(
      'user' => $user,
      'items' => $items,
      'number_of_items' => $number_of_items,
      'number_of_items_pages' => $number_of_items_pages
    ));
    }

}
