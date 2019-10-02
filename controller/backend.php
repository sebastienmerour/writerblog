<?php
// Chargement des classes
require_once __DIR__ . '/../model/PostManager.php';
require_once __DIR__ . '/../model/CommentManager.php';
require_once __DIR__ . '/../model/UserManager.php';
require_once __DIR__ . '/../model/ViewManager.php';

// ITEMS
// Create :

// Affichage du formulaire ce création d'article
function addItem() {
  $userManager = new \SM\Blog\Model\UserManager();
  require __DIR__ . '/../view/backend/item_create_view.php';
}

function createItem($idUser, $title, $itemimagename, $content)
{
    $postManager   = new \SM\Blog\Model\PostManager();
    if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
    {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['image']['size'] <= 1000000)
            {
              $file_infos = pathinfo($_FILES['image']['name']);
              $extension_upload = $file_infos['extension'];
              $extensions_authorized = array('jpg', 'jpeg', 'gif', 'png');
              $user_id = $_SESSION['id_user_admin'];
              $time = date("Y-m-d-H-i-s");
              $newtitle = str_replace(' ','-',strtolower($title));
              $itemimagename = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
              $itemimagename = "{$time}-$newtitle.{$extension_upload}";
              $destination = ROOT_PATH. 'public/images/item_images';

              if (in_array($extension_upload, $extensions_authorized))
              {
                      // On peut valider le fichier et le stocker définitivement
                      move_uploaded_file($_FILES['image']['tmp_name'],$destination."/".$itemimagename);

                      $affectedLines = $postManager->insertItem($idUser, $title, $itemimagename, $content);


                     echo "L'image bien été envoyée !";
                     header('Location: ../writeradmin/index.php?action=listitems');
        }
        else {
          echo "L'extension du fichier n'est pas autorisée.";
          header('Location: ../writeradmin/index.php?action=listitems');
        }
   }
   else {
   echo "Le fichier est trop gros.";
   header('Location: ../writeradmin/index.php?action=listitems');
   }
   }
   else {
   echo "L'envoi du fichier a échoué.";
   header('Location: ../writeradmin/index.php?action=listitems');
   }

    require __DIR__ . '/../view/backend/item_create_view.php';


}

// Read :
function readItem()
{
    $postManager = new \SM\Blog\Model\PostManager();
    $item = $postManager->getItem($_GET['id']);
    require __DIR__ . '/../view/backend/item_view.php';
}

function listItems()
{
    $postManager     = new \SM\Blog\Model\PostManager();
    $items = $postManager->count();
    $items           = $postManager->getItems();
    $items_current_page = $postManager->getCurrentPage();
    $number_of_items = $postManager->getNumberOfItems();
    $number_of_items_pages = $postManager->getNumberOfPages();
    $commentManager  = new \SM\Blog\Model\CommentManager();
    $comments        = $commentManager->selectComments();
    $default= "default.png";
    // Vérifier quelle est la page active :
    if (isset($_GET['commentspage'])) {
        $current_comments_page = (int) $_GET['commentspage'];
    } else {
        $current_comments_page = 1;
    }

    $number_of_comments_pages = $commentManager->getNumberOfCommentsPages();
    $counter_comments         = $commentManager->getNumberOfComments();
    require __DIR__ . '/../view/backend/item_list_view.php';
}

// Update :
// Modification d'un article
function updateItem($title, $itemimagename, $content, $item_id)
{
  $postManager = new \SM\Blog\Model\PostManager();
  $errors    = array();
  $messages  = array();

  if (isset($_FILES['image'])  AND $_FILES['image']['error'] == 0)
  {
    $file_infos = pathinfo($_FILES['image']['name']);
    $extension_upload = $file_infos['extension'];
    $extensions_authorized = array('jpg', 'jpeg', 'gif', 'png');
    $user_id = $_SESSION['id_user_admin'];
    $time = date("Y-m-d-H-i-s")."-";
    $itemimagename = str_replace(' ','-',strtolower($_FILES['image']['name']));
    $itemimagename = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
    $itemimagename = "{$time}_image.{$extension_upload}";
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
      $newItem     = $postManager->changeItemImage($title, $itemimagename, $content, $item_id);
      $messages['itemupdated'] = 'L\'article a bien été modifié !';
      header('Location: ../writeradmin/index.php?readitem&id=' . $_GET('id'));
      require __DIR__ . '/../view/backend/item_view.php';
      }
  }
  else {
    $newItem     = $postManager->changeItem($title, $content, $item_id);
    $messages['itemupdated'] = 'L\'article a bien été modifié !';
    header('Location: ../writeradmin/index.php?readitem&id=' . $_GET('id'));
    require __DIR__ . '/../view/backend/item_view.php';
  }
}

// Confirmation de Modification d'un article
function updateItemConfirmation()
{
    $postManager           = new \SM\Blog\Model\PostManager();
    $item                  = $postManager->getItem($_GET['id']);
    $messages                 = array();
    $messages['itemupdated'] = 'L\'article a bien été modifié !';
    if (!empty($messages)) {
        $_SESSION['messages'] = $messages;


    }
    require __DIR__ . '/../view/backend/item_confirmation_view.php';
}

