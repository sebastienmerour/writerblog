<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';

class ControllerHome extends Controller {
    private $item;
    public function __construct() {
        $this->item = new Item();
    }
    // Affiche la liste de tous les articles du blog
    public function index() {
        $items = $this->item->count();
        $items = $this->item->getItems();
        $this->generateView(array('items' => $items));
    }
}
