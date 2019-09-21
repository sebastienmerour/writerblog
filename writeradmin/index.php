<?php
session_start();
require __DIR__ . '/../controller/backend.php';
define("BASE_URL", "/writerblog/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/writerblog/");

    try {
    // Connexion
    if (!isset($_SESSION['id_user_admin'])) {
      if (isset($_GET['action'])) {
          if ($_GET['action'] == 'logincheck') {
            logInCheck($_POST['username'], $_POST['pass']);
            }
            else {
              logIn();
            }
          }
          else {
          logIn();
        }
        }

    else {

            // Par défaut, on affiche la liste des articles :
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'listitems') {
                listItems();
            }

            // Sinon, on fait appel au CRUDE :
            // ITEMS
            // Create :
            elseif ($_GET['action'] == 'additem') {
                addItem();
            }
            elseif ($_GET['action'] == 'createitem') {
                if (!empty($_POST['title']) && !empty($_POST['content'])) {
                  createItem($_SESSION['id_user_admin'], $_POST['title'], isset($_FILE['image']), $_POST['content']
                  );
                } else {
                    // Autre exception
                    throw new Exception('Tous les champs ne sont pas renseignés !');
                }
            }

            // Read :
            elseif ($_GET['action'] == 'readitem') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    readItem();
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
            }
            // Update :
            elseif ($_GET['action'] == 'updateitem') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['title'])) {
                        updateItem($_POST['title'], isset($_FILE['image']), $_POST['content'], $_GET['id']);
                    } else {
                        throw new Exception('Tous les champs ne sont pas remplis !');
                    }
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
            }
            elseif ($_GET['action'] == 'updateitemconfirmation') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    updateItemConfirmation();
                } else {
                    throw new Exception('Aucun article trouvé !');
                }
            }
            // Delete :
            elseif ($_GET['action'] == 'deleteitem') {
                if (!empty($_GET['id']) && !empty($_SESSION['id_user_admin'])) {
                    removeItem($_GET['id']);
                } else {
                    // Autre exception
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
            }
            elseif ($_GET['action'] == 'deleteitemconfirmation') {
                deleteItemConfirmation();
            }

            // COMMENTS
            // Pas de création de commentaire depuis le Backend.
            // Read :
            elseif ($_GET['action'] == 'readcomment') {
                if (isset($_GET['id_comment']) && $_GET['id_comment'] > 0) {
                    readComment();
                } else {
                    throw new Exception('Aucun commentaire trouvé !');
                }
            }
            // Update :
            elseif ($_GET['action'] == 'updatecomment') {
                if (isset($_GET['id_comment']) && $_GET['id_comment'] > 0) {
                    if (!empty($_POST['content'])) {
                        updateComment($_GET['id_comment'], $_POST['content']);
                    } else {
                        throw new Exception('Tous les champs ne sont pas remplis !');
                    }
                } else {
                    throw new Exception('Aucun identifiant d\'item envoyé');
                }
            }
            elseif ($_GET['action'] == 'updatecommentconfirmation') {
                if (isset($_GET['id_comment']) && $_GET['id_comment'] > 0) {
                    updateCommentConfirmation();
                } else {
                    throw new Exception('Aucun commentaire trouvé !');
                }
            }
            // Delete :
            elseif ($_GET['action'] == 'deletecomment') {
                if (!empty($_GET['id_comment']) && !empty($_SESSION['id_user_admin'])) {
                    removeComment($_GET['id_comment']);
                } else {
                    // Autre exception
                    throw new Exception('Aucun identifiant de commentaire envoyé');
                }
            }
            elseif ($_GET['action'] == 'deletecommentconfirmation') {
                deleteCommentConfirmation();
            }
            // Déconnexion
            elseif ($_GET['action'] == 'logout') {
                logOut();
            }
          }

            else {
            listItems();
          }

      }
}
    catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
