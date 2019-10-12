<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';

/**
 * Contrôleur des actions liées au compte user
 *
 * @author Sébastien Merour
 */
 class ControllerAccount extends Controller {
     private $user;
     private $item;
     public function __construct() {
         $this->user = new User();
         $this->item = new Item();
     }

     // Read
     // Affichage de Mon Compte :
     function index() {
       $user = $this->request->getSession()->setAttribut("user", $this->user);
       $user = $this->user->getUser($_SESSION['id_user']);
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


     // Update

     /**
      * Modifie les infos user
      *
      * @throws Exception S'il manque des infos sur le user
      */

      // Affichage de la page de modification de user :
     function modifyuser()
     {
         $items = $this->item->count();
         $number_of_items  = $this->item->getNumberOfItems();
         $number_of_items_pages = $this->item->getNumberOfPages();
         $user = $this->request->getSession()->setAttribut("user", $this->user);
         $user = $this->user->getUser($_SESSION['id_user']);
         $this->generateView(array(
         'items' => $items,
         'user' => $user,
         'number_of_items' => $number_of_items,
         'number_of_items_pages' => $number_of_items_pages
       ));
     }



      // Modification d'utilisateur :
      public function updateuser()
      {
          // $user = $_SESSION['id_user'];
          $username = $this->request->getParameter("username");
          $pass = $this->request->getParameter("pass");
          $email = $this->request->getParameter("email");
          $firstname = $this->request->getParameter("firstname");
          $name = $this->request->getParameter("name");
          $date_naissance = $this->request->getParameter("date_naissance");
          $user = $this->request->getSession()->getAttribut("user");
          $this->user->changeUser($username, $pass, $email, $firstname, $name, $date_naissance);
          $user = $this->user->getUser($user_id);
          if ($user  === false) {
              throw new Exception('Impossible de modifier l\' utilisateur !');
          }
          else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
          }
      }

 }
