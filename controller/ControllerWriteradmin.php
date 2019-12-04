<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';

/**
 * Contrôleur gérant la page d'accueil de l'administration du site
 *
 * @author Sébastien Merour
 */

 class ControllerWriteradmin extends Controller {
   private $user;
   private $item;
   private $comment;


   public function __construct()
   {
       $this->user = new User();
       $this->item = new Item();
       $this->comment = new Comment();
   }

   // Affichage de la page de connexion :
   public function index()
   {
     $this->generateadminView();
   }

   public function dashboard()
   {
     $items = $this->item->count();
     $items = $this->item->getItems();
     $number_of_items  = $this->item->count();
     $items_current_page = 1;
     $page_previous_items = $items_current_page - 1;
     $page_next_items = $items_current_page + 1;
     $number_of_items_pages = $this->item->getNumberOfPages();
     $this->generateadminView(array(
     'items' => $items,
     'number_of_items' => $number_of_items,
     'items_current_page' => $items_current_page,
     'page_previous_items' => $page_previous_items,
     'page_next_items' => $page_next_items,
     'number_of_items_pages' => $number_of_items_pages
   ));
   }


   public function listitems()
   {
     $items = $this->item->count();
     $items = $this->item->getItems();
     $number_of_items  = $this->item->count();
     $items_current_page = $this->request->getParameter("id");
     $items = $this->item->getPaginationItems($items_current_page);
     $number_of_items_pages = $this->item->getNumberOfPages();
     $page_previous_items = $items_current_page - 1;
     $page_next_items = $items_current_page + 1;
     $this->generateadminView(array(
     'items' => $items,
     'number_of_items' => $number_of_items,
     'items_current_page' => $items_current_page,
     'page_previous_items' => $page_previous_items,
     'page_next_items' => $page_next_items,
     'number_of_items_pages' => $number_of_items_pages
   ));
   }

   public function tomoderate()
   {
     $comments_reported_current_page = 1;
     $comments_reported_previous_page = $comments_reported_current_page -1;
     $comments_reported_next_page = $comments_reported_current_page -1;
     $comments_reported        = $this->comment->selectCommentsReported($comments_reported_current_page);
     $default= "default.png";
     $number_of_comments_reported_pages = $this->comment->getNumberOfCommentsReportedPagesFromAdmin();
     $counter_comments_reported       = $this->comment->getTotalOfCommentsReported();
     $this->generateadminView(array(
     'comments_reported' => $comments_reported,
     'default'=> $default,
     'comments_reported_current_page' => $comments_reported_current_page,
     'comments_reported_previous_page' => $comments_reported_previous_page,
     'comments_reported_next_page' => $comments_reported_next_page,
     'number_of_comments_reported_pages' => $number_of_comments_reported_pages,
     'counter_comments_reported' => $counter_comments_reported
   ));
   }

   public function listtomoderate()
   {
     $comments_reported_current_page = $this->comment->getCommentsReportedCurrentPage();
     $comments_reported_previous_page = $comments_reported_current_page -1;
     $comments_reported_next_page = $comments_reported_current_page -1;
     $comments_reported        = $this->comment->selectCommentsReported($comments_reported_current_page);
     $default= "default.png";
     $number_of_comments_reported_pages = $this->comment->getNumberOfCommentsReportedPagesFromAdmin();
     $counter_comments_reported       = $this->comment->getTotalOfCommentsReported();
     $this->generateadminView(array(
     'comments_reported' => $comments_reported,
     'default'=> $default,
     'comments_reported_current_page' => $comments_reported_current_page,
     'comments_reported_previous_page' => $comments_reported_previous_page,
     'comments_reported_next_page' => $comments_reported_next_page,
     'number_of_comments_reported_pages' => $number_of_comments_reported_pages,
     'counter_comments_reported' => $counter_comments_reported
   ));
   }


   public function allcomments()
   {
     $comments_current_page = 1;
     $comments_previous_page = $comments_current_page -1;
     $comments_next_page = $comments_current_page +1;
     $comments        = $this->comment->selectComments($comments_current_page);
     $default= "default.png";
     $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromAdmin();
     $counter_comments        = $this->comment->getTotalOfComments();
     $this->generateadminView(array(
     'comments' => $comments,
     'default'=> $default,
     'comments_current_page' => $comments_current_page,
     'comments_previous_page' => $comments_previous_page,
     'comments_next_page' => $comments_next_page,
     'number_of_comments_pages' => $number_of_comments_pages,
     'counter_comments' => $counter_comments
   ));
   }

   public function listallcomments()
   {
     $comments_current_page = $this->comment->getCommentsCurrentPage();
     $comments_previous_page = $comments_current_page -1;
     $comments_next_page = $comments_current_page +1;
     $comments        = $this->comment->selectComments($comments_current_page);
     $default= "default.png";
     $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromAdmin();
     $counter_comments        = $this->comment->getTotalOfComments();
     $this->generateadminView(array(
     'comments' => $comments,
     'default'=> $default,
     'comments_current_page' => $comments_current_page,
     'comments_previous_page' => $comments_previous_page,
     'comments_next_page' => $comments_next_page,
     'number_of_comments_pages' => $number_of_comments_pages,
     'counter_comments' => $counter_comments
   ));
   }



   // ITEMS
   // Create :

   // Affichage du formulaire ce création d'article
   public function additem() {
     $items = $this->item->count();
     $this->generateadminView(array(
     'items' => $items
   ));
   }

   public function createitem()
   {
     if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
       $messages  = array();
       $user_id = $_SESSION['id_user_admin'];
       $title = $this->request->getParameter("title");
       $content = $this->request->getParameter("content");
       $this->item->insertItem($user_id, $title, $content);
       $messages['confirmation'] = 'L\'article a bien été ajouté !';
       if (!empty($messages)) {
           $_SESSION['messages'] = $messages;
           header('Location: ../writeradmin/dashboard');
           exit;
     }
   }
     else {
       $this->uploadItemImage();
         }
     }



