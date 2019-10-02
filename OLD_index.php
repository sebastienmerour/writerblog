<?php
session_start();
require('controller/frontend.php');
define("BASE_URL", "/writerblog/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/writerblog/");

try {
      if (isset($_GET['action'])) {
// ITEMS
// Create : (pas de create pour les items en Front)

// Read :
        if ($_GET['action'] == 'listitems') {
          listItems();
        }
        elseif (isset($_SESSION['id_user']) && $_GET['action'] == 'readitem') {
          if (isset($_GET['id']) && $_GET['id'] > 0) {
              readItemLoggedIn();
          } else {
              throw new Exception('Aucun identifiant d\'article envoyé');
          }
        }
        elseif ($_GET['action'] == 'readitem') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                readItem();
            } else {
                throw new Exception('Aucun identifiant d\'article envoyé');
            }
        }


// Update & Delete : pas d'action en Front

// COMMENTS
// Create :
        elseif ($_GET['action'] == 'createcomment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
              if (isset($_SESSION['id_user']) && !empty($_POST['content'])) {
                  createCommentLoggedIn($_GET['id'], $_SESSION['id_user'], $_POST['author'], $_POST['content']);}
                elseif (!isset($_SESSION['id_user']) && !empty($_POST['content'])) {
                    createComment($_GET['id'], $_POST['author'], $_POST['content']);
                }
                else {
                    // Autre exception
                    throw new Exception('Tous les champs ne sont pas renseignés !');
                }
            } else {
                // Autre exception
                throw new Exception('Aucun identifiant d\'article envoyé');
            }
        }
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
        } elseif ($_GET['action'] == 'updatecommentconfirmation') {
            if (isset($_GET['id_comment']) && $_GET['id_comment'] > 0) {
                updateCommentConfirmation();
            } else {
                throw new Exception('Aucun commentaire trouvé !');
            }
        }

    }

    else {
        listItems();
    }
}
catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
