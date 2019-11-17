<?php $this->title = 'Jean Forteroche | écrivain et acteur | Blog' . $this->clean($item['title']); ?>
<!-- Vérification de l'existence de l'item -->
<?php if (empty($item)) { require __DIR__ . '/../errors/item_not_found.php';} ?>

<!-- Title -->
<h1 class="mt-4 text-left"><?= $this->clean($item['title']) ?></h1>

<!-- Author -->
<span class="lead">publié par <a href="<?= "user/profle/" . $this->clean($item['id_user']) ?>">
  <?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a></span>
<br>

<!-- Date et Heure de Publication -->
<em>le <?= $this->clean($item['date_creation_fr']) ?></em>&nbsp;<em class="fas fa-comments">&nbsp;</em><em><a href="<?= "item/" . $this->clean($item['id']). "/1/"  ?>#comments">Commentaires (<?php echo $number_of_comments ;?>)</a></em><br>
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
<!-- Message de confirmation -->
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
<?php require('pagination_comments.php');?>
<?php foreach ($comments as $comment): ?>
	<div class="media mb-4">
	  <img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user">
	  <div class="media-body">
	    <h6 class="mt-0"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></h6>
			<h4><?= $this->clean($comment['content']); ?></h4>
			<?php if (isset($comment['date_update']) AND $comment['date_update'] > 0 ) {?>
				<em class="fas fa-history"></em>&nbsp;<em>commentaire modifé le&nbsp;<?php echo $comment['date_update']; ?></em><br>
				<?php }?>
				<em class="fas fa-flag"></em>&nbsp;<a href="item/reportcomment/<?= $this->clean($item['id']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">signaler le commentaire</a>&nbsp;
	</div>
</div>
<?php endforeach; ?>
<?php require('pagination_comments.php');?>
<hr>
<!-- Ajout  de nouveaux commentaires : -->
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
<!-- Fin des commentaires -->
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
