<?php
// Chargement des classes
require_once __DIR__ . '/../model/PostManager.php';
require_once __DIR__ . '/../model/CommentManager.php';
require_once __DIR__ . '/../model/UserManager.php';

// ITEMS
// Create : pas de Create sur le frontend


// Read
// Lister les articles :
function listItems()
{
    $postManager = new \SM\Blog\Model\PostManager();
    $items = $postManager->getItems();
    $number_of_items = $postManager->getNumberOfItems();
    $items_current_page = $postManager->getCurrentPage();
    $number_of_items_pages = $postManager->getNumberOfPages();
    require __DIR__ . '/../view/frontend/item_list_view.php';
}

// Affichage d'un seul item avec ses commentaires - pour user inconnu
function readItem()
{
    $postManager = new \SM\Blog\Model\PostManager();
    $commentManager = new \SM\Blog\Model\CommentManager();
    $item = $postManager->getItem($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);
    $default= "default.png";
    $comments_current_page = $commentManager->getCommentsCurrentPageFromItem();
    $number_of_comments =  $commentManager->getNumberOfCommentsFromItem();
    $number_of_comments_pages = $commentManager->getNumberOfCommentsPagesFromItem();
    require __DIR__ . '/../view/frontend/item_view.php';
}

// Affichage d'un seul item avec ses commentaires - pour user connecté
function readItemLoggedIn()
{
    $postManager = new \SM\Blog\Model\PostManager();
    $commentManager = new \SM\Blog\Model\CommentManager();
    $userManager = new \SM\Blog\Model\UserManager();
    $item = $postManager->getItem($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);
    $user= $userManager->getUser($_SESSION['id_user']);
    $default= "default.png";
    $comments_current_page = $commentManager->getCommentsCurrentPageFromItem();
    $number_of_comments =  $commentManager->getNumberOfCommentsFromItem();
    $number_of_comments_pages = $commentManager->getNumberOfCommentsPagesFromItem();
    require __DIR__ . '/../view/frontend/item_view.php';
}



// COMMENTS //
// Create
// Ajout d'un nouveau commentaire :
function createComment($item_id, $author, $content)
{
    $commentManager = new \SM\Blog\Model\CommentManager();
    $affectedLines = $commentManager->insertComment($item_id, $author, $content);
    if ($affectedLines === false) {
      // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
      throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=readitem&id=' . $item_id);
    }
}

function createCommentLoggedIn($item_id, $user_id, $author, $content)
{
    $commentManager = new \SM\Blog\Model\CommentManager();
    $user_id = $_SESSION['id_user'];
    $affectedLines = $commentManager->insertCommentLoggedIn($item_id, $user_id, $author, $content);
    if ($affectedLines === false) {
      // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
      throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=readitem&id=' . $item_id);
    }
}

// Read
// Affichage d'un commentaire :
function readComment()
{
    $postManager = new \SM\Blog\Model\PostManager();
    $item = $postManager->getItem($_GET['id']);
    $commentManager = new \SM\Blog\Model\CommentManager();
    $comment = $commentManager->getComment($_GET['id_comment']);
    $comments = $commentManager->getComments($_GET['id']);
    $default= "default.png";
    $comments_current_page = $commentManager->getCommentsCurrentPageFromItem();
    $number_of_comments =  $commentManager->getNumberOfCommentsFromItem();
    $number_of_comments_pages = $commentManager->getNumberOfCommentsPagesFromItem();
    require __DIR__ . '/../view/frontend/comment_view.php';
}

// Update
// Modification d'un commentaire :
function updateComment($id_comment, $content)
{
  $postManager = new \SM\Blog\Model\PostManager();
  $commentManager = new \SM\Blog\Model\CommentManager();
  $item = $postManager->getItem($_GET['id']);
  $newComment = $commentManager->changeComment($id_comment, $content);
  if ($newComment === false) {
      throw new Exception('Impossible de modifier le commentaire !');
  }
  else {
      echo 'commentaire : ' . $_POST['comment'];
      header('Location: index.php?id=' . $item['id'] . '&action=updatecommentconfirmation&id_comment=' . $id_comment);
  }
}

// Confirmation de Modification d'un commentaire :
function updateCommentConfirmation()
{
  $postManager = new \SM\Blog\Model\PostManager();
  $item = $postManager->getItem($_GET['id']);
  $commentManager = new \SM\Blog\Model\CommentManager();
  $comment = $commentManager->getComment($_GET['id_comment']);
  $comments = $commentManager->getComments($_GET['id']);
  $default= "default.png";
  $messages = array();
  $messages['commentupdated'] = 'Le commentaire a bien été modifié !';
  if(!empty($messages)) {
        $_SESSION['messages'] = $messages;

      }
  $comments_current_page = $commentManager->getCommentsCurrentPageFromItem();
  $number_of_comments =  $commentManager->getNumberOfCommentsFromItem();
  $number_of_comments_pages = $commentManager->getNumberOfCommentsPagesFromItem();
  require __DIR__ . '/../view/frontend/comment_confirmation_view.php';
}

// USERS //
// Create

// Inscription d'un nouveau user :
// Affichage du formulaire d'inscription :
function addUser() {
  $userManager = new \SM\Blog\Model\UserManager();
  require __DIR__ . '/../view/frontend/user_create_view.php';
}

// Création du user :
function createUser($username, $pass, $email)
{
    $userManager = new \SM\Blog\Model\UserManager();
    $userLines = $userManager->insertUser($username, $pass, $email);
    if ($userLines === false) {
      // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
      throw new Exception('Impossible d\'ajouter l\'article !');
  } else {
      header('Location: index.php');
  }
  require __DIR__ . '/../view/backend/index.php?action=createuser';

}

