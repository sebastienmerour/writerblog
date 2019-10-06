<?php
require_once 'Framework/Model.php';
/**
 * Fournit les fonctions liées aux articles
 *
 * @author Sébastien Merour
 */
class Item extends Model {
    public $items_count, $request_items, $start;

    /** Renvoie la liste des billets du blog
     *
     * @return PDOStatement La liste des articles
     */

     public function count()
     {
         $sql                     = 'SELECT COUNT(id) AS counter FROM items';
         $this->items_count       = $this->dbConnect($sql);
         $number_of_items_by_page = 5;
         $items                   = $this->items_count->fetch(\PDO::FETCH_ASSOC);
         $number_of_items         = $items['counter'];
         // Calculer le nombre de pages nécessaires :
         $number_of_items_pages   = ceil($number_of_items / $number_of_items_by_page);

         // Vérifier quelle est la page active :
         if (isset($_GET['page'])) {
             $items_current_page = (int) $_GET['page'];
         } else {
             $items_current_page = 1;
         }

         // Définir à partir de quel N° d'item chaque page doit commencer :
         $this->start = (int) (($items_current_page - 1) * $number_of_items_by_page);

     }




    public function getItems()
    {
        $number_of_items_by_page = 5;
        $sql                     = 'SELECT items.id, items.title, items.image, items.content,
    DATE_FORMAT(items.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(items.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.firstname, users.name FROM items
    LEFT JOIN users
    ON items.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $this->start . ', ' . $number_of_items_by_page . '';
        $items                   = $this->dbConnect($sql);
        return $items;
    }

    /** Renvoie les informations sur un billet
     *
     * @param int $id L'identifiant du billet
     * @return array Le billet
     * @throws Exception Si l'identifiant du billet est inconnu
     */

    public function getItem($item_id)
    {
        $sql  = 'SELECT items.id, items.title AS title, items.image AS image, items.content AS content,
        DATE_FORMAT(items.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(items.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.firstname, users.name
        FROM items
        LEFT JOIN users
        ON items.id_user = users.id_user
        WHERE items.id = ? ';
        $item = $this->dbConnect($sql, array(
            $item_id
        ));
        if ($item->rowCount() > 0)
            return $item->fetch(); // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun article ne correspond à l'identifiant '$item_id'");
    }

    // Calculs
    // Obtenir la page courante des articles :
    public function getCurrentPage()
    {
        $sql                     = 'SELECT COUNT(id) AS counter FROM items';
        $this->items_count       = $this->dbConnect($sql);
        $number_of_items_by_page = 5;
        $items                   = $this->items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items         = $items['counter'];
        // Calculer le nombre de pages nécessaires :
        $number_of_items_pages   = ceil($number_of_items / $number_of_items_by_page);

        // Vérifier quelle est la page active :
        if (isset($_GET['page'])) {
            $items_current_page = (int) $_GET['page'];
        } else {
            $items_current_page = 1;
        }
        return $items_current_page;
    }

    // Obtenir le nombre de pages des articles :
    public function getNumberOfPages()
    {
        $sql                     = 'SELECT COUNT(id) AS counter FROM items';
        $this->items_count       = $this->dbConnect($sql);
        $number_of_items_by_page = 5;
        $items                   = $this->items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items         = $items['counter'];
        // Calculer le nombre de pages nécessaires :
        $number_of_items_pages   = ceil($number_of_items / $number_of_items_by_page);
        return $number_of_items_pages;
    }

    //  Obtenir le nombre total d'articles :
    public function getNumberOfItems()
    {
        $sql               = 'SELECT COUNT(id) AS counter FROM items';
        $this->items_count = $this->dbConnect($sql);
        $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items   = $items['counter'];
        return $number_of_items;

    }


}
