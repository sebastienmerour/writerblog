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
        echo '<h1 class="mt-4">Profil de ' .$user['firstname']. ' '.$user['name']. '</h1>';
				?>

				<!-- Date/Time -->

    	<hr>

				<!-- Avatar-->
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<!-- Avatar - Vérifier si le membre a un avatar ou non -->
							<?php



								// Vérifier si l'avatar existe :
								if (empty($user['avatar'])) {
										echo '<p>Cet utilisateur n\'a d\'avatar</p>';
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
        							<td><?php echo $user['date_naissance'] ?></td>
        						</tr>
        				  </tbody>
        				</table>

        				<hr>

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
