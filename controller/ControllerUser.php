<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';

/**
 * Contrôleur des actions liées aux utilisateurs
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerUser extends Controller
{
    private $user;
    private $item;
    public function __construct()
    {
        $this->user = new User();
        $this->item = new Item();
    }

    // Create

    // Affichage du formulaire d'inscription :
    public function adduser()
    {
        $items                 = $this->item->count();
        $number_of_items       = $this->item->count();
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
        if (!empty($_POST['username']) && !empty($_POST['pass']) && !empty($_POST['email'])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secretKey      = '6LerX8QUAAAAAOxzR50kzN9yY9nCObsi2vz1FmcR';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $username       = $this->request->getParameter("username");
                $pass           = $this->request->getParameter("pass");
                $email          = $this->request->getParameter("email");

                if ($responseData->success) {
                    $this->user->insertUser($username, $pass, $email);
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: adduser');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: adduser');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: adduser');
            exit;
        }

    }

    // Read

    // Affichage de Mon Compte :
    function index()
    {
        $user                  = $this->request->getSession()->setAttribut("user", $this->user);
        $user                  = $this->user->getUser($_SESSION['id_user']);
        $items                 = $this->item->count();
        $number_of_items       = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateView(array(
            'user' => $user,
            'items' => $items,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Affichage du Profil d'un utilisateur :
    function profile()
    {
        $user_id               = $this->request->getParameter("id");
        $user                  = $this->user->getUser($user_id);
        $items                 = $this->item->count();
        $number_of_items       = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateView(array(
            'user' => $user,
            'items' => $items,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Update

    // Affichage de la page de modification de user :
    function modifyuser()
    {
        $items                 = $this->item->count();
        $number_of_items       = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $user                  = $this->request->getSession()->setAttribut("user", $this->user);
        $user                  = $this->user->getUser($_SESSION['id_user']);
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
        $pass       = $this->request->getParameter("pass");
        $email      = $this->request->getParameter("email");
        $firstname  = $this->request->getParameter("firstname");
        $name       = $this->request->getParameter("name");
        $date_birth = $this->request->getParameter("date_birth");
        $user       = $this->request->getSession()->getAttribut("user");
        $this->user->changeUser($pass, $email, $firstname, $name, $date_birth);
        $user = $this->user->getUser($user_id);
        if ($user === false) {
            throw new Exception('Impossible de modifier l\' utilisateur !');
        } else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
        }
    }

    // Modification d'identifiant :
    public function updateusername()
    {
        $username = $this->request->getParameter("username");
        $user     = $this->request->getSession()->getAttribut("user");
        $this->user->changeUsername($username);
        $user = $this->user->getUser($user_id);
        if ($user === false) {
            throw new Exception('Impossible de modifier l\' utilisateur !');
        } else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
        }
    }

    // Modification de l'avatar :
    public function updateavatar()
    {
        $user = $this->request->getSession()->getAttribut("user");

        if (isset($_POST["modifyavatar"])) {
            $errors                = array();
            $messages              = array();
            $fileinfo              = @getimagesize($_FILES["avatar"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extension_upload      = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $extensions_authorized = array(
                'jpg',
                'jpeg',
                'gif',
                'png'
            );
            $user_id               = $_SESSION['id_user'];
            $time                  = date("Y-m-d-H-i-s");
            $avatarname            = str_replace(' ', '-', strtolower($_FILES['avatar']['name']));
            $avatarname            = preg_replace("/\.[^.\s]{3,4}$/", "", $avatarname);
            $avatarname            = "{$time}-{$user_id}-avatar.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/avatars';

            if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../user/');
                    exit;
                }
            } else if (($_FILES["avatar"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../user/');
                    exit;
                }
            } else if ($width < "300" || $height < "200") {
                $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../user/');
                    exit;
                }
            } else {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $destination . "/" . $avatarname);
                $newAvatar = $this->user->changeAvatar($avatarname);
            }
        }
    }

}
