<?php
session_start();
require __DIR__ . '/../controller/frontend.php';
define("BASE_URL", "/writerblog/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/writerblog/");

try {

    if (!isset($_SESSION['id_user'])) {
        if (isset($_GET['action'])) {
          // Create
            if ($_GET['action'] == 'adduser') {
              addUser();
          } elseif ($_GET['action'] == 'createuser') {
              if (!empty($_POST['username']) && !empty($_POST['pass']) && !empty($_POST['email'])) {

                  createUser($_POST['username'], $_POST['pass'], $_POST['email']);
              } else {
                  // Autre exception
                  throw new Exception('Tous les champs ne sont pas renseignés !');
              }
          }
            // Connexion
            elseif ($_GET['action'] == 'logincheck') {
                logInCheck($_POST['username'], $_POST['pass']);
            }
            else {
                logIn();
            }
        } else {
            logIn();
        }
    } else {
        if (isset($_GET['action'])) {
            // Read
            if ($_GET['action'] == 'readuser' AND isset($_GET['id_user'])) {
                readUserProfile($_GET['id_user']);
            }
            elseif ($_GET['action'] == 'readuser') {
                readUser($_SESSION['id_user']);
            }
            // Update
            elseif ($_GET['action'] == 'modifyuser') {
                modifyUser();
            }
            elseif ($_GET['action'] == 'updateuser') {
                if (isset($_POST['modifyuser'])) {
                    updateUser($_POST['username'], $_POST['pass'], $_POST['email'], $_POST['firstname'], $_POST['name'], $_POST['date_naissance']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            elseif ($_GET['action'] == 'modifyusername') {
                modifyUsername();
            }
            elseif ($_GET['action'] == 'updateusername') {
                if (isset($_POST['modifyusername'])) {
                    updateUsername($_POST['username']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            elseif ($_GET['action'] == 'updateavatar') {

                    updateAvatar(isset($_FILE['avatar']));

            }
            // Déconnexion
            elseif ($_GET['action'] == 'logout') {
                logOut();
            } else {
                readUser($_SESSION['id_user']);
            }
        } else {
            readUser($_SESSION['id_user']);
        }

    }

}


catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
