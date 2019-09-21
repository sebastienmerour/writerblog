<?php $title = 'Jean Forteroche - Panneau d\'Administration'; ?>
<?php ob_start(); ?>

<!-- Pour chaque post on met un While : -->
  <!-- News -->

<?php
  if (!empty(($_SESSION['messages']['itemdeleted'])))
            {?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Merci !</strong> <?php echo $_SESSION['messages']['itemdeleted'];?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

<?php unset ($_SESSION['messages']['itemdeleted']); }?>



  <h2 id="lastitems">Derniers articles</h2>
  <div class="table-responsive">

  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
        <th>Utilisateur</th>
        <th>Titre</th>
        <th>Modification</th>
        <th>Suppression</th>

      </tr>
    </thead>
    <tbody>
      <?php
      while ($datas = $items->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><?php echo $datas['date_creation_fr']; ?></h6></td>
        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?php echo BASE_URL; ?>user/user.php?id_user=<?php echo $datas['id_user']?>">
          <?php echo htmlspecialchars(strip_tags($datas['firstname'])); ?><?php echo '&nbsp;' ?><?php echo htmlspecialchars(strip_tags($datas['name']));?></a></span></td>
        <td><span class="text-body newstitle"><a target="_blank" href="<?php echo BASE_URL; ?>index.php?action=readitem&amp;id=<?= $datas['id'] ?>"><h6 class="mt-2 text-left"><?php echo htmlspecialchars(strip_tags($datas['title'])); ?></h6></a></span></td>
        <td><a href="index.php?id=<?php echo $datas['id'] ;?>&action=readitem" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="index.php?id=<?php echo $datas['id'] ;?>&action=deleteitem" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>

      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>

<!-- Pagination des items  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
    if ($current_page > $number_of_pages) {
      require __DIR__ . '/../errors/page_not_found.php';
    } // on renvoie vers une page d'erreur, pour éviter l'affichage d'un numéro de page faux
        else {

          if ($current_page !=1  AND $current_page <= $number_of_pages)// Si la page active n'est pas la première page
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="?action=listitems&page=<?php echo $current_page -1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }

          for ($i = 1; $i <= $number_of_pages; $i++)
          {
            echo '<li';
            if($current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                echo '><a class="btn btn-outline-primary" href="?action=listitems&page=' . $i . '">' . $i . '</a>&nbsp;</li>';
              }
          }

          if ($current_page < $number_of_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="?action=listitems&page=<?php echo $current_page + 1; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        }
        ?>
      </ul>
    </nav>
<?php $items->closeCursor(); ?>

<h2 id="tomoderate">Commentaires signalés</h2>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
        <th>Utilisateur</th>
        <th>Commentaire</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>01/01/2019</td>
        <td>toto</td>
        <td>bla bla</td>
      </tr>
    </tbody>
  </table>
</div>
<h2 id="allcomments">Tous les commentaires</h2>
<!-- Pagination des commentaires  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">

<?php
if ($counter_comments < 1) {
  require __DIR__ . '/../view/errors/comments_not_found.php';
}


else {

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
}
?>
</ul>
</nav>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
        <th>Utilisateur</th>
        <th>Commentaire</th>
        <th>Modification</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($datas = $comments->fetch())
      {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><?php echo $datas['date_creation_fr']; ?></h6></td>
        <td><div class="media mb-4">
          <img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo $datas['avatar_com']; ?>" alt="user">
          <div class="media-body">
            <h6 class="mt-2 text-left"><?php echo htmlspecialchars($datas['author'], ENT_QUOTES, 'UTF-8'); ?></h6><br>
          </div>
        </div></td>
        <td><h6 class="mt-2 text-left"><?php echo htmlspecialchars($datas['content'], ENT_QUOTES, 'UTF-8'); ?></h6></td>
        <td><a href="index.php?id_comment=<?php echo $datas['id'] ;?>&action=readcomment" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="index.php?id_comment=<?php echo $datas['id'] ;?>&action=deletecomment" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
      </tr>
            <?php
    }
  ?>
    </tbody>
  </table>
</div>
<!-- Pagination des commentaires  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">

<?php
if ($counter_comments < 1) {
  require __DIR__ . '/../view/errors/comments_not_found.php';
}

else {

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
}
?>
</ul>
</nav>

</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/template.php'; ?>
