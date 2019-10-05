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
        $number_of_items  = $this->item->getNumberOfItems();
        $items_current_page = $this->item->getCurrentPage();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateView(array('items' => $items,
        'number_of_items' => $number_of_items,
        'items_current_page' => $items_current_page,
        'number_of_items_pages' => $number_of_items_pages

      ));
    }
}
