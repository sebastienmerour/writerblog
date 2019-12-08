<?php
require_once 'Configuration.php';

/**
 * Classe abstraite contrôleur.
 * Centralise les services d'accès à une base de données.
 * Utilise l'API PDO de PHP
 *
 * @version 1.0
 * @author Sébastien Merour
 */

abstract class Model
{

    /** Objet PDO d'accès à la BD Statique donc partagé par toutes les instances des classes dérivées */
    private static $db;

    /**
     * Exécute une requête SQL
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return PDOStatement Résultats de la requête
     */

    protected function dbConnect($sql, $params = null)
    {
        if ($params == null) {
            $result = self::getDb()->query($sql); // exécution directe
        } else {
            $result = self::getDb()->prepare($sql); // requête préparée
            $result->execute($params);
        }
        return $result;
    }

    /**
     * Renvoie un objet de connexion à la BDD en initialisant la connexion au besoin
     *
     * @return PDO Objet PDO de connexion à la BDD
     */
    private static function getDb()
    {
        if (self::$db === null) {
            // Récupération des paramètres de configuration BD
            $dsn      = Configuration::get("dsn");
            $username = Configuration::get("username");
            $password = Configuration::get("password");


            // Création de la connexion
            self::$db = new PDO($dsn, $username, $password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ));
        }
        return self::$db;
    }

}
