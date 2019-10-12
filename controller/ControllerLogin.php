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

    // Create
    // Inscription d'un nouveau user :
    // Affichage du formulaire d'inscription :
    function adduser() {
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

    // Affichage de la page de connexion :
    public function index()
    {
      $items = $this->item->count();
      $number_of_items  = $this->item->getNumberOfItems();
      $number_of_items_pages = $this->item->getNumberOfPages();
      $this->generateView(array(
      'items' => $items,
      'number_of_items' => $number_of_items,
      'number_of_items_pages' => $number_of_items_pages
    ));
    }


    // Connexion :
    public function login()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass"))
        {
            $username = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $affectedLines = $this->user->logInUser($username, $passwordAttempt);
            }
          else
              throw new Exception("Action impossible : courriel ou mot de passe non défini");
}

    // Deconnexion :
    public function logout()
    {
        $this->request->getSession()->destroy();
        // Suppression des cookies de connexion automatique
        setcookie('username', '');
        setcookie('pass', '');
        $this->redirect("logout");
    }





}
