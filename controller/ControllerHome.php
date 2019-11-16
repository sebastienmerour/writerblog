<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';

/**
 * Contrôleur gérant la page d'accueil
 *
 * @author Sébastien Merour
 */

class ControllerHome extends Controller {
    private $item;
    public function __construct() {
        $this->item = new Item();
    }

    // Lister les articles :
    public function index() {
          //$items = $this->item->count();
          $items = $this->item->getItems();
          $number_of_items  = $this->item->count();
          $items_current_page = 1;
          $number_of_items_pages = $this->item->getNumberOfPages();
          $this->generateView(array(
          'items' => $items,
          'number_of_items' => $number_of_items,
          'items_current_page' => $items_current_page,
          'number_of_items_pages' => $number_of_items_pages
        ));
        }



    public function list() {
      //$items = $this->item->count();
      $number_of_items  = $this->item->count();
      $items_current_page = $this->request->getParameter("id");
      $items = $this->item->getPaginationItems($items_current_page);
      $number_of_items_pages = $this->item->getNumberOfPages();
      $this->generateView(array(
      'items' => $items,
      'number_of_items' => $number_of_items,
      'items_current_page' => $items_current_page,
      'number_of_items_pages' => $number_of_items_pages
    ));
    }




}
