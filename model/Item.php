<?php
require_once 'Framework/Model.php';
/**
 * Fournit les fonctions liées aux articles
 *
 * @author Sébastien Merour
 */
class Item extends Model {
    public $items_count, $request_items, $start;

    // Create
    // Création d'un nouvel article :
    public function insertItem($idUser, $title, $itemimagename, $content)
    {
        $errors   = array();
        $messages = array();
        $idUser   = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO items (id_user, title, image, content, date_creation)
                      VALUES
                      (:id_user, :title, :image, :content, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $idUser,
            ':title' => $title,
            ':image' => $itemimagename,
            ':content' => $content
        ));

        $messages['itemcreated'] = 'Votre article a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ?action=listitems');
            exit;
        }
    }



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

    // Modification d'un article avec photo :
    public function changeItemImage($title, $itemimagename, $content)
    {
        $item_id = $_GET['id'];
        $title           = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $content           = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql     = 'UPDATE items SET title = :title, image = :image, content = :content,
    date_update = NOW() WHERE id = :id';
        $item = $this->dbConnect($sql, array(
          ':id' => $item_id,
          ':title' => $title,
          ':image' => $itemimagename,
          ':content' => $content
        ));

        // Ici on affiche le message de confirmation :
        $messages['itemupdated'] = 'Votre article a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readitem/' . $item_id);
            exit;
        }

    }

    // Modification d'un article :
    public function changeItem($title, $content)
    {
        $item_id = $_GET['id'];
        $title           = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $content           = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql     = 'UPDATE items SET title = :title, content = :content, date_update = NOW() WHERE id = :id';
        $item = $this->dbConnect($sql, array(
          ':id' => $item_id,
          ':title' => $title,
          ':content' => $content

        ));



        // Ici on affiche le message de confirmation :
        $itemmessages['itemupdated'] = 'Merci ! Votre article a bien été modifié !';
        if (!empty($itemmessages)) {
            $_SESSION['messages'] = $itemmessages;
            header('Location: ../readitem/' . $item_id);
            exit;
        }

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