public function uploadItemImage()
{
  $errors   = array();
  $messages  = array();
  $title = $this->request->getParameter("title");
  $content = $this->request->getParameter("content");
  $file_infos = pathinfo($_FILES['image']['name']);
  $extension_upload = $file_infos['extension'];
  $extensions_authorized = array('jpg', 'jpeg', 'gif', 'png');
  $user_id = $_SESSION['id_user_admin'];
  $time = date("Y-m-d-H-i-s");
  $newtitle = str_replace(' ','-',strtolower($title));
  $itemimagename = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
  $itemimagename = "{$time}-$newtitle.{$extension_upload}";
  $destination = ROOT_PATH. 'public/images/item_images';

  if (!in_array($extension_upload, $extensions_authorized)) {
    $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée !';
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../writeradmin/additem');
        exit;
      }
  }

  else {
    // On peut valider le fichier et le stocker définitivement
    move_uploaded_file($_FILES['image']['tmp_name'],$destination."/".$itemimagename);
    $this->item->insertItemImage($user_id, $title, $itemimagename, $content);
    $messages['confirmation'] = 'L\'article a bien été ajouté !';
    if (!empty($messages)) {
        $_SESSION['messages'] = $messages;
        header('Location: ../writeradmin/dashboard');
        exit;
      }
  }
}


   // Read :
   public function readitem()
   {

       $item_id = $this->request->getParameter("id");
       $item = $this->item->getItem($item_id);
       $this->generateadminView(array(
       'item' => $item
     ));
   }


   // Update :
   // Modification d'un article

   public function updateitem()
   {

     $errors    = array();
     $messages  = array();
     $title = $this->request->getParameter("title");
     $content = $this->request->getParameter("content");

     if (isset($_FILES['image'])  AND $_FILES['image']['error'] == 0)
     {
       $file_infos = pathinfo($_FILES['image']['name']);
       $extension_upload = $file_infos['extension'];
       $extensions_authorized = array('jpg', 'jpeg', 'gif', 'png');
       $time = date("Y-m-d-H-i-s")."-";
       $newtitle = str_replace(' ','-',strtolower($title));
       $itemimagename = str_replace(' ','-',strtolower($_FILES['image']['name']));
       $itemimagename = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
       $itemimagename = "{$time}$newtitle.{$extension_upload}";

       $destination = ROOT_PATH. 'public/images/item_images';

         if (!$_FILES['image']['error'] == 0) {
         $errors['uploadfailed'] = 'L\'envoi du fichier a échoué.<br>';
         }

         if (!$_FILES['image']['size'] <= 1000000) {
           $errors['toobig'] = 'Le fichier est trop gros.<br>';
           }

         if (!in_array($extension_upload, $extensions_authorized)) {
           $errors['ext'] = 'L\'extension du fichier n\'est pas autorisée.<br>';
         }

         else {
         move_uploaded_file($_FILES['image']['tmp_name'],$destination."/".$itemimagename);
         $item_id = $this->request->getParameter("id");
         $this->item->changeItemImage($title, $itemimagename, $content, $item_id);
         $item = $this->item->getItem($item_id);

         if ($item  === false) {
             throw new Exception('Impossible de modifier l\' article !');
         }
         else {
           $messages['confirmation'] = 'L\'article a bien été modifié !';
           $this->generateadminView();
         }
         }
     }

     else {
       $item_id = $this->request->getParameter("id");
       $this->item->changeItem($title, $content, $item_id);
       $item = $this->item->getItem($item_id);
       if ($item  === false) {
           throw new Exception('Impossible de modifier l\' article !');
       }
       else {
         $messages['confirmation'] = 'L\'article a bien été modifié !';
         $this->generateadminView();
       }
     }
   }


   // Delete :
   // Suppression d'un article
   public function removeitem()
   {

       $item_id = $this->request->getParameter("id");
       $this->item->eraseItem($item_id);
       if ($item_id  === false) {
           throw new Exception('Impossible de supprimer l\' article !');
       }
       else {
         $messages['confirmation'] = 'L\'article a bien été supprimé !';
         $this->generateadminView();
       }
   }


   // COMMENTS
   // Pas de création de commentaire depuis le Backend.

   // Read :
   // Affichage d'un commentaire
   public function readcomment()
   {
     $id_comment = $this->request->getParameter("id");
     $comment = $this->comment->getComment($id_comment);
     $default = "default.png";
     $this->generateadminView(array(
     'comment' => $comment,
     'default'=> $default
   ));
   }

   // Update :
   // Modification d'un commentaire
   public function updatecomment()
   {
     $comment = $this->request->getParameter("id");
     $this->comment->changeCommentAdmin($content);
     $comment = $this->comment->getItem($id_comment);
     if ($comment  === false) {
         throw new Exception('Impossible de modifier le commentaire !');
     }
     else {
       $messages['confirmation'] = 'Le commentaire a bien été modifié !';
       $this->generateadminView();
     }
   }

   // Delete :
   // Suppression d'un commentaire
   public function removecomment()
   {
     $id_comment = $this->request->getParameter("id");
     $this->comment->eraseComment($id_comment);
     // Ici on affiche le message de confirmation :
     $itemmessages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
     if (!empty($itemmessages)) {
         $_SESSION['messages'] = $itemmessages;
         header('Location: ../allcomments');
         exit;
       }
   }
   public function removecommentreported()
   {
     $id_comment = $this->request->getParameter("id");
     $this->comment->eraseComment($id_comment);
     // Ici on affiche le message de confirmation :
     $itemmessages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
     if (!empty($itemmessages)) {
         $_SESSION['messages'] = $itemmessages;
         header('Location: ../tomoderate');
         exit;
       }
   }





}
