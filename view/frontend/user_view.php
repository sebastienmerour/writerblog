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
					echo '<h1 class="mt-4">Bienvenue ' .$user['firstname']. ' !</h1>';
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

				<table class="table table-striped">
				  <tbody>
				    <tr>
				      <th scope="row">Mot de Passe</th>
				      <td>********</td>
				    </tr>
						<tr>
				      <th scope="row">E-Mail</th>
				      <td><?php echo $user['email'] ?></td>
				    </tr>
				    <tr>
				      <th scope="row">Prénom</th>
				      <td><?php echo $user['firstname'] ?></td>
				    </tr>
						<tr>
				      <th scope="row">Nom</th>
				      <td><?php echo $user['name'] ?></td>
				    </tr>
						<tr>
							<th scope="row">Date de naissance</th>
							<td><?php echo strftime('%d/%m/%Y', strtotime($user['date_naissance'])); ?></td>
						</tr>
				  </tbody>
				</table>
				<a href="?action=modifyuser" class="btn btn-md btn-success" role="button">Modifier</a>


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
