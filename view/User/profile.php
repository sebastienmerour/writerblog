<?php $this->title = 'Profil de '.$this->clean($user['firstname']). ' '. $this->clean($user['name']).'' ?>
<!-- Vérification de l'existence de l'utilisateur -->
<?php if (empty($user)) { require __DIR__ . '/../errors/user_not_found.php';}
else {?>

				<!-- Username -->
				<h1 class="mt-4">Profil de <?= $this->clean($user['firstname']). ' '. $this->clean($user['name']) ?></h1>
    		<hr>

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
					</div>
				</div>
				<hr>

				<!-- Infos Personnelles -->
				<!-- TABS -->
        				<table class="table table-striped">
        				  <tbody>
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
        				<hr>
<?php };?>
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
