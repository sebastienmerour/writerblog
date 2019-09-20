<?php
	if(!ISSET($_SESSION['id_user'])){
		header('location: index.php');
	}
	else {
?>
<?php $title = 'Mon compte'; ?>
<?php ob_start();?>
				<!-- Username -->
				<?php
					echo '<h1 class="mt-4">Bienvenue ' .$user['firstname']. '</h1>';
				?>
				<!-- Author -->
				<hr>
				<!-- Date/Time -->
				<p>Mon Profil</p>
				<hr>

				<!-- Avatar-->
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<!-- Avatar - Vérifier si le membre a un avatar ou non -->
							<?php



								// Vérifier si l'article existe :
								if (empty($user['avatar'])) {
										echo '<p>Il n\'y a pas d\'avatar pour vous</p>';
								} else {
									?>
									<figure class="figure">
						      <img src="<?php echo BASE_URL; ?>public/images/avatars/<?php echo htmlspecialchars(strip_tags($user['avatar']));?>" class="figure-img img-fluid rounded-right"
						      alt="<?php echo htmlspecialchars(strip_tags($user['firstname'])); ?>" title="<?php echo htmlspecialchars(strip_tags($user['firstname']));?>">
						      <figcaption class="figure-caption text-right"><?php echo htmlspecialchars(strip_tags($user['firstname'])); ?></figcaption>
						      </figure>

							<?php
						};
							?>

						</div><!-- fin du div col-sm-4 -->

						<div class="col-sm-8"><h6>Modifier la photo de profil :</h6>
						<form action="<?php echo BASE_URL; ?>user?action=updateavatar" method="post" enctype="multipart/form-data">
							                <input type="file" name="avatar" class="text-center center-block file-upload">
															<label for="avatar">(JPG, PNG ou GIF | max. 1 Mo)</label>
															<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
															<br>
										          <input type="submit" class="btn btn-sm btn-success" name="modifyavatar" value="Envoyer">
							</form>
		 				</div>

</div>
</div>
				<hr>


				<!-- Infos Personnelles -->
				<!-- TABS -->
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#infos" role="tab" aria-controls="pills-home" aria-selected="true">Infos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#username" role="tab" aria-controls="pills-profile" aria-selected="false">Identifiant</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="pills-home-tab">

                <!-- Infos Personnelles -->
        				<form role="form" class="form needs-validation" action="?action=updateuser" method="post" id="usermodification" novalidate>
                  <p>&nbsp;</p>
                  <?php
                  if (!empty($_SESSION['errors']['passdifferent'])){?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<?php  echo $_SESSION['errors']['passdifferent'];?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<?php };?>
                  <?php unset($_SESSION['errors']); ?>
                  <?php
                  if (!empty($_SESSION['errorsmail']['email'])){?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php  echo $_SESSION['errorsmail']['email']; ?>
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<?php };?>
                  <?php unset($_SESSION['errorsmail']); ?>
                  <div class="form-group">
        							<div class="col-xs-6">
        									<label for="password"><h4>Mot de passe</h4></label>
        									<input type="password" class="form-control" name="pass" id="pass" placeholder="Mot de passe"
                          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                          title="Votre mot de passe doit contenir au moins un chiffre, un lettre Majuscule, une lettre minuscule et au minimum 8 caractères"
                          placeholder="Mot de passe" data-placement="left"><br>
        									<input type="password" class="form-control" name="passcheck" id="pass2" placeholder="Confirmez le mot de passe" title="Confirmez votre mot de passe">
        							</div>
        					</div>

                  <div class="form-group">
                      <div class="col-xs-6">
                          <label for="email"><h4>E-Mail</h4></label>
                          <input type="email" class="form-control" name="email" id="email" value="<?php echo $user['email']?>" title="Modifiez votre email si besoin">
                      </div>
                  </div>

        						<div class="form-group">
        								<div class="col-xs-6">
        										<label for="firstname"><h4>Prénom</h4></label>
        										<input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $user['firstname']?>" title="Modifiez votre prénom si besoin">
        								</div>
        						</div>

        						<div class="form-group">
        								<div class="col-xs-6">
        									<label for="name"><h4>Nom</h4></label>
        										<input type="text" class="form-control" name="name" id="name" value="<?php echo $user['name'] ?>" title="Modifiez votre nom si besoin">
        								</div>
        						</div>

                    <div class="form-group">
                        <div class="col-xs-6">
                            <label for="date_birth"><h4>Date de naissance</h4></label>
                            <input type="date" class="form-control" name="date_birth" id="date_birth" value="<?php echo strftime('%Y-%m-%d', strtotime($user['date_naissance'])); ?>" title="Modifiez votre date de naissance si besoin">
                        </div>
                    </div>
        						<div class="form-group">
        								 <div class="col-xs-12">
        											<br>
        											<button class="btn btn-md btn-success" name="modifyuser" type="submit">Enregistrer</button>
        											<a href="#" class="btn btn-md btn-secondary" type="reset">Annuler</a>
        											<a href="index.php" class="btn btn-md btn-primary" role="button">Retour</a>
        									</div>
        						</div>
                    <p>&nbsp;</p>
                    <div id="feedback" class="text-left">
                    	<span class="text-left">Votre mot de passe doit contenir :</span><br>
                      <span id="letter" class="invalid">- au moins <b>1 minuscule</b></span><br>
                      <span id="capital" class="invalid">- au moins <b>1 majuscule</b></span><br>
                      <span id="number" class="invalid">- au moins <b>1 chiffre</b></span><br>
                      <span id="length" class="invalid">- au minimum <b>8 caractères</b></span><br>
                    </div>

        		        </form>


			</div>

	              <div class="tab-pane fade" id="username" role="tabpanel" aria-labelledby="pills-profile-tab">

									<table class="table table-striped">
										<tbody>
											<tr>
												<th scope="row">Identifiant</th>
												<td><?php echo $user['username']?></td>
											</tr>

										</tbody>
									</table>

									<a href="?action=modifyusername" class="btn btn-md btn-success" type="submit">Modifier</a>

						</div>

				<hr>

			</div><!-- fin du div tab-content -->
		</div>

    <!-- Sidebar -->
    <div class="col-md-4">
      <?php if(!ISSET($_SESSION['id_user']))
                {
			     require('template_my_account_login.php'); }
           else {
             require('template_my_account_logout.php');
           }?>
<?php $content = ob_get_clean(); ?>
<?php require('template_user.php'); ?>

<?php
};
?>