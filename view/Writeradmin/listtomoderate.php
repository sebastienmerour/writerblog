<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: ../../../../writeradmin/');
	}
	else {
?>
<?php $this->title = 'Jean Forteroche - Panneau d\'Administration'; ?>
  <!-- News -->
	<?php require __DIR__ . '/../errors/confirmation.php'; ?>

<h2 id="tomoderate">Commentaires signalés</h2>
	<?php
	if ($counter_comments_reported < 1) {
	  require __DIR__ . '/../view/errors/comments_not_found.php';
	}

	else {
	require('listtomoderate_pagination.php');}
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
	      while ($comment_reported = $comments_reported->fetch())
	      {
	      ?>
	      <tr>
	        <td><h6 class="mt-2 text-left"><?= $this->clean($comment_reported['date_creation_fr']); ?></h6></td>
	        <td><div class="media mb-4">
	          <img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($comment_reported['avatar_com'])) ? $this->clean($comment_reported['avatar_com']) : $default ;?>" alt="user">
	          <div class="media-body">
	            <h6 class="mt-2 text-left"><?= $this->clean(isset($comment_reported['firstname_com'], $comment_reported['name_com']) ? $comment_reported['firstname_com'] . ' ' . $comment_reported['name_com'] : $comment_reported['author']);?></h6><br>
	          </div>
	        </div></td>
	        <td><h6 class="mt-2 text-left"><?= $this->cleantinymce($comment_reported['content']); ?></h6></td>
	        <td><a href="<?= "../../../readcomment/" . $this->clean($comment_reported['id']) ;?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
	        <td><a href="<?= "../../../removecommentreported/" . $this->clean($comment_reported['id']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
	      </tr>
	            <?php
	    }
	  ?>
	    </tbody>
	  </table>
	</div>
	<?php
	if ($counter_comments_reported  < 1) {
	  require __DIR__ . '/../view/errors/comments_not_found.php';
	}
	else {
	require('listtomoderate_pagination.php');}
	?>
</div>
<?php
};
?>
