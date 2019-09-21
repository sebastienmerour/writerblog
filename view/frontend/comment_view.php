<?php  $title = $item['title'] ;?>
<?php ob_start(); ?>
<?php

if (empty($comment)) {
							require __DIR__ . '/../errors/comment_not_found.php';
			    } else {;
					  if (!empty($_SESSION['messages']['commentupdated']))
					            {?>
					              <div class="alert alert-success alert-dismissible fade show" role="alert">
					                <?php echo $_SESSION['messages']['commentupdated'];
					                ?>
					                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                  <span aria-hidden="true">&times;</span>
					                </button>
					              </div>
					              <?php
					            }
					?>
<?php unset($_SESSION['messages']); ?>


<h2 id="comments">Modifier le Commentaire : </h2>
<hr>
<div class="media mb-4">
	<img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
  <div class="media-body">
		<form role="form" class="form needs-validation" action="index.php?id=<?php echo $_GET['id'] ;?>&amp;action=updatecomment&amp;id_comment=<?= $comment['id'] ?>" method="post"
        id="usermodification" novalidate>
        <div class="form-group">
            <div class="col-xs-6">
              <h5 class="mt-0"><?php echo htmlspecialchars($comment['author'], ENT_QUOTES, 'UTF-8'); ?></h5><em>le
                <?php echo $comment['date_creation_fr']; ?></em><br>
								<?php if (isset($comment['date_update']) AND $comment['date_update'] > 0 ) {?>
									<em>commentaire modifé le&nbsp;<?php echo $item['date_update']; ?></em>
									<?php }?>
                <p>&nbsp;</p>
                <textarea class="form-control" name="content" id="content"
                placeholder="<?php echo $comment['content'];?>"
                title="Modifiez votre commentaire si besoin"><?php echo $comment['content'];?></textarea>
            </div>
        </div>
        <div class="form-group">
             <div class="col-xs-12">
                  <br>
                  <button class="btn btn-md btn-success" name="modify" type="submit"> Enregistrer</button>
                  <a href="#"><button class="btn btn-md btn-secondary" type="reset"> Annuler</button></a>
                  <a href="index.php?action=readitem&id=<?php echo $_GET['id'] ;?>"><button class="btn btn-md btn-primary" type="button"> Retour</button></a>
              </div>
        </div>

      </form>

  </div>
</div>
<?php } ;?>
<!-- Commentaires  -->
<h2 id="comments">Commentaires</h2>
<hr>
<?php require('comment_pagination_view.php'); ?>
<?php
while ($comment = $comments->fetch())
{
  ?>
	<div class="media mb-4">
		<img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
	  <div class="media-body">
			<h6 class="mt-0"><?php echo htmlspecialchars(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author'], ENT_QUOTES, 'UTF-8');?></h6>
			<h4><?php echo htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8'); ?></h4>
			<em>le <?php echo $comment['date_creation_fr']; ?></em><br>
				<?php if (isset($comment['date_update']) AND $comment['date_update'] > 0 ) {?>
						<em>commentaire modifé le&nbsp;<?php echo $item['date_update']; ?></em>
						<?php }?>
						<?php if(ISSET($_SESSION['id_user']) AND  $_SESSION['id_user'] == $comment['user_com'])  {
							?>
	      		(<a href="index.php?id=<?php echo $_GET['id'] ;?>&action=readcomment&amp;id_comment=<?php echo $comment['id'] ;?>">modifier</a>)
						<?php };?>
	  </div>
	</div>
<?php
}
?>
<?php require('comment_pagination_view.php'); ?>
<!-- Ajout  de nouveaux commentaires : -->
<hr>
<div class="card my-4">
	<h5 class="card-header">Ajoutez un nouveau commentaire :</h5>
		<div class="card-body">
			<form action="index.php?action=createcomment&amp;id=<?= $item['id'] ?>" method="post">
				<div class="form-group row">
					<label for="firstnamelastname" class="col-sm-5 col-form-label">Connecté en tant que :</label>
							<div class="col-sm-7">
								<input type="text" readonly class="form-control-plaintext text-left" name="author" id="author" value="<?= $item['firstname'].' ' .$item['name']?>">
							</div>
					</div>
				<div class="form-group">
				<textarea class="form-control" id="comment" name="content" rows="6" placeholder="Ecrivez ici votre commentaire"></textarea>
				</div>
							<button type="submit" class="btn btn-primary">Envoyer</button>
			</form>
		</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('view/frontend/template_comments.php'); ?>
