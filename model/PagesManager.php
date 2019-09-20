<?php
namespace SM\Blog\Model;
require_once __DIR__ . '/../model/Manager.php';

class PagesManager extends Manager
{

  public function itemsPages()
  {
    $db                      = $this->dbConnect();
    $number_of_items_by_page = 5;
    $items_count             = $db->prepare('SELECT COUNT(id) AS counter FROM items');
    $items_count->execute();
    $items   = $items_count->fetch(\PDO::FETCH_ASSOC);
    // Nombre total d'articles :
    $number_of_items = $items['counter'];

    // Calculer le nombre de pages nécessaires :
    $number_of_items_pages = ceil($number_of_items / $number_of_items_by_page);

    // Vérifier quelle est la page active :
    if (isset($_GET['page'])) {
        $items_current_page = (int) $_GET['page'];
    } else {
        $items_current_page = 1;
    }
    return $number_of_items;
    return $number_of_items_pages;
    return $items_current_page;

}



}
