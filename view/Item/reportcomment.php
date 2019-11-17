<?php $this->title = 'Jean Forteroche | écrivain et acteur | Blog - Modification de commentaire'; ?>
<p>&nbsp;</p>
<?php
if (empty($comment)) {
							require __DIR__ . '/../errors/comment_not_found.php';
			    } else {;
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
<!-- Commentaires  -->
<h2 id="comments">Commentaires</h2>
<hr>
<?php require('pagination_comments.php'); ?>
<?php foreach ($comments as $comment): ?>
	<div class="media mb-4">
		<img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
	  <div class="media-body">
			<h6 class="mt-0"><?php echo htmlspecialchars(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author'], ENT_QUOTES, 'UTF-8');?></h6>
			<h4><?php echo htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8'); ?></h4>
			<em>le <?php echo $comment['date_creation_fr']; ?></em><br>
				<?php if (isset($comment['date_update']) AND $comment['date_update'] > 0 ) {?>
						<em class="fas fa-history"></em>&nbsp;<em>commentaire modifé le&nbsp;<?php echo $comment['date_update']; ?></em><br>
						<?php }?>
						<em class="fas fa-flag"></em>&nbsp;<a href="item/reportcomment/<?= $this->clean($item['id']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">signaler le commentaire</a>&nbsp;
						<?php if(ISSET($_SESSION['id_user']) AND  $_SESSION['id_user'] == $comment['user_com'])  {
							?>
							|&nbsp;<em class="fas fa-edit"></em>&nbsp;<a href="item/readcomment/<?= $this->clean($item['id']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">modifier</a>
								<?php };?>
	  </div>
	</div>
<?php endforeach; ?>

<?php require('pagination_comments.php'); ?>
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
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