// Delete :
// Suppression d'un article
function removeItem($item_id)
{
    $postManager   = new \SM\Blog\Model\PostManager();
    $items = $postManager->count();
    $affectedLines = $postManager->eraseItem($item_id);
    if ($affectedLines === false) {
        // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
        throw new Exception('Impossible de supprimer l\'article !');
    } else {
        header('Location: index.php?action=deleteitemconfirmation');
    }

}

// Confirmation de la suppression d'un article
function deleteItemConfirmation()
{

    $postManager     = new \SM\Blog\Model\PostManager();
    $items = $postManager->count();
    $items           = $postManager->getItems();
    $number_of_items = $postManager->getNumberOfItems();
    $items_current_page = $postManager->getCurrentPage();
    $number_of_items_pages = $postManager->getNumberOfPages();
    $commentManager  = new \SM\Blog\Model\CommentManager();
    $comments        = $commentManager->selectComments();
    // Vérifier quelle est la page active :
    if (isset($_GET['commentspage'])) {
        $current_comments_page = (int) $_GET['commentspage'];
    } else {
        $current_comments_page = 1;
    }

    $number_of_comments_pages = $commentManager->getNumberOfCommentsPages();
    $counter_comments         = $commentManager->getNumberOfComments();

    $messages                              = array();
    $messages['itemdeleted'] = 'L\'article a bien été supprimé !';
    if (!empty($messages)) {
        $_SESSION['messages'] = $messages;

    }
    require __DIR__ . '/../view/backend/item_deleted_confirmation_view.php';
}


// COMMENTS
// Pas de création de commentaire depuis le Backend.

// Read :
// Affichage d'un commentaire
function readComment()
{
    $commentManager = new \SM\Blog\Model\CommentManager();
    $default= "default.png";
    $userManager = new \SM\Blog\Model\UserManager();
    // $user= $userManager->getUser($_SESSION['id_user']);

    $comment        = $commentManager->getComment($_GET['id_comment']);
    require __DIR__ . '/../view/backend/comment_view.php';

}

// Update :
// Modification d'un commentaire
function updateComment($id_comment, $content)
{
    $commentManager = new \SM\Blog\Model\CommentManager();
    $newComment     = $commentManager->changeComment($id_comment, $content);
    if ($newComment === false) {
        throw new Exception('Impossible de modifier le commentaire !');
    } else {
        header('Location: index.php?action=updatecommentconfirmation&id_comment=' . $id_comment);
    }
}

// Confirmation de Modification d'un commentaire
function updateCommentConfirmation()
{
    $commentManager           = new \SM\Blog\Model\CommentManager();
    $comment                  = $commentManager->getComment($_GET['id_comment']);
    $default= "default.png";
    $messages                 = array();
    $messages['commentupdated'] = 'Le commentaire a bien été modifié !';
    if (!empty($messages)) {
        $_SESSION['messages'] = $messages;

    }
    require __DIR__ . '/../view/backend/comment_confirmation_view.php';
}

// Delete :
// Suppression d'un commentaire
function removeComment($id_comment)
{
    $commentManager = new \SM\Blog\Model\CommentManager();
    $affectedLines  = $commentManager->eraseComment($id_comment);
    if ($affectedLines === false) {
        // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
        throw new Exception('Impossible de supprimer le commentaire !');
    } else {
        header('Location: index.php?action=deletecommentconfirmation#allcomments');
    }


}

// Confirmation de la suppression d'un commentaire
function deleteCommentConfirmation()
{
    $postManager     = new \SM\Blog\Model\PostManager();
    $items = $postManager->count();
    $items           = $postManager->getItems();
    $number_of_items = $postManager->getNumberOfItems();
    $items_current_page = $postManager->getCurrentPage();
    $number_of_items_pages = $postManager->getNumberOfPages();
    $commentManager  = new \SM\Blog\Model\CommentManager();
    $comments        = $commentManager->selectComments();
    // Vérifier quelle est la page active :
    if (isset($_GET['commentspage'])) {
        $current_comments_page = (int) $_GET['commentspage'];
    } else {
        $current_comments_page = 1;
    }

    $number_of_comments_pages = $commentManager->getNumberOfCommentsPages();
    $counter_comments         = $commentManager->getNumberOfComments();

    $messages                                 = array();
    $messages['commentdeleted'] = 'Le commentaire a bien été supprimé !';
    if (!empty($messages)) {
        $_SESSION['messages'] = $messages;

    }
    require __DIR__ . '/../view/backend/comment_deleted_confirmation_view.php';
}

// Connexion et Déconnexion
// Connexion :
function logIn() {
  $userManager = new \SM\Blog\Model\UserManager();
  require __DIR__ . '/../view/backend/user_login_view.php';
}

// Connexion (Vérification)
function logInCheck($username, $passwordAttempt) {

  $userManager = new \SM\Blog\Model\UserManager();
  $affectedLines = $userManager->logInUserAdmin($username, $passwordAttempt);
  if ($affectedLines === false) {
    // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
    throw new Exception('Impossible de se connecter !');
  }
  else {
      header('Location: ../writeradmin/?action=listitems');
  }
}

// Déconnexion :
function logOut() {
  $userManager = new \SM\Blog\Model\UserManager();
  require __DIR__ . '/../view/backend/user_logout_view.php';
}
