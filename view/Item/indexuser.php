<?php $this->title = WEBSITE_NAME.' | '. WEBSITE_SUBTITLE.' | ' .$this->clean($item['title']);?>

<!-- Vérification de l'existence de l'item -->
<?php if (empty($item)) { require __DIR__ . '/../errors/item_not_found.php';}
else {?>

<!-- Title -->
<h1 class="mt-4 text-left"><?= $this->clean($item['title']) ?></h1>

<!-- Author -->
<span class="lead">publié par <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>">
  <?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a></span>
<br>

<!-- Date et Heure de Publication -->
<em>le <?= $this->clean($item['date_creation_fr']) ?></em>&nbsp;<em class="fas fa-comments">&nbsp;</em><em><a href="<?= "item/indexuser/" . $this->clean($item['id']). "/1/"  ?>#comments">Commentaires (<?= $number_of_comments ;?>)</a></em><br>
<?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
	<em>article modifé le&nbsp;<?= $this->clean($item['date_update']) ?></em>
	<?php } ?>
<hr>

<!-- Image du Post -->
<figure class="figure">
<img src="<?= BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" class="figure-img img-fluid rounded-right"
alt="<?= $this->clean($item['title']) ?>" title="<?= $this->clean($item['title']) ?>">
<figcaption class="figure-caption text-right"><?= $this->clean($item['title']) ?></figcaption>
</figure>

<hr>

<!-- Post  -->
<p class="lead"><?= $this->cleantinymce($item['content']) ?></p>

<!-- Commentaires  -->
<h2 id="comments">Commentaires</h2>
<hr>
<?php
if ($comments_current_page > $number_of_comments_pages) {
	require __DIR__ . '/../errors/comments_not_found.php';
}
?>
<!-- Message de confirmation -->
<?php require __DIR__ . '/../errors/confirmation.php'; ?>

<?php require('pagination_comments.php');?>
<?php foreach ($comments as $comment): ?>
	<div class="media mb-4">
	  <img class="img-fluid mr-3 rounded avatar" src="<?= BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
	  <div class="media-body">
	    <h6 class="mt-0"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></h6>
			<h4><?= $this->cleantinymce($comment['content']); ?></h4>
			<em>le <?= $comment['date_creation_fr']; ?></em><br>
				<?php if (isset($comment['date_update']) AND $comment['date_update'] > 0 ) {?>
					<em class="fas fa-history"></em>&nbsp;<em>commentaire modifé le&nbsp;<?= $comment['date_update']; ?></em><br>
					<?php }?>
					<em class="fas fa-flag"></em>&nbsp;<a href="item/reportcomment/<?= $this->clean($item['id']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">signaler le commentaire</a>&nbsp;
					<?php if(ISSET($_SESSION['id_user']) AND  $_SESSION['id_user'] == $comment['user_com'])  {
					?>
					|&nbsp;<em class="fas fa-edit"></em>&nbsp;<a href="item/readcomment/<?= $this->clean($item['id']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">modifier</a>
						<?php };?>
	  </div>
	</div>
<?php endforeach; ?>
<?php require('pagination_comments.php');?>
<hr>
<div id="addcomment"></div>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<!-- Ajout  de nouveaux commentaires : -->
	<div class="card my-4">
		<h5 class="card-header">Ajoutez un nouveau commentaire :</h5>
			<div class="card-body">
				<form action="item/createcommentloggedin" method="post">
					<div class="form-group row">
    				<label for="firstnamelastname" class="col-sm-5 col-form-label">Connecté en tant que :</label>
    						<div class="col-sm-7">
									<input type="hidden" id="id" name="id" value="<?= $this->clean($item['id']); ?>">
									<input type="hidden" id="user_id" name="user_id" value="<?= $_SESSION['id_user'];?>">
      						<input type="text" readonly class="form-control-plaintext text-left" name="author" id="author" value="<?= $this->clean($user['firstname']).' ' .$this->clean($user['name'])?>">
								</div>
  					</div>
					<div class="form-group">
					<textarea class="form-control" id="comment" name="content" rows="6" placeholder="Ecrivez ici votre commentaire"></textarea>
					</div>
          <div class="g-recaptcha" data-sitekey="6LerX8QUAAAAAAEdU0JZMW5e9-7UNFVF4VumMHcz"></div>
								<button type="submit" class="btn btn-primary">Envoyer</button>
				</form>
			</div>
	</div>
<?php };?>
<!-- Fin des commentaires -->
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
