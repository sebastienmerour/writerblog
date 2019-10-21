<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';

/**
 * Contrôleur gérant la déconnexion du site
 *
 * @author Sébastien Merour
 */

 class ControllerLogout extends Controller
 {
     private $user;
     private $item;

     public function __construct()
     {
         $this->user = new User();
         $this->item = new Item();
     }
     // Déconnexion :
     public function index() {
       $items = $this->item->count();
       $number_of_items  = $this->item->getNumberOfItems();
       $number_of_items_pages = $this->item->getNumberOfPages();
       $this->generateView(array(
       'items' => $items,
       'number_of_items' => $number_of_items,
       'number_of_items_pages' => $number_of_items_pages
     ));
   }
   // Déconnexion de la section d'administration :
   public function admin() {
     $items = $this->item->count();
     $number_of_items  = $this->item->getNumberOfItems();
     $number_of_items_pages = $this->item->getNumberOfPages();
     $this->generateadminView(array(
     'items' => $items,
     'number_of_items' => $number_of_items,
     'number_of_items_pages' => $number_of_items_pages
   ));
 }


   }
