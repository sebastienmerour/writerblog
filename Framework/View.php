<?php
require_once 'Configuration.php';

/**
 * Classe modélisant une vue
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class View
{
    /** Nom du fichier associé à la vue */
    private $file;
    /** Titre de la vue (défini dans le fichier vue) */
    private $title;
    private $sidebar;
    /**
     * Constructeur
     *
     * @param string $action Action à laquelle la vue est associée
     * @param string $controleur Nom du contrôleur auquel la vue est associée
     */
    public function __construct($action, $controller = "")
    {
        // Détermination du nom du fichier vue à partir de l'action et du constructeur
        // La convention de nommage des fichiers vues est : Vue/<$controleur>/<$action>.php
        $file = "View/";
        if ($controller != "") {
            $file = $file . $controller . "/";
        }
        $this->file = $file . $action . ".php";
    }

    /**
     * Génère et affiche la vue
     *
     * @param array $datas Données nécessaires à la génération de la vue
     */

    public function generate($datas)
    {
        // Génération de la partie spécifique de la vue
        $content = $this->generateFile($this->file, $datas);
        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web
        // Nécessaire pour les URI de type controller/action/id
        $rootWeb = Configuration::get("rootWeb", "/");
        // Génération du template commun utilisant la partie spécifique
        $view    = $this->generateFile('View/themes/front/template.php', array(
            'title' => $this->title,
            'content' => $content,
            'sidebar' => $this->sidebar,
            'rootWeb' => $rootWeb
        ));
        // Renvoi de la vue générée au navigateur
        echo $view;
    }
    public function generateadmin($datas)
    {
        // Génération de la partie spécifique de la vue
        $content = $this->generateFile($this->file, $datas);
        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web
        // Nécessaire pour les URI de type controller/action/id
        $rootWeb = Configuration::get("rootWeb", "/");
        // Génération du template commun utilisant la partie spécifique
        $view    = $this->generateFile('View/themes/back/template.php', array(
            'title' => $this->title,
            'content' => $content,
            'sidebar' => $this->sidebar,
            'rootWeb' => $rootWeb
        ));
        // Renvoi de la vue générée au navigateur
        echo $view;
    }

    /**
     * Génère un fichier vue et renvoie le résultat produit
     *
     * @param string $file Chemin du fichier vue à générer
     * @param array $datas Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */

    private function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            // Rend les éléments du tableau $donnees accessibles dans la vue
            extract($datas);
            // Démarrage de la temporisation de sortie
            ob_start();
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            require $file;
            // Arrêt de la temporisation et renvoi du tampon de sortie
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }
    /**
     * Nettoie une valeur insérée dans une page HTML
     * Permet d'éviter les problèmes d'exécution de code indésirable (XSS) dans les vues générées
     *
     * @param string $value Valeur à nettoyer
     * @return string Value nettoyée
     */
    private function clean($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

    private function cleantinymce($value)
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }

}
