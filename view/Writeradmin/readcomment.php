<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: ../writeradmin/logout/');
	}
	else {
?>
<?php $this->title = 'Modification d\'un commentaire'; ?>

<!-- Modification d'un article -->
<?php
if (!empty($_SESSION['messages']['confirmation']))
					{?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?php echo $_SESSION['messages']['confirmation'];
							?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<?php
					}
?>

<?php unset($_SESSION['messages']); ?>
<!-- Modification d'un commentaire -->
<div class="media mb-4">
	<img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($comment['avatar_com']) ? $comment['avatar_com'] : $default );?>" alt="user">
  <div class="media-body">
      <form role="form" class="form needs-validation" action="<?php echo BASE_URL; ?>writeradmin/updatecomment/<?= $this->clean($comment['id']);?>" method="post" id="commentmodification" novalidate>
        <div class="form-group">
            <div class="col-xs-6">
							<h6 class="mt-0"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></h6>
							<em>le <?= $this->clean($comment['date_creation_fr']); ?></em>
                <p>&nbsp;</p>
                <textarea class="form-control" name="content" id="content"
                placeholder="<?= $this->clean($comment['content']);?>"
                title="Modifiez le commentaire si besoin"><?= $this->clean($comment['content']);?></textarea>
            </div>
        </div>
        <div class="form-group">
             <div class="col-xs-12">
                  <br>
                  <button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
                  <a href="#"><button class="btn btn-md btn-secondary" type="reset">Annuler</button></a>
                  <a href="<?php echo BASE_URL; ?>writeradmin"><button class="btn btn-md btn-primary" type="button">Retour</button></a>
              </div>
        </div>
      </form>
  </div>
</div>

<?php
};
?>