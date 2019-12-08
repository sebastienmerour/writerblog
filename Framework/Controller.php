<?php
require_once 'Request.php';
require_once 'View.php';
require_once 'Configuration.php';

/**
 * Classe abstraite contrôleur.
 *
 * @version 1.0
 * @author Sébastien Merour
 */

abstract class Controller
{

    // Action à réaliser
    private $action;

    // Requête entrante
    protected $request;

    // Définit la requête entrante
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    // Exécute l'action à réaliser
    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        } else {
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
        }
    }

    /**
     * Méthode abstraite correspondant à l'action par défaut
     * Oblige les classes dérivées à implémenter cette action par défaut
     */
    public abstract function index();

    /**
     * Génère la vue associée au contrôleur courant
     *
     * @param array $datasView Données nécessaires pour la génération de la vue
     * @param string $action Action associée à la vue (permet à un contrôleur de générer une vue pour une action spécifique)
     */

    protected function generateView($datasView = array())
    {
        // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
        $classController = get_class($this);
        $controller      = str_replace("Controller", "", $classController);
        // Instanciation et génération de la vue
        $view            = new View($this->action, $controller);
        $view->generate($datasView);
    }

    protected function generateadminView($datasView = array())
    {
        // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
        $classController = get_class($this);
        $controller      = str_replace("Controller", "", $classController);
        // Instanciation et génération de la vue
        $view            = new View($this->action, $controller);
        $view->generateadmin($datasView);
    }

    /**
     * Effectue une redirection vers un contrôleur et une action spécifiques
     *
     * @param string $controleur Contrôleur
     * @param type $action Action Action
     */

    protected function redirect($controller, $action = null)
    {
        $rootWeb = Configuration::get("rootWeb", "/");
        // Redirection vers l'URL /racine_site/controleur/action
        header("Location:" . $rootWeb . $controller . "/" . $action);
    }

}
