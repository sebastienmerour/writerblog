<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location: ../../writeradmin');
	}
	else {
?>
<?php $title = "Modification d'un article"; ?>
<?php ob_start(); ?>
<!-- Modification d'un article -->
<?php
if (!empty($_SESSION['messages']['itemupdated']))
					{?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?php echo $_SESSION['messages']['itemupdated'];
							?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<?php
					}
?>

<?php unset($_SESSION['messages']); ?>
<div class="card my-4">
  <h5 class="card-header">Modification de l'article</h5>
    <div class="card-body">

				<form role="form" class="form needs-validation" action="<?php echo BASE_URL; ?>writeradmin/index.php?action=updateitem&amp;id=<?php echo $_GET['id']; ?>" method="post"
	        id="itemmodification" enctype="multipart/form-data" novalidate>
					<div class="form-group">
	            <div class="col-xs-6">
								<input class="form-control" id="title" name="title" type="text" placeholder="<?php echo $item['title'];?>" value="<?php echo $item['title'];?>"><br>
								<hr>
						 	<label for="itemimage"><h5>Image principale de l'article :</h5></label><br>
							<?php if (empty($item['image'])) {
									echo '<p>Il n\'y a pas d\'image pour cet article. Ajoutez une image ci-dessous :</p>';
							} else {
								?>
								<figure class="figure">
								<img src="<?php echo BASE_URL; ?>public/images/item_images/<?php echo htmlspecialchars(strip_tags($item['image']));?>" class="figure-img img-fluid rounded-right"
								alt="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>" title="<?php echo htmlspecialchars(strip_tags($item['title']));?>">
								<figcaption class="figure-caption text-right"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></figcaption>
								</figure>
								<?php
								};
								?>
							<div class="custom-file">
							<input type="file" name="image" class="custom-file-input">
							<label class="custom-file-label" for="customFile">Parcourir...</label>
							</div>
							<label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label>
							<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
							<hr>

	                <textarea rows="15" cols="30" class="form-control" name="content" id="content"
	                placeholder="<?php echo $item['content'];?>"
	                title="Modifiez l'article si besoin"><?php echo $item['content'];?></textarea>

	            </div>
	        </div>
	        <div class="form-group">
	             <div class="col-xs-12">
	                  <br>
	                  <button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
	                  <a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
	                  <a href="<?php echo BASE_URL; ?>writeradmin/index.php" role="button" class="btn btn-md btn-primary" type="button">Retour</a>
	              </div>
	        </div>
      </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
<?php }