// Read
// Affichage de Mon Compte :
function readUser() {
  $userManager = new \SM\Blog\Model\UserManager();
  $postManager = new \SM\Blog\Model\PostManager();
  $number_of_items = $postManager->getNumberOfItems();
  $number_of_items_pages = $postManager->getNumberOfPages();
  $user= $userManager->getUser($_SESSION['id_user']);
  require __DIR__ . '/../view/frontend/user_view.php';
}

// Affichage du Profil d'un utilisateur :
function readUserProfile() {
  $userManager = new \SM\Blog\Model\UserManager();
  $postManager = new \SM\Blog\Model\PostManager();
  $number_of_items = $postManager->getNumberOfItems();
  $number_of_items_pages = $postManager->getNumberOfPages();
  $user= $userManager->getUser($_SESSION['id_user']);
  require __DIR__ . '/../view/frontend/user_profile_view.php';
}

// Update
function modifyUser()
{
    $userManager = new \SM\Blog\Model\UserManager();
    $postManager = new \SM\Blog\Model\PostManager();
    $number_of_items = $postManager->getNumberOfItems();
    $number_of_items_pages = $postManager->getNumberOfPages();
    $user= $userManager->getUser($_SESSION['id_user']);

    require __DIR__ . '/../view/frontend/user_modification_view.php';
}

// Modification d'utilisateur :
function updateUser($username, $pass, $email, $firstname, $name, $date_naissance)
{
    $userManager = new \SM\Blog\Model\UserManager();
    $user = $_SESSION['id_user'];
    $newUser = $userManager->changeUser($username, $pass, $email, $firstname, $name, $date_naissance);
    if ($newUser  === false) {
        throw new Exception('Impossible de modifier l\' utilisateur !');
    }
    else {
        echo 'utilisateur : ' . $_SESSION['id_user'];
        header('Location: ../user/index.php?action=readuser');
    }
}

// Modification d'identifiant :
function modifyUsername()
{
    $userManager = new \SM\Blog\Model\UserManager();
    $postManager = new \SM\Blog\Model\PostManager();
    $number_of_items = $postManager->getNumberOfItems();
    $number_of_items_pages = $postManager->getNumberOfPages();
    $user= $userManager->getUser($_SESSION['id_user']);

    require __DIR__ . '/../view/frontend/user_username_modification_view.php';
}

// Modification d'identifiant :
function updateUsername($username)
{
    $userManager = new \SM\Blog\Model\UserManager();
    $user = $_SESSION['id_user'];
    $newUsername = $userManager->changeUsername($username);
    if ($newUsername  === false) {
        throw new Exception('Impossible de modifier l\' identifiant !');
    }
    else {
        echo 'utilisateur : ' . $_SESSION['id_user'];
        header('Location: ../user/index.php?action=readuser');
    }
}

// Modification de l'avatar :
function updateAvatar($avatarname)
{
    $userManager = new \SM\Blog\Model\UserManager();
    $user = $_SESSION['id_user'];
    if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0)
    {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['avatar']['size'] <= 1000000)
            {
              $file_infos = pathinfo($_FILES['avatar']['name']);
              $extension_upload = $file_infos['extension'];
              $extensions_authorized = array('jpg', 'jpeg', 'gif', 'png');
              $user_id = $_SESSION['id_user'];
              $time = date("Y-m-d-H-i-s")."-";
              $avatarname = str_replace(' ','-',strtolower($_FILES['avatar']['name']));
              $avatarname = preg_replace("/\.[^.\s]{3,4}$/", "", $avatarname);
              $avatarname = "{$time}_{$user_id}_avatar.{$extension_upload}";
              $destination = ROOT_PATH. 'public/images/avatars';
              if (in_array($extension_upload, $extensions_authorized))
              {
                      // On peut valider le fichier et le stocker définitivement
                      move_uploaded_file($_FILES['avatar']['tmp_name'],$destination."/".$avatarname);
                      $newAvatar = $userManager->changeAvatar($avatarname);

                     echo "L'avatar a bien été envoyé !";
   									 header('Location: ../user/index.php?action=readuser');
   			}
   			else {
   				echo "L'extension du fichier n'est pas autorisée.";
          header('Location: ../user/index.php?action=readuser');
   			}
   }
   else {
   echo "Le fichier est trop gros.";
   header('Location: ../user/index.php?action=readuser');
   }
   }
   else {
   echo "L'envoi du fichier a échoué.";
   header('Location: ../user/index.php?action=readuser');
   }

}


// Connexion et Déconnexion
// Connexion :
function logIn() {
  $userManager = new \SM\Blog\Model\UserManager();
  require __DIR__ . '/../view/frontend/user_login_view.php';
}

// Connexion (Vérification)
function logInCheck($username, $passwordAttempt) {

  $userManager = new \SM\Blog\Model\UserManager();
  $affectedLines = $userManager->logInUser($username, $passwordAttempt);
  if ($affectedLines === false) {
    // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
    throw new Exception('Impossible de se connecter !');
  }
  else {
      header('Location: ../user/index.php?action=readuser');
  }
}

// Déconnexion :
function logOut() {
  $userManager = new \SM\Blog\Model\UserManager();
  $postManager = new \SM\Blog\Model\PostManager();
  $number_of_items = $postManager->getNumberOfItems();
  $number_of_items_pages = $postManager->getNumberOfPages();
  require __DIR__ . '/../view/frontend/user_logout_view.php';
}
