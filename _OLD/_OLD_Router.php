<?php
require_once 'Controller/ControllerHome.php';
require_once 'Controller/ControllerItem.php';
require_once 'Model/ViewManager.php';


class Router {

  private $controllerHome;
  private $controllerItem;

  public function __construct() {
    $this->controllerHome = new ControllerHome();
    $this->controllerItem = new ControllerItem();
  }

  // Traite une requête entrante
  public function routerRequest() {
    try {
      if (isset($_GET['action'])) {
        if ($_GET['action'] == 'readitem') {
          if (isset($_GET['id'])) {
            $item_id = intval($_GET['id']);
            if ($item_id != 0) {
              $this->$controllerItem->item($item_id);
            }
            else
              throw new Exception("Identifiant d'article non valide");
          }
          else
            throw new Exception("Identifiant d'article non défini");
        }
        else
          throw new Exception("Action non valide");
      }
      else {  // aucune action définie : affichage de l'accueil
        $this->controllerHome->home();
      }
    }
    catch (Exception $e) {
      $this->error($e->getMessage());
    }
  }

  // Affiche une erreur
  private function error($msgError) {
    $view = new View("Error");
    $view->generate(array('msgError' => $msgError));
  }
}
