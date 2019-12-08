<?php $this->title = 'Jean Forteroche | écrivain et acteur | Blog'; ?>

<!-- Pour chaque post on met un foreach : -->
<?php foreach ($items as $item):?>

<!-- Title -->
<span class="text-body newstitle"><a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/1/" : "item/indexuser/" . $this->clean($item['id']) . "/1/" ?>"><h1 class="mt-4 text-left"><?= $this->clean($item['title']) ?>
</h1></a></span>

<!-- Author -->
<span class="lead">publié par <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>">
    <?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name']) ?></a></span>
    <br>

<!-- Date et Heure de Publication -->
<em>le <?= $this->clean($item['date_creation_fr']) ?></em><br>
  <?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
  	<em>article modifé le&nbsp;<?= $this->clean($item['date_update'])?></em>
  	<?php }?>

<hr>

<!-- Image du Post -->
  <figure class="figure">
  <a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id'])  . "/1/" : "item/indexuser/" . $this->clean($item['id']). "/1/" ?>">
    <img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" class="figure-img img-fluid rounded-right"
  alt="<?= $this->clean($item['title']) ?>" title="<?= $this->clean($item['title']) ?>"></a>
  <figcaption class="figure-caption text-right"><?= $this->clean($item['title']) ?></figcaption>
  </figure>

  <hr>

<!-- Post  -->
<p class="lead"><?= $this->cleantinymce($item['content']) ?></p>


<!-- Commentaires  -->
<!-- Affichage du lien Commentaires associé au post  : -->
<em class="fas fa-book-reader"></em>&nbsp; <em><a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id'])  . "/1/" : "item/indexuser/" . $this->clean($item['id']). "/1/" ?>">Lire la suite</a> || &nbsp;<em class="fas fa-comments"></em>&nbsp;
<a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id'])  . "/1/" : "item/indexuser/" . $this->clean($item['id']). "/1/" ?>#comments">Commentaires</a></em>
<p>&nbsp;</p>
<hr>

<?php
endforeach;
if ($items_current_page > $number_of_items_pages) {
	require __DIR__ . '/../errors/items_not_found.php';
}
else {
require __DIR__ . '/../Home/pagination_home.php';
}
?>
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
