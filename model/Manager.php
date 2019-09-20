<?php
namespace SM\Blog\Model;
class Manager
{
    protected function dbConnect()
    {

      $config = parse_ini_file(ROOT_SERVER . 'secret/config.ini');

      $pdoOptions = array(
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
          \PDO::ATTR_EMULATE_PREPARES => false
      );

      $db = new \PDO(
          "mysql:host=" . $config['servername'] . ";dbname=" . $config['dbname'] . ";charset=" . $config['charset'], //DSN
          $config['username'], //Username
          $config['password'], //Password
          $pdoOptions //Options
      );

      return $db;
    }
}
