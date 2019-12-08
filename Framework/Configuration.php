<?php

/**
*  Configuration
*
* @version 1.0
* @author Sébastien Merour
*/

class Configuration {

  private static $parameters;
  // Renvoie la valeur d'un paramètre de configuration
  public static function get($name, $defaultValue = null) {
    if (isset(self::getParameters()[$name])) {
      $value = self::getParameters()[$name];
    }
    else {
      $value = $defaultValue;
    }
    return $value;
  }

  // Renvoie le tableau des paramètres en le chargeant au besoin
  private static function getParameters() {
    if (self::$parameters == null) {
      $pathFile = ROOT_SERVER . 'secret/config.ini';

      if (!file_exists($pathFile)) {
        $pathFile = ROOT_SERVER . 'secret/dev.ini';
      }
      if (!file_exists($pathFile)) {
        throw new Exception("Aucun fichier de configuration trouvé");
      }
      else {
        self::$parameters = parse_ini_file($pathFile);
      }
    }
    return self::$parameters;
  }
}
