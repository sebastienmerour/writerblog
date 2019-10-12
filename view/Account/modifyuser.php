<?php
	if(!ISSET($_SESSION['id_user'])){
		header('location: ../');
	}
	else {
?>

<?php $this->title = 'Mon compte - Mise à jour'; ?>
				<!-- Username -->
				<?php
					echo '<h1 class="mt-4">Bienvenue ' .$this->clean($user['firstname']). ' !</h1>';
				?>
				<!-- Author -->
				<hr>

				<!-- Date/Time -->
				<p>Mon Profil</p>
				<?php
				if (!empty($_SESSION['messages']['avatarupdated']))
									{?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
											<?php echo $_SESSION['messages']['avatarupdated'];
											?>
										  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    <span aria-hidden="true">&times;</span>
										  </button>
										</div>
										<?php
									}
		?>
		<?php unset($_SESSION['messages']); ?>				<hr>

              <!-- Avatar-->
      				<div class="container">
      					<div class="row">
      						<div class="col-sm-4">
      							<!-- Avatar - Vérifier si le membre a un avatar ou non -->
      							<?php
      								// Vérifier si l'avatar existe :
      								if (empty($user['avatar'])) {
      										echo '<p>Cet utilisateur n\'a pas d\'avatar</p>';
      								} else {
      									?>
      									<figure class="figure">
      						      <img src="<?php echo BASE_URL; ?>public/images/avatars/<?= $this->clean($user['avatar']);?>" class="figure-img img-fluid rounded-right"
      						      alt="<?= $this->clean($user['firstname']); ?>" title="<?= $this->clean($user['firstname']);?>">
      						      <figcaption class="figure-caption text-right"><?= $this->clean($user['firstname']); ?></figcaption>
      						      </figure>


      							<?php
      						};
      							?>

									</div><!-- fin du div col-sm-4 -->

							    <div class="col-sm-8"><h6>Modifier ma photo de profil :</h6>
									<form action="<?php echo BASE_URL; ?>user/?action=updateavatar" method="post" enctype="multipart/form-data">
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
							<?php
							if (!empty($_SESSION['messages']['userupdated'])){?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<?php  echo $_SESSION['messages']['userupdated'];?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<?php };?>
							<?php unset($_SESSION['messages']); ?>
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
        				<form role="form" class="form needs-validation" action="account/updateuser" method="post" id="usermodification" novalidate>
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
        											<a href="account" class="btn btn-md btn-primary" role="button">Retour</a>
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



				<a href="account/modifyuser" class="btn btn-md btn-success" role="button">Modifier</a>


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
									<a href="?action=modifyusername"><button class="btn btn-md btn-success" role="button">Modifier</button></a>



						</div>

				<hr>

			</div><!-- fin du div tab-content -->

<?php
$this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>';
};
?>
