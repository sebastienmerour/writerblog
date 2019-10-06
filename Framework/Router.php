<?php

require_once 'Request.php';
require_once 'View.php';

class Router {

  // Route une requête entrante : exécute l'action associée
  public function rootRequest() {
    try {
      // Fusion des paramètres GET et POST de la requête
      $request = new Request(array_merge($_GET, $_POST));
      $controller = $this->createController($request);
      $action = $this->createAction($request);
      $page = $this->createPage($request);
      $controller->executeAction($action, $page);
    }
    catch (Exception $e) {
      $this->manageError($e);
    }
  }

  // Crée le contrôleur approprié en fonction de la requête reçue
  private function createController(Request $request) {
    $controller = "Home";  // Contrôleur par défaut
    if ($request->ifParameter('controller')) {
      $controller = $request->getParameter('controller');
      // Première lettre en majuscule
      $controller = ucfirst(strtolower($controller));
    }
    // Création du nom du fichier du contrôleur
    $classController = "Controller" . $controller;
    $fileController = "Controller/" . $classController . ".php";
    if (file_exists($fileController)) {
      // Instanciation du contrôleur adapté à la requête
      require($fileController);
      $controller = new $classController();
      $controller->setRequest($request);
      return $controller;
    }
    else
      throw new Exception("Fichier '$fileController' introuvable");
  }

  // Détermine l'action à exécuter en fonction de la requête reçue
  private function createAction(Request $request) {
    $action = "index";  // Action par défaut
    if ($request->ifParameter('action')) {
      $action = $request->getParameter('action');
    }
    return $action;
  }

  // Détermine la page à afficher de la requête reçue
  private function createPage(Request $request) {
    $page = 1;  // Page par défaut
    if ($request->ifParameter('page')) {
      $page = $request->getParameter('page');
    }
    return $page;
  }

  // Gère une erreur d'exécution (exception)
  private function manageError(Exception $exception) {
    $view = new View('error');
    $view->generate(array('msgError' => $exception->getMessage()));
  }
}
