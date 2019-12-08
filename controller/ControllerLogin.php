<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';

/**
 * Contrôleur gérant la connexion au site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerLogin extends Controller
{
    private $user;
    private $item;

    public function __construct()
    {
        $this->user = new User();
        $this->item = new Item();
    }

    // Affichage de la page de connexion :
    public function index()
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

    // Processus de Connexion d'un user :
    public function login()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username        = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $this->user->logInUser($username, $passwordAttempt);
        } else
            throw new Exception("Action impossible : courriel ou mot de passe non défini");
    }

    // Processus de Connexion d'un user sur l'interdace d'admin :
    public function loginadmin()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username        = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $this->user->logInUserAdmin($username, $passwordAttempt);
        } else
            throw new Exception("Action impossible : courriel ou mot de passe non défini");
    }

    // Appui sur le bouton Deconnexion d'un user :
    public function logout()
    {
        $items                 = $this->item->count();
        $number_of_items       = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        if (ISSET($_SESSION['id_user'])) {
            $this->request->getSession()->destroy();
            // Suppression des cookies de connexion automatique
            setcookie('username', '');
            setcookie('pass', '');
            $this->generateView(array(
                'items' => $items,
                'number_of_items' => $number_of_items,
                'number_of_items_pages' => $number_of_items_pages
            ));
        } else {
            $this->redirect("login/invite");
        }
    }

    // Appui sur le bouton Deconnexion d'un user admin :
    public function logoutadmin()
    {
        if (ISSET($_SESSION['id_user_admin'])) {
            $this->request->getSession()->destroy();
            // Suppression des cookies de connexion automatique
            setcookie('username', '');
            setcookie('pass', '');
            $this->redirect("login/ended");
        } else {
            $this->redirect("login/inviteadmin");
        }
    }

    // On invite un utilisateur non connecté à se connecter :
    public function invite()
    {
        $number_of_items       = $this->item->count();
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Fin de sessionn d'un admin :
    public function ended()
    {
        $this->generateadminView();
    }

    // On invite un admin non connecté à se connecter :
    public function inviteadmin()
    {
        $this->generateadminView();
    }

}
