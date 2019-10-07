<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';

/**
 * Contrôleur gérant la connexion au site
 *
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
    public function index()
    {
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
    public function login()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $affectedLines = $user->logInUser($username, $passwordAttempt);
            if ($affectedLines === false) {
              $this->generateView(array('msgErrorr' => 'Impossible de se connecter !'),
                      "index");}
            else  {
                header('Location: ../user/index.php?action=readuser');
            }
        }
        else {
            throw new Exception("Action impossible : identifiant ou mot de passe non défini");
          }
    }


}
