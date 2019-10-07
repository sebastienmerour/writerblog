<?php $this->title = 'Jean Forteroche | écrivain et acteur | Blog' . $this->clean($item['title']); ?>
<!-- Message de confirmation -->
<?php
if (empty($item)) {
	require __DIR__ . '/../errors/item_not_found.php';
			    } else {
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
<!-- Title -->
<h1 class="mt-4 text-left"><?= $this->clean($item['title']) ?></h1>

<!-- Author -->
<span class="lead">publié par <a href="<?= "user/index/" . $this->clean($item['id_user']) ?>">
  <?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a></span>
<br>

<!-- Date et Heure de Publication -->
<em>le <?= $this->clean($item['date_creation_fr']) ?></em>&nbsp;<em class="fas fa-comments">&nbsp;</em><em><a href="<?= "item/index/" . $this->clean($item['id']) ?>#comments">Commentaires</a></em><br>
<?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
	<em>article modifé le&nbsp;<?= $this->clean($item['date_update']) ?></em>
	<?php } ?>
<hr>

<!-- Image du Post -->
<figure class="figure">
<img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" class="figure-img img-fluid rounded-right"
alt="<?= $this->clean($item['title']) ?>" title="<?= $this->clean($item['title']) ?>">
<figcaption class="figure-caption text-right"><?= $this->clean($item['title']) ?></figcaption>
</figure>

<hr>

<!-- Post  -->
<p class="lead"><?= $this->clean($item['content']) ?></p>

<!-- Commentaires  -->
<h2 id="comments">Commentaires</h2>
<hr>

<?php foreach ($comments as $comment): ?>
	<div class="media mb-4">
	  <img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
	  <div class="media-body">
	    <h6 class="mt-0"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author'], ENT_QUOTES, 'UTF-8');?></h6>
			<h4><?= $this->clean($comment['content']); ?></h4>
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
<?php endforeach; ?>
<?php
}
require('pagination_comments.php');

?>
<hr>
<!-- Ajout  de nouveaux commentaires : -->
<?php if(!ISSET($_SESSION['id_user'])){
	?>
    <div class="card my-4">
      <h5 class="card-header">Ajoutez un nouveau commentaire :</h5>
        <div class="card-body">
          <form action="item/createcomment" method="post">
            <div class="form-group">
							<input type="hidden" id="id" name="id" value="<?= $this->clean($item['id']); ?>">
              <input class="form-control" id="author" name="author" type="text" placeholder="Prénom"><br>
                  <textarea class="form-control" id="comment" name="content" rows="6" placeholder="Ecrivez ici votre commentaire"></textarea>
            </div>
                  <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
        </div>
    </div>
	<?php }
else {?>

	<div class="card my-4">
		<h5 class="card-header">Ajoutez un nouveau commentaire :</h5>
			<div class="card-body">
				<form action="item/createcommentloggedin>" method="post">
					<div class="form-group row">
    				<label for="firstnamelastname" class="col-sm-5 col-form-label">Connecté en tant que :</label>
    						<div class="col-sm-7">
									<input type="hidden" id="id" name="id" value="<?= $this->clean($item['id']); ?>">
									<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['id_user'];?>">
      						<input type="text" readonly class="form-control-plaintext text-left" name="author" id="author" value="<?= $user['firstname'].' ' .$user['name']?>">
								</div>
  					</div>
					<div class="form-group">
					<textarea class="form-control" id="comment" name="content" rows="6" placeholder="Ecrivez ici votre commentaire"></textarea>
					</div>
								<button type="submit" class="btn btn-primary">Envoyer</button>
				</form>
			</div>
	</div>
<?php };?>
<!-- Fin des commentaires -->
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
