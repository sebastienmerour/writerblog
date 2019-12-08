<?php
require_once 'Session.php';

/**
 * Classe modélisant une requête HTTP entrante.
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Request
{

    // paramètres de la requête
    private $parameters;

    /** Objet session associé à la requête */
    private $session;
    /**
     * Constructeur
     *
     * @param array $parameters Paramètres de la requête
     */

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $this->session    = new Session();
    }

    /**
     * Renvoie l'objet session associé à la requête
     *
     * @return Session Objet session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Renvoie vrai si le paramètre existe dans la requête
     *
     * @param string $nom Nom du paramètre
     * @return bool Vrai si le paramètre existe et sa valeur n'est pas vide
     */

    public function ifParameter($name)
    {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Renvoie la valeur du paramètre demandé
     *
     * @param string $nom Nom d paramètre
     * @return string Valeur du paramètre
     * @throws Exception Si le paramètre n'existe pas dans la requête
     */

    public function getParameter($name)
    {
        if ($this->ifParameter($name)) {
            return $this->parameters[$name];
        } else
            throw new Exception("Paramètre '$name' absent de la requête");
    }
}
