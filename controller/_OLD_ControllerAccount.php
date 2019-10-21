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

     // Create

     // Inscription d'un nouveau user :
     // Affichage du formulaire d'inscription :
     public function adduser() {
       $items = $this->item->count();
       $number_of_items  = $this->item->getNumberOfItems();
       $number_of_items_pages = $this->item->getNumberOfPages();
       $this->generateView(array(
       'items' => $items,
       'number_of_items' => $number_of_items,
       'number_of_items_pages' => $number_of_items_pages
     ));
     }

     // Création du user :
     public function createuser()
     {
         $username = $this->request->getParameter("username");
         $pass = $this->request->getParameter("pass");
         $email = $this->request->getParameter("email");
         $userLines = $this->user->insertUser($username, $pass, $email);
         if ($userLines === false) {

           // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
           throw new Exception('Impossible d\'ajouter l\'article !');
       } else {
           header('Location: index.php');
       }
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
          $pass = $this->request->getParameter("pass");
          $email = $this->request->getParameter("email");
          $firstname = $this->request->getParameter("firstname");
          $name = $this->request->getParameter("name");
          $date_birth = $this->request->getParameter("date_birth");
          $user = $this->request->getSession()->getAttribut("user");
          $this->user->changeUser($pass, $email, $firstname, $name, $date_birth);
          $user = $this->user->getUser($user_id);
          if ($user  === false) {
              throw new Exception('Impossible de modifier l\' utilisateur !');
          }
          else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
          }
      }

      // Modification d'identifiant :
      public function updateusername()
      {
          $username = $this->request->getParameter("username");
          $user = $this->request->getSession()->getAttribut("user");
          $this->user->changeUsername($username);
          $user = $this->user->getUser($user_id);
          if ($user  === false) {
              throw new Exception('Impossible de modifier l\' utilisateur !');
          }
          else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
          }
      }
      // Modification de l'avatar :
      public function updateAvatar()
      {

          $user = $this->request->getSession()->getAttribut("user");
          if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0)
          {
                  // Testons si le fichier n'est pas trop gros
                  if ($_FILES['avatar']['size'] <= 1000000)
                  {
                    $file_infos = pathinfo($_FILES['avatar']['name']);
                    $extension_upload = $file_infos['extension'];
                    $extensions_authorized = array('jpg', 'jpeg', 'gif', 'png');
                    $user_id = $_SESSION['id_user'];
                    $time = date("Y-m-d-H-i-s");
                    $avatarname = str_replace(' ','-',strtolower($_FILES['avatar']['name']));
                    $avatarname = preg_replace("/\.[^.\s]{3,4}$/", "", $avatarname);
                    $avatarname = "{$time}-{$user_id}-avatar.{$extension_upload}";
                    $destination = ROOT_PATH. 'public/images/avatars';
                    if (in_array($extension_upload, $extensions_authorized))
                    {
                            // On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($_FILES['avatar']['tmp_name'],$destination."/".$avatarname);
                            $newAvatar = $this->user->changeAvatar($avatarname);

                           echo "L'avatar a bien été envoyé !";
                           $this->redirect("user");
         			}
         			else {
         				echo "L'extension du fichier n'est pas autorisée.";
                $this->redirect("user");
         			}
         }
         else {
         echo "Le fichier est trop gros.";
         $this->redirect("user");
         }
         }
         else {
         echo "L'envoi du fichier a échoué.";
         $this->redirect("user");
         }

      }




 }
