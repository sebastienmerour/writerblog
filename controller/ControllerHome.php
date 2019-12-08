<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';

/**
 * Contrôleur gérant la page d'accueil
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerHome extends Controller
{
    private $item;
    public function __construct()
    {
        $this->item = new Item();
    }

    // Lister les articles en page d'accueil :
    public function index()
    {
        $items                 = $this->item->getItems();
        $number_of_items       = $this->item->count();
        $items_current_page    = 1;
        $previous_page         = $items_current_page - 1;
        $next_page             = $items_current_page + 1;
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'items_current_page' => $items_current_page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Lister les articles pour les pages suivantes :
    public function page()
    {
        $number_of_items       = $this->item->count();
        $items_current_page    = $this->request->getParameter("id");
        $previous_page         = $items_current_page - 1;
        $next_page             = $items_current_page + 1;
        $items                 = $this->item->getPaginationItems($items_current_page);
        $number_of_items_pages = $this->item->getNumberOfPages();
        $this->generateView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'items_current_page' => $items_current_page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'items_current_page' => $items_current_page,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

}
