<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location: ../../writeradmin');
	}
	else {
?>
<?php $title = "Modification d'un article"; ?>
<?php ob_start(); ?>
<?php
		if (!empty(($_SESSION['messages']['itemupdated'])))
							{?>
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									<?php echo $_SESSION['messages']['itemupdated'];
									?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
<?php unset ($_SESSION['messages']['itemupdated']); }?>
<!-- Modification d'un article -->
<div class="card my-4">
  <h5 class="card-header">Modification de l'article</h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?php echo BASE_URL; ?>writeradmin/index.php?action=updateitem&amp;id=<?= $item['id'] ?>" method="post"
	        id="itemmodification" novalidate>
					<div class="form-group">
	            <div class="col-xs-6">
								<input class="form-control" id="title" name="title" type="text" placeholder="<?php echo $item['title'];?>" value="<?php echo $item['title'];?>"><br>

	                <textarea rows="15" cols="30" class="form-control" name="content" id="content"
	                placeholder="<?php echo $item['content'];?>"
	                title="Modifiez l'article si besoin"><?php echo $item['content'];?></textarea>
	            </div>
	        </div>
	        <div class="form-group">
	             <div class="col-xs-12">
	                  <br>
										<button class="btn btn-md btn-success" name="modify" type="submit"> Enregistrer</button>
	                  <a href="#" role="button" class="btn btn-md btn-secondary" type="reset"> Annuler</a>
	                  <a href="<?php echo BASE_URL; ?>writeradmin/index.php" role="button" class="btn btn-md btn-primary" type="button"> Retour</a>
	              </div>
	        </div>
      </form>
    </div>
</div>







<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
<?php }
