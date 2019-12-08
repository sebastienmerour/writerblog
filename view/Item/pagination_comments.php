<!-- Pagination des commentaires  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
          if ($comments_current_page !=1  AND $comments_current_page <= $number_of_comments_pages)// Si la page active n'est pas la première page
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/" . $page_previous_comments : "item/indexuser/" . $this->clean($item['id']).
              "/" . $page_previous_comments ?>/#comments" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }
          for ($i = 1; $i <= $number_of_comments_pages; $i++)
          {
            echo '<li';
            if($comments_current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                  if (!ISSET($_SESSION['id_user'])) {

                  echo '><a class="btn btn-outline-primary" href="item/' .$this->clean($item['id']). '/'. $i . '/#comments">' . $i . '</a>&nbsp;</li>';
                  }
                  else {
                  echo '><a class="btn btn-outline-primary" href="item/indexuser/' .$this->clean($item['id']). '/'. $i . '/#comments">' . $i . '</a>&nbsp;</li>';
              }
          }
        }
          if ($comments_current_page < $number_of_comments_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/" . $page_next_comments  : "item/indexuser/" . $this->clean($item['id']).
              "/" . $page_next_comments ?>/#comments" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        ?>
      </ul>
    </nav>
