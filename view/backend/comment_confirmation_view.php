<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location: ../../writeradmin');
	}
	else {
?>
<?php $title = "Modification d'un commentaire"; ?>
<?php ob_start(); ?>
<h2 id="comments">Modifier le Commentaire : </h2>
<hr>
<?php
		if (!empty(($_SESSION['messages']['commentupdated'])))
							{?>
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									<?php echo $_SESSION['messages']['commentupdated'];
									?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
<?php unset ($_SESSION['messages']['commentupdated']); }?>
<!-- Modification d'un commentaire -->
<div class="media mb-4">
	<img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
  <div class="media-body">
      <form role="form" class="form needs-validation" action="<?php echo BASE_URL; ?>writeradmin/index.php?action=updatecomment&amp;id_comment=<?= $comment['id'] ?>" method="post"
        id="usermodification" novalidate>
        <div class="form-group">
            <div class="col-xs-6">
              <h5 class="mt-0"><?php echo htmlspecialchars($comment['author'], ENT_QUOTES, 'UTF-8'); ?></h5><em>le
                <?php echo $comment['date_comment_fr']; ?></em>
                <p>&nbsp;</p>
                <textarea class="form-control" name="content" id="content"
                placeholder="<?php echo $comment['content'];?>"
                title="Modifiez le commentaire si besoin"><?php echo $comment['content'];?></textarea>
            </div>
        </div>
        <div class="form-group">
             <div class="col-xs-12">
                  <br>
                  <button class="btn btn-md btn-success" name="modify" type="submit"> Enregistrer</button>
                  <a href="#"><button class="btn btn-md btn-secondary" type="reset"> Annuler</button></a>
                  <a href="<?php echo BASE_URL; ?>writeradmin/index.php"><button class="btn btn-md btn-primary" type="button"> Retour</button></a>
              </div>
        </div>

      </form>

  </div>
</div>





<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
<?php }
