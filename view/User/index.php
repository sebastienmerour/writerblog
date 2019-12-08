<?php
	if(!ISSET($_SESSION['id_user'])){
		header('location: ../writerblog/login/invite');
	}
	else {
?>

<?php $this->title = 'Mon compte'; ?>
				<!-- Username -->
				<?php
					echo '<h1 class="mt-4">Bienvenue ' .$this->clean($user['firstname']). ' !</h1>';
				?>
				<hr>

				<!-- Profil -->
				<p>Mon Profil</p>
				<hr>

				<?php require __DIR__ . '/../errors/errors.php'; ?>
				<?php require __DIR__ . '/../errors/confirmation.php'; ?>

              <!-- Avatar-->
      				<div class="container">
      					<div class="row">
      						<div class="col-sm-4">
      							<?php
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
									<form action="<?php echo BASE_URL; ?>user/updateavatar" method="post" enctype="multipart/form-data">
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
							<td><?php echo strftime('%d/%m/%Y', strtotime($user['date_birth'])); ?></td>
						</tr>
				  </tbody>
				</table>
				<a href="user/modifyuser" class="btn btn-md btn-success" role="button">Modifier</a>
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
									<a href="user/modifyuser"><button class="btn btn-md btn-success" role="button">Modifier</button></a>
						</div>
				<hr>
			</div><!-- fin du div tab-content -->

<?php
$this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>';
};
?>
