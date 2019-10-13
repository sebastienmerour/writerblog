<?php
define("BASE_URL", "/writerblog/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/writerblog/");

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require '../Framework/Router.php';

$router = new Router();
$router->rootRequest();
