<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';

/**
 * Contrôleur gérant la page d'accueil de l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerWriteradmin extends Controller
{
    private $user;
    private $item;
    private $comment;

    public function __construct()
    {
        $this->user    = new User();
        $this->item    = new Item();
        $this->comment = new Comment();
    }

    // CREATE
    // ITEMS

    // Affichage du formulaire ce création d'article
    public function additem()
    {
        $items = $this->item->count();
        $this->generateadminView(array(
            'items' => $items
        ));
    }

    // Processus de création d'un article :
    public function createitem()
    {
        if (isset($_POST["modify"])) {
            $errors                = array();
            $messages              = array();
            $user_id               = $_SESSION['id_user_admin'];
            $title                 = $_POST['title'];
            $content               = $_POST['content'];
            $fileinfo              = @getimagesize($_FILES["image"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s") . "-";
            $newtitle              = str_replace(' ', '-', strtolower($title));
            $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
            $itemimagename         = "{$time}$newtitle.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/item_images';

            if (empty($title) || empty($content)) {
                $errors['errors'] = 'Veuillez remplir tous les champs';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: additem/');
                    exit;
                }
            }

            else if (!file_exists($_FILES["image"]["tmp_name"])) {
                $this->item->insertItem($user_id, $title, $content);
            }

            else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: additem/');
                    exit;
                }
            } else if (($_FILES["image"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: additem/');
                    exit;
                }
            } else if ($width < "300" || $height < "200") {
                $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: additem/');
                    exit;
                }
            }

            else {
                move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                $this->item->insertItemImage($user_id, $title, $itemimagename, $content);
            }
        }
    }

    // READ
    // ITEMS

    // Affichage de la page de connexion :
    public function index()
    {
        $this->generateadminView();
    }

    // Affichage de la page d'accueil après connexion :
    public function dashboard()
    {
        $items                 = $this->item->count();
        $items                 = $this->item->getItems();
        $number_of_items       = $this->item->count();
        $items_current_page    = 1;
        $page_previous_items   = $items_current_page - 1;
        $page_next_items       = $items_current_page + 1;
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateadminView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'items_current_page' => $items_current_page,
            'page_previous_items' => $page_previous_items,
            'page_next_items' => $page_next_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Pagination des articles :
    public function listitems()
    {
        $items                 = $this->item->count();
        $items                 = $this->item->getItems();
        $number_of_items       = $this->item->count();
        $items_current_page    = $this->request->getParameter("id");
        $items                 = $this->item->getPaginationItems($items_current_page);
        $number_of_items_pages = $this->item->getNumberOfPages();
        $page_previous_items   = $items_current_page - 1;
        $page_next_items       = $items_current_page + 1;
        $this->generateadminView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'items_current_page' => $items_current_page,
            'page_previous_items' => $page_previous_items,
            'page_next_items' => $page_next_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Affichage d'un article seul :
    public function readitem()
    {

        $item_id = $this->request->getParameter("id");
        $item    = $this->item->getItem($item_id);
        $this->generateadminView(array(
            'item' => $item
        ));
    }

    // UPDATE
    // ITEMS

    // Modification d'un article :
    public function updateitem()
    {
        if (isset($_POST["modify"])) {
            $errors                = array();
            $messages              = array();
            $item_id               = $this->request->getParameter("id");
            $title                 = $this->request->getParameter("title");
            $content               = $this->request->getParameter("content");
            $fileinfo              = @getimagesize($_FILES["image"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s") . "-";
            $newtitle              = str_replace(' ', '-', strtolower($title));
            $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
            $itemimagename         = "{$time}$newtitle.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/item_images';

            if (!file_exists($_FILES["image"]["tmp_name"])) {
                $messages = array();
                $item_id  = $this->request->getParameter("id");
                $title    = $this->request->getParameter("title");
                $content  = $this->request->getParameter("content");
                $this->item->changeItem($title, $content, $item_id);
            } else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../readitem/' . $item_id);
                    exit;
                }
            } else if (($_FILES["image"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../readitem/' . $item_id);
                    exit;
                }
            } else if ($width < "300" || $height < "200") {
                $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../readitem/' . $item_id);
                    exit;
                }
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                $this->item->changeItemImage($title, $itemimagename, $content, $item_id);
            }
        }
    }

    // DELETE
    // ITEMS

    // Suppression d'un article :
    public function removeitem()
    {
        $item_id = $this->request->getParameter("id");
        $this->item->eraseItem($item_id);
        if ($item_id === false) {
            throw new Exception('Impossible de supprimer l\' article !');
        } else {
            $messages['confirmation'] = 'L\'article a bien été supprimé !';
            $this->generateadminView();
        }
    }


    // READ
    // COMMENTS

    // Affichage des commentaires à modérer :
    public function tomoderate()
    {
        $comments_reported_current_page    = 1;
        $comments_reported_previous_page   = $comments_reported_current_page - 1;
        $comments_reported_next_page       = $comments_reported_current_page - 1;
        $comments_reported                 = $this->comment->selectCommentsReported($comments_reported_current_page);
        $default                           = "default.png";
        $number_of_comments_reported_pages = $this->comment->getNumberOfCommentsReportedPagesFromAdmin();
        $counter_comments_reported         = $this->comment->getTotalOfCommentsReported();
        $this->generateadminView(array(
            'comments_reported' => $comments_reported,
            'default' => $default,
            'comments_reported_current_page' => $comments_reported_current_page,
            'comments_reported_previous_page' => $comments_reported_previous_page,
            'comments_reported_next_page' => $comments_reported_next_page,
            'number_of_comments_reported_pages' => $number_of_comments_reported_pages,
            'counter_comments_reported' => $counter_comments_reported
        ));
    }

    // Pagination des commentaires à modérer :
    public function listtomoderate()
    {
        $comments_reported_current_page    = $this->comment->getCommentsReportedCurrentPage();
        $comments_reported_previous_page   = $comments_reported_current_page - 1;
        $comments_reported_next_page       = $comments_reported_current_page - 1;
        $comments_reported                 = $this->comment->selectCommentsReported($comments_reported_current_page);
        $default                           = "default.png";
        $number_of_comments_reported_pages = $this->comment->getNumberOfCommentsReportedPagesFromAdmin();
        $counter_comments_reported         = $this->comment->getTotalOfCommentsReported();
        $this->generateadminView(array(
            'comments_reported' => $comments_reported,
            'default' => $default,
            'comments_reported_current_page' => $comments_reported_current_page,
            'comments_reported_previous_page' => $comments_reported_previous_page,
            'comments_reported_next_page' => $comments_reported_next_page,
            'number_of_comments_reported_pages' => $number_of_comments_reported_pages,
            'counter_comments_reported' => $counter_comments_reported
        ));
    }

    // Affichage de l'ensemble des commentaires :
    public function allcomments()
    {
        $comments_current_page    = 1;
        $comments_previous_page   = $comments_current_page - 1;
        $comments_next_page       = $comments_current_page + 1;
        $comments                 = $this->comment->selectComments($comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromAdmin();
        $counter_comments         = $this->comment->getTotalOfComments();
        $this->generateadminView(array(
            'comments' => $comments,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'comments_previous_page' => $comments_previous_page,
            'comments_next_page' => $comments_next_page,
            'number_of_comments_pages' => $number_of_comments_pages,
            'counter_comments' => $counter_comments
        ));
    }

    // Pagination de tous les commentaires :
    public function listallcomments()
    {
        $comments_current_page    = $this->comment->getCommentsCurrentPageUser();
        $comments_previous_page   = $comments_current_page - 1;
        $comments_next_page       = $comments_current_page + 1;
        $comments                 = $this->comment->selectComments($comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromAdmin();
        $counter_comments         = $this->comment->getTotalOfComments();
        $this->generateadminView(array(
            'comments' => $comments,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'comments_previous_page' => $comments_previous_page,
            'comments_next_page' => $comments_next_page,
            'number_of_comments_pages' => $number_of_comments_pages,
            'counter_comments' => $counter_comments
        ));
    }

    // Affichage d'un commentaire
    public function readcomment()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $default    = "default.png";
        $this->generateadminView(array(
            'comment' => $comment,
            'default' => $default
        ));
    }

    // UPDATE
    // COMMENTS

    // Modification d'un commentaire :
    public function updatecomment()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeCommentAdmin($content);
    }

    // DELETE
    // COMMENTS

    // Suppression d'un commentaire :
    public function removecomment()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseComment($id_comment);
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../allcomments');
            exit;
        }
    }
    public function removecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseComment($id_comment);
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../tomoderate');
            exit;
        }
    }
}
