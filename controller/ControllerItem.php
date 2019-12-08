<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';

/**
 * Contrôleur des actions liées aux articles
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerItem extends Controller
{
    private $item;
    private $comment;
    private $user;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->item    = new Item();
        $this->comment = new Comment();
        $this->user    = new User();
    }

    // ITEMS //
    // Read

    // Affichage d'un seul item avec ses commentaires - pour user inconnu :
    public function index()
    {
        $item_id                  = $this->request->getParameter("id");
        $item                     = $this->item->getItem($item_id);
        $number_of_items          = $this->item->count();
        $number_of_items_pages    = $this->item->getNumberOfPages();
        $number_of_comments       = $this->comment->countComments($item_id);
        $comments_current_page    = $this->comment->getCommentsCurrentPage();
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($item_id, $comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
        $this->generateView(array(
            'item' => $item,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages,
            'comments' => $comments,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }

    // Affichage d'un seul item avec ses commentaires - pour user connecté :
    public function indexuser()
    {
        $item_id                  = $this->request->getParameter("id");
        $item                     = $this->item->getItem($item_id);
        $user                     = $this->user->getUser($_SESSION['id_user']);
        $number_of_items          = $this->item->count();
        $number_of_items_pages    = $this->item->getNumberOfPages();
        $number_of_comments       = $this->comment->countComments($item_id);
        $comments_current_page    = $this->comment->getCommentsCurrentPageUser();
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($item_id, $comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
        $this->generateView(array(
            'item' => $item,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages,
            'user' => $user,
            'comments' => $comments,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }


    // COMMENTS //
    // Create

    // Ajout d'un nouveau commentaire - pour user inconnu :
    public function createcomment()
    {
        $item_id = $this->request->getParameter("id");
        if (!empty($_POST['content']) && !empty($_POST['author'])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secretKey      = '6LerX8QUAAAAAOxzR50kzN9yY9nCObsi2vz1FmcR';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $author         = $this->request->getParameter("author");
                $content        = $this->request->getParameter("content");

                if ($responseData->success) {
                    $this->comment->insertComment($item_id, $author, $content);
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ../item/' . $item_id . '/1/#addcomment');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: ../item/' . $item_id . '/1/#addcomment');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: ../item/' . $item_id . '/1/#addcomment');
            exit;
        }
    }

    // Ajout d'un nouveau commentaire - pour user connecté :
    public function createcommentloggedin()
    {
        $item_id = $this->request->getParameter("id");

        if (!empty($_POST['content'])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

                $secretKey      = '6LerX8QUAAAAAOxzR50kzN9yY9nCObsi2vz1FmcR';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $user_id        = $_SESSION['id_user'];
                $author         = $this->request->getParameter("author");
                $content        = $this->request->getParameter("content");

                if ($responseData->success) {
                    $this->comment->insertCommentLoggedIn($item_id, $user_id, $author, $content);
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ../item/indexuser/' . $item_id . '/1/#addcomment');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: ../item/indexuser/' . $item_id . '/1/#addcomment');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: ../item/indexuser/' . $item_id . '/1/#addcomment');
            exit;
        }
    }

    // Read

    // Affichage d'un commentaire :
    public function readcomment()
    {
        $item_id                  = $this->item->getItemId();
        $item                     = $this->item->getItem($item_id);
        $number_of_items          = $this->item->count();
        $number_of_items_pages    = $this->item->getNumberOfPages();
        $number_of_comments       = $this->comment->countComments($item_id);
        $comments_current_page    = 1;
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($item_id, $comments_current_page);
        $id_comment               = $this->comment->getCommentId();
        $comment                  = $this->comment->getComment($id_comment);
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
        $default                  = "default.png";
        $this->generateView(array(
            'comment' => $comment,
            'item' => $item,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages,
            'comments_current_page' => $comments_current_page,
            'comments' => $comments,
            'default' => $default,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }


    // Update
    
    // Modification d'un commentaire :
    public function updatecomment()
    {
        $id_comment = $this->comment->getCommentId();
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeComment($content);
    }

    // Signaler un commentaire :
    public function reportcomment()
    {
        $item_id                  = $this->item->getItemId();
        $item                     = $this->item->getItem($item_id);
        $number_of_items          = $this->item->count();
        $number_of_items_pages    = $this->item->getNumberOfPages();
        $number_of_comments       = $this->comment->countComments($item_id);
        $comments_current_page    = 1;
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($item_id, $comments_current_page);
        $id_comment               = $this->comment->getCommentId();
        $comment                  = $this->comment->getComment($id_comment);
        $number_of_comments_pages = $this->comment->getNumberOfCommentsPagesFromItem($item_id);
        $this->comment->reportBadComment($id_comment);
        $default = "default.png";
        $this->generateView(array(
            'comment' => $comment,
            'item' => $item,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages,
            'comments_current_page' => $comments_current_page,
            'comments' => $comments,
            'default' => $default,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }

}
