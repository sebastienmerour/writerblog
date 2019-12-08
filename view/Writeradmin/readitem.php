<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: ../../writeradmin/');
	}
	else {
?>
<?php $this->title = 'Modification d\'un article'; ?>
<?php if (empty($item)) {
							require __DIR__ . '/../errors/item_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
  <h5 class="card-header">Modification de l'article</h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?php echo BASE_URL; ?>writeradmin/updateitem/<?= $this->clean($item['id']);?>" method="post"
	        id="itemmodification" enctype="multipart/form-data" novalidate>
					<div class="form-group">
	            <div class="col-xs-6">
								<input class="form-control" id="title" name="title" type="text" placeholder="<?= $this->clean($item['title']);?>" value="<?= $this->clean($item['title']);?>"><br>
								<hr>
						 	<label for="itemimage"><h5>Image principale de l'article :</h5></label><br>
							<?php if (empty($item['image'])) {
									echo '<p>Il n\'y a pas d\'image pour cet article. Ajoutez une image ci-dessous :</p>';
							} else {
								?>
								<figure class="figure">
								<img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image']);?>" class="figure-img img-fluid rounded-right"
								alt="<?= $this->clean($item['title']); ?>" title="<?= $this->clean($item['title']);?>">
								<figcaption class="figure-caption text-right"><?= $this->clean($item['title']); ?></figcaption>
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
	                placeholder="<?= $this->clean($item['content']);?>"
	                title="Modifiez l'article si besoin"><?= $this->clean($item['content']);?></textarea>
	            </div>
	        </div>
	        <div class="form-group">
	             <div class="col-xs-12">
	                  <br>
	                  <button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
	                  <a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
	                  <a href="<?php echo BASE_URL; ?>writeradmin" role="button" class="btn btn-md btn-primary" type="button">Retour</a>
	              </div>
	        </div>
      </form>
    </div>
</div>
<?php
};
};
?>
