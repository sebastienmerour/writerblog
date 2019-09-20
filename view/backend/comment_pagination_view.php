<!-- Pagination des commentaires  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">

<?php
  if ($current_comments_page !=1  AND $current_comments_page <= $number_of_comments_pages)// Si la page active n'est pas la première page
  {
  ?>
  <li>
      <a class="btn btn-outline-secondary" href="?action=listitems&commentspage=<?php echo $current_comments_page -1 ; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>&nbsp;
  </li>
  <?php
  }
  for ($i = 1; $i <= $number_of_comments_pages; $i++)
  {
    echo '<li';
    if($current_comments_page == $i)
      {
        echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
      }
      else {
        echo '><a class="btn btn-outline-primary" href="?action=listitems&commentspage=' . $i . '">' . $i . '</a>&nbsp;</li>';
      }
  }

  if ($current_comments_page < $number_of_comments_pages)
  {
  ?>
  <li>
      <a class="btn btn-outline-secondary" href="?action=listitems&commentspage=<?php echo $current_comments_page + 1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
  </li>
<?php
  }
?>
</ul>
</nav>
