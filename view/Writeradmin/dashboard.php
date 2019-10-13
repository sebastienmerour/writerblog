<?php $this->title = 'Jean Forteroche - Panneau d\'Administration'; ?>



  <!-- News -->
  <?php
  if (!empty($_SESSION['messages']['itemcreated']))
            {?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['messages']['itemcreated'];
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php
            }
?>
<?php unset($_SESSION['messages']); ?>
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
      while ($item = $items->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><?php echo $item['date_creation_fr']; ?></h6></td>
        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?php echo BASE_URL; ?>user/user.php?id_user=<?php echo $item['id_user']?>">
          <?php echo htmlspecialchars(strip_tags($item['firstname'])); ?><?php echo '&nbsp;' ?><?php echo htmlspecialchars(strip_tags($item['name']));?></a></span></td>
        <td><span class="text-body newstitle"><a target="_blank" href="<?php echo BASE_URL; ?>index.php?action=readitem&amp;id=<?= $item['id'] ?>"><h6 class="mt-2 text-left"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></h6></a></span></td>
        <td><a href="index.php?id=<?php echo $item['id'] ;?>&action=readitem" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="index.php?id=<?php echo $item['id'] ;?>&action=deleteitem" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>

      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>

  <?php
  if ($items_current_page > $number_of_items_pages) {
  	require __DIR__ . '/../errors/items_not_found.php';
  }
  else {
  require('pagination_items.php');}
  ?>

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
<?php
if ($counter_comments < 1) {
  require __DIR__ . '/../view/errors/comments_not_found.php';
}

else {
require('pagination_comments.php');}
?>
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
      while ($comment = $comments->fetch())
      {
      ?>

      <tr>
        <td><h6 class="mt-2 text-left"><?php echo $comment['date_creation_fr']; ?></h6></td>
        <td><div class="media mb-4">
          <img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
          <div class="media-body">
            <h6 class="mt-2 text-left"><?php echo htmlspecialchars(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com']. ' ' . $comment['name_com'] : $comment['author'], ENT_QUOTES, 'UTF-8');?></h6><br>
          </div>

        </div></td>
        <td><h6 class="mt-2 text-left"><?php echo htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8'); ?></h6></td>
        <td><a href="index.php?id_comment=<?php echo $comment['id'] ;?>&action=readcomment" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="index.php?id_comment=<?php echo $comment['id'] ;?>&action=deletecomment" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
      </tr>
            <?php
    }
  ?>
    </tbody>
  </table>
</div>
<?php
if ($counter_comments < 1) {
  require __DIR__ . '/../view/errors/comments_not_found.php';
}
else {
require('pagination_comments.php');}
?>
</div>
