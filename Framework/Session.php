<?php

/**
 * Classe modélisant la session.
 * Encapsule la superglobale PHP $_SESSION.
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Session
{
    /**
     * Constructeur.
     * Démarre ou restaure la session
     */
    public function __construct()
    {
        session_start();
    }
    /**
     * Détruit la session actuelle
     */
    public function destroy()
    {
        session_destroy();
    }
    /**
     * Ajoute un attribut à la session
     *
     * @param string $nom Nom de l'attribut
     * @param string $valeur Valeur de l'attribut
     */
    public function setAttribut($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    /**
     * Renvoie vrai si l'attribut existe dans la session
     *
     * @param string $nom Nom de l'attribut
     * @return bool Vrai si l'attribut existe et sa valeur n'est pas vide
     */
    public function ifAttribut($name)
    {
        return (isset($_SESSION[$name]) && $_SESSION[$name] != "");
    }
    /**
     * Renvoie la valeur de l'attribut demandé
     *
     * @param string $nom Nom de l'attribut
     * @return string Valeur de l'attribut
     * @throws Exception Si l'attribut n'existe pas dans la session
     */
    public function getAttribut($name)
    {
        if ($this->ifAttribut($name)) {
            return $_SESSION[$name];
        } else {
            throw new Exception("Attribut '$name' absent de la session");
        }
    }
}
