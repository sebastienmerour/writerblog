<?php
define("BASE_URL", "/writerblog/");
define("BASE_ADMIN_URL", "/writerblog/writeradmin/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/writerblog/");
define("WEBSITE_NAME", "Jean Forteroche");
define("WEBSITE_SUBTITLE", "écrivain et acteur");
define("COPYRIGHT_YEAR", "2019");

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require 'Framework/Router.php';

$router = new Router();
$router->rootRequest();
