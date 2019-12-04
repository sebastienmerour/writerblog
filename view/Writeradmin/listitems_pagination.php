<!-- Pagination des items  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
    if ($items_current_page > $number_of_items_pages) {
      require __DIR__ . '/../errors/page_not_found.php';
    } // on renvoie vers une page d'erreur, pour éviter l'affichage d'un numéro de page faux
        else {
          if ($items_current_page !=1  AND $items_current_page <= $number_of_items_pages)// Si la page active n'est pas la première page
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="../../listitems/<?= $page_previous_items; ?>/1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }

          for ($i = 1; $i <= $number_of_items_pages; $i++)
          {
            echo '<li';
            if($items_current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                echo '><a class="btn btn-outline-primary" href="../../listitems/' . $i . '/1">' . $i . '</a>&nbsp;</li>';
              }
          }

          if ($items_current_page < $number_of_items_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="../../listitems/<?= $page_next_items; ?>/1" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        }
        ?>
      </ul>
    </nav>
