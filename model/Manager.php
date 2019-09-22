<?php
namespace SM\Blog\Model;
abstract class Manager {

  // Objet PDO d'accès à la DB
  private $db;

  // Exécute une requête SQL éventuellement paramétrée
  protected function dbConnect()($sql, $params = null) {
    if ($params == null) {
      $result = $this->getDb()->query($sql);    // exécution directe
    }
    else {
      $result = $this->getDb()->prepare($sql);  // requête préparée
      $result->execute($params);
    }
    return $result;
  }

  // Renvoie un objet de connexion à la DB en initialisant la connexion au besoin
  private function getDb() {
    if ($this->db == null) {
      $config = parse_ini_file(ROOT_SERVER . 'secret/config.ini');

      $pdoOptions = array(
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
          \PDO::ATTR_EMULATE_PREPARES => false
      );
      // Création de la connexion
      $this->db = new \PDO(
          "mysql:host=" . $config['servername'] . ";dbname=" . $config['dbname'] . ";charset=" . $config['charset'], //DSN
          $config['username'], //Username
          $config['password'], //Password
          $pdoOptions //Options
      );


    }
    return $this->db;
  }

}
