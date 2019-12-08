<!-- Pagination des commentaires  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">

<?php
  if ($comments_reported_current_page !=1  AND $comments_reported_current_page <= $number_of_comments_reported_pages)// Si la page active n'est pas la première page
  {
  ?>
  <li>
      <a class="btn btn-outline-secondary" href="../../1/<?= $comments_reported_previous_page; ?>/#tomoderate" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>&nbsp;
  </li>
  <?php
  }
  for ($i = 1; $i <= $number_of_comments_reported_pages; $i++)
  {
    echo '<li';
    if($comments_reported_current_page == $i)
      {
        echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
      }
      else {

        echo '><a class="btn btn-outline-primary" href="../../1/' . $i . '/#tomoderate">' . $i . '</a>&nbsp;</li>';
      }
  }

  if ($comments_reported_current_page < $number_of_comments_reported_pages)
  {
  ?>
  <li>
      <a class="btn btn-outline-secondary" href="../../1/<?= $comments_reported_next_page; ?>/#tomoderate" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
  </li>
<?php
  }
?>
</ul>
</nav>
