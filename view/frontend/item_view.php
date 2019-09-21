<?php $title = $item['title']; ?>
<?php ob_start(); ?>
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
<h1 class="mt-4 text-left"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></h1>

<!-- Author -->
<span class="lead">publié par <a href="<?php echo BASE_URL; ?>user/?action=readuser&id_user=<?php echo $item['id_user']?>">
  <?php echo htmlspecialchars(strip_tags($item['firstname'])); ?><?php echo '&nbsp;' ?><?php echo htmlspecialchars(strip_tags($item['name']));?></a></span>
<br>

<!-- Date et Heure de Publication -->
<em>le <?php echo $item['date_creation_fr']; ?></em>&nbsp;<em class="fas fa-comments">&nbsp;</em><em><a href="#comments">Commentaires</a></em><br>
<?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
	<em>article modifé le&nbsp;<?php echo $item['date_update']; ?></em>
	<?php } ?>
<hr>

<!-- Image du Post -->
<figure class="figure">
<img src="<?php echo BASE_URL; ?>public/images/item_images/<?php echo htmlspecialchars(strip_tags($item['image']));?>" class="figure-img img-fluid rounded-right"
alt="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>" title="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>">
<figcaption class="figure-caption text-right"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></figcaption>
</figure>
<hr>

<!-- Post  -->
<p class="lead"><?php echo nl2br(htmlspecialchars(strip_tags($item['content']))); ?></p>
<!-- Fin de l'item -->

<!-- Commentaires  -->
<h2 id="comments">Commentaires</h2>
<hr>
<?php
if ($comments_current_page > $number_of_comments_pages) {
	require __DIR__ . '/../errors/comments_not_found.php';
}
else {
require('comment_pagination_view.php');
?>
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
require('comment_pagination_view.php');
}
?>
<hr>
<!-- Ajout  de nouveaux commentaires : -->
<?php if(!ISSET($_SESSION['id_user'])){
	?>
    <div class="card my-4">
      <h5 class="card-header">Ajoutez un nouveau commentaire :</h5>
        <div class="card-body">
          <form action="index.php?action=createcomment&amp;id=<?= $item['id'] ?>" method="post">
            <div class="form-group">
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
				<form action="index.php?action=createcomment&amp;id=<?= $item['id'] ?>" method="post">
					<div class="form-group row">
    				<label for="firstnamelastname" class="col-sm-5 col-form-label">Connecté en tant que :</label>
    						<div class="col-sm-7">
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
<?php } ;?>
<?php $content = ob_get_clean(); ?>
<?php require('view/frontend/template_comments.php'); ?>
