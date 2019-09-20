<?php $title = 'Jean Forteroche | écrivain et acteur | Blog'; ?>
<?php ob_start(); ?>

<!-- Pour chaque post on met un While : -->
<?php
while ($item = $items->fetch()) {
?>
  <!-- Title -->
  <span class="text-body newstitle"><a href="index.php?action=readitem&amp;id=<?= $item['id'] ?>"><h1 class="mt-4 text-left"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></h1></a></span>

  <!-- Author -->
  <span class="lead">publié par <a href="<?php echo BASE_URL; ?>user/?action=readuser&id_user=<?php echo $item['id_user']?>">
    <?php echo htmlspecialchars(strip_tags($item['firstname'])); ?><?php echo '&nbsp;' ?><?php echo htmlspecialchars(strip_tags($item['name']));?></a></span>
    <br>

  <!-- Date et Heure de Publication -->
  <em>le <?php echo $item['date_creation_fr']; ?></em><br>
  <?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
  	<em>article modifé le&nbsp;<?php echo $item['date_update']; ?></em>
  	<?php }?>

  <hr>

  <!-- Image du Post -->
  <figure class="figure">
  <a href="index.php?action=readitem&amp;id=<?= $item['id'] ?>"><img src="<?php echo BASE_URL; ?>public/images/item_images/<?php echo htmlspecialchars(strip_tags($item['item_image']));?>" class="figure-img img-fluid rounded-right"
  alt="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>" title="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>"></a>
  <figcaption class="figure-caption text-right"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></figcaption>
  </figure>

  <hr>

  <!-- Post  -->
  <p class="lead"><?php echo nl2br(htmlspecialchars(strip_tags($item['content']))); ?></p>


<!-- Commentaires  -->
<!-- Affichage du lien Commentaires associé au post  : -->

<em class="fas fa-book-reader"></em>&nbsp; <em><a href="index.php?action=readitem&amp;id=<?= $item['id'] ?>">Lire la suite</a> || &nbsp;<em class="fas fa-comments"></em>&nbsp;<a href="index.php?action=readitem&amp;id=<?= $item['id'] ?>#comments">Commentaires</a></em>
<p>&nbsp;</p>
<hr>

<?php
  }
if ($items_current_page > $number_of_items_pages) {
	require __DIR__ . '/../errors/items_not_found.php';
}
else {
require('item_pagination_view.php');}
?>
<?php $content = ob_get_clean(); ?>
<?php require('view/frontend/template.php'); ?>
