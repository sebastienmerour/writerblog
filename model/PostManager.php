<?php
namespace SM\Blog\Model;
require_once __DIR__ . '/../model/Manager.php';
class PostManager extends Manager
{
    // Create
    // Création d'un nouvel article :
    public function insertItem($idUser, $title, $itemimagename, $content)
    {
        $errors    = array();
        $messages  = array();
        $db        = $this->dbConnect();
        $idUser = $_SESSION['id_user_admin'];
        $items  = $db->prepare('INSERT INTO items (id_user, title, image, content, date_creation)
                      VALUES
                      (:id_user, :title, :image, :content, NOW())');
        $items->bindValue(':id_user', $idUser);
        $items->bindValue(':title', $title);
        $items->bindValue(':image', $itemimagename);
        $items->bindValue(':content', $content);
        $items->execute();
        $messages['itemcreated'] = 'Votre article a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ?action=listitems');
            exit;
        }
    }

    // Read
    // Afficher la liste des Articles :
    public function getItems()
    {

        $db                      = $this->dbConnect();
        $number_of_items_by_page = 5;
        $items_count             = $db->prepare('SELECT COUNT(id) AS counter FROM items');
        $items_count->execute();
        $items   = $items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items = $items['counter'];

        // Calculer le nombre de pages nécessaires :
        $number_of_items_pages = ceil($number_of_items / $number_of_items_by_page);

        // Vérifier quelle est la page active :
        if (isset($_GET['page'])) {
            $items_current_page = (int) $_GET['page'];
        } else {
            $items_current_page = 1;
        }

        // Définir à partir de quel N° d'item chaque page doit commencer :
        $start = (int) (($items_current_page - 1) * $number_of_items_by_page);

        $request_items = $db->query('SELECT items.id, items.title, items.image, items.content,
        DATE_FORMAT(items.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(items.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.firstname, users.name FROM items
        LEFT JOIN users
        ON items.id_user = users.id_user
        ORDER BY date_creation DESC LIMIT ' . $start . ', ' . $number_of_items_by_page . '');
        return $request_items;
    }

    // Affichage d'un seul article :
    public function getItem($item_id)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare('SELECT items.id, items.title AS title, items.image AS image, items.content AS content,
        DATE_FORMAT(items.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(items.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.firstname, users.name
        FROM items
        LEFT JOIN users
        ON items.id_user = users.id_user
        WHERE items.id = ? ');
        $req->execute(array(
            $item_id
        ));
        $item = $req->fetch();
        return $item;
    }

    // Modification de la photo d'un article :
    public function changeItemImage($title, $itemimagename, $content, $item_id)
    {
        $db      = $this->dbConnect();
        $req     = $db->prepare('UPDATE items SET title = ?, image = ?, content = ?,
        date_update = NOW() WHERE id = ?');
        $newItem = $req->execute(array(
            $title,
            $itemimagename,
            $content,
            $item_id
        ));
        if ($newItem === false) {
            // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
            throw new Exception('Impossible d\'ajouter l\'article !');
        }
        // Ici on affiche le message de confirmation :
        $messages['itemupdated'] = 'Votre article a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ?action=readitem&id=' . $item_id);
            exit;
        }

    }

    // Modification d'un article :
    public function changeItem($title, $content, $item_id)
    {
        $db      = $this->dbConnect();
        $req     = $db->prepare('UPDATE items SET title = ?, content = ?, date_update = NOW() WHERE id = ?');
        $newItem = $req->execute(array(
            $title,
            $content,
            $item_id
        ));
        if ($newItem === false) {
            // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
            throw new Exception('Impossible d\'ajouter l\'article !');
        }
        // Ici on affiche le message de confirmation :
        $itemmessages['itemupdated'] = 'Merci ! Votre article a bien été modifié !';
        if (!empty($itemmessages)) {
            $_SESSION['messages'] = $itemmessages;
            header('Location: ?action=readitem&id=' . $item_id);
            exit;
        }

    }

    // Delete
    // Suppression d'un article :
    public function eraseItem($item_id)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare('DELETE FROM items WHERE id = ' . (int) $item_id);
        $req->execute();
    }

    // Calculs
    // Obtenir la page courante des articles :
    public function getCurrentPage()
    {
        $db                      = $this->dbConnect();
        $number_of_items_by_page = 5;
        $items_count             = $db->prepare('SELECT COUNT(id) AS counter FROM items');
        $items_count->execute();
        $items   = $items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items = $items['counter'];

        // Calculer le nombre de pages nécessaires :
        $number_of_items_pages = ceil($number_of_items / $number_of_items_by_page);

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
        $db                      = $this->dbConnect();
        $number_of_items_by_page = 5;
        $items_count             = $db->prepare('SELECT COUNT(id) AS counter FROM items');
        $items_count->execute();
        $items   = $items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items = $items['counter'];

        // Calculer le nombre de pages nécessaires :
        $number_of_items_pages = ceil($number_of_items / $number_of_items_by_page);
        return $number_of_items_pages;
    }

    //  Obtenir le nombre total d'articles :
    public function getNumberOfItems()
    {
        $db          = $this->dbConnect();
        $items_count = $db->prepare('SELECT COUNT(id) AS counter FROM items');
        $items_count->execute();
        $items   = $items_count->fetch(\PDO::FETCH_ASSOC);
        $number_of_items = $items['counter'];
        return $number_of_items;
    }


}
