<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux articles
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Item extends Model
{
    public $number_of_items, $items_current_page, $number_of_items_pages, $number_of_items_by_page = 5;

    // CREATE

    // Création d'un nouvel article sans photo :
    public function insertItem($user_id, $title, $content)
    {
        $errors   = array();
        $messages = array();
        $user_id  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO items (id_user, title, content, date_creation)
                      VALUES
                      (:id_user, :title, :content, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $user_id,
            ':title' => $title,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Votre article a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../writeradmin/dashboard');
            exit;
        }
    }

    // Création d'un nouvel article avec photo :
    public function insertItemImage($user_id, $title, $itemimagename, $content)
    {
        $errors   = array();
        $messages = array();
        $user_id  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO items (id_user, title, image, content, date_creation)
                      VALUES
                      (:id_user, :title, :image, :content, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $user_id,
            ':title' => $title,
            ':image' => $itemimagename,
            ':content' => $content
        ));

        $messages['confirmation'] = 'Votre article a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../writeradmin/dashboard');
            exit;
        }
    }


    // READ

    // Afficher la liste des Articles :
    public function getItems()
    {
        $sql   = 'SELECT items.id, items.title, items.image, items.content,
     DATE_FORMAT(items.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(items.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.firstname, users.name FROM items
     LEFT JOIN users
     ON items.id_user = users.id_user
     ORDER BY date_creation DESC LIMIT ' . 0 . ', ' . $this->number_of_items_by_page . '';
        $items = $this->dbConnect($sql);
        return $items;
    }

    // Pagniation des Articles :
    public function getPaginationItems($items_current_page)
    {
        $start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql   = 'SELECT items.id, items.title, items.image, items.content,
    DATE_FORMAT(items.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(items.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.firstname, users.name FROM items
    LEFT JOIN users
    ON items.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $start . ', ' . $this->number_of_items_by_page . '';
        $items = $this->dbConnect($sql);
        return $items;
    }

    // Afficher un Article en particulier :
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
        $req  = $this->dbConnect($sql, array(
            $item_id
        ));
        $item = $req->fetch();
        return $item;
    }


    // UPDATE

    // Modification d'un article avec photo :
    public function changeItemImage($title, $itemimagename, $content, $item_id)
    {
        $title   = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $content = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql     = 'UPDATE items SET title = :title, image = :image, content = :content,
    date_update = NOW() WHERE id = :id';
        $item    = $this->dbConnect($sql, array(
            ':id' => $item_id,
            ':title' => $title,
            ':image' => $itemimagename,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Votre article a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readitem/' . $item_id);
            exit;
        }
    }

    // Modification d'un article sans photo :
    public function changeItem($title, $content, $item_id)
    {
        $title   = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $content = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql     = 'UPDATE items SET title = :title, content = :content, date_update = NOW() WHERE id = :id';
        $item    = $this->dbConnect($sql, array(
            ':id' => $item_id,
            ':title' => $title,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Merci ! Votre article a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readitem/' . $item_id);
            exit;
        }
    }

    // DELETE
    // Suppression d'un article :
    public function eraseItem($item_id)
    {
        $sql = 'DELETE FROM items WHERE id = ' . (int) $item_id;
        $req = $this->dbConnect($sql);
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Votre article a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../');
            exit;
        }
    }

    // CALCULS

    // Pagination des Articles :
    public function count()
    {
        $sql               = 'SELECT COUNT(id) AS counter FROM items';
        $this->items_count = $this->dbConnect($sql);
        $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items   = $items['counter'];
        return $number_of_items;
    }

    // Obtenir la page courante des articles :
    public function getCurrentPage()
    {
        if (isset($_GET['id'])) {
            $items_current_page = (int) $_GET['id'];
        } else {
            $items_current_page = 1;
        }
        return $items_current_page;
    }

    // Obtenir le nombre de pages des articles :
    public function getNumberOfPages()
    {
        $number_of_items       = $this->count();
        // Calculer le nombre de pages nécessaires :
        $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
        return $number_of_items_pages;
    }

    // Obtenir l'ID d'un item sur la page de modification de commentaires :
    public function getItemId()
    {
        $q       = explode("/", $_SERVER['REQUEST_URI']);
        $value   = $q[4];
        $item_id = (int) $value;
        return $item_id;
    }

}
