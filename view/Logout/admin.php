<?php
	if(!ISSET($_SESSION['id_user_admin']))
	{?>
<?php $this->title = 'Connectez-vous - Panneau d\'Administration'; ?>


					<!-- Confirmation -->

					<div class="card my-4">
		        <h5 class="card-header">Bonjour !</h5>
		          <div class="card-body">
		            <p>Vous n'êtes pas connectés. &nbsp;</p>
								<p>Pour vous connecter, <a href="<?php echo BASE_URL; ?>writeradmin/">cliquez ici</a></p>
		          </div>
		      </div>


<?php }

	else {
	session_destroy();

	// Suppression des cookies de connexion automatique
	setcookie('username', '');
	setcookie('pass', '');
?>

<?php $this->title = 'Déconnexion - Panneau d\'Administration'; ?>

			<!-- Bienvenue -->
      <div class="card my-4">
        <h5 class="card-header">A bientôt !</h5>
          <div class="card-body">
            <p>Vous avez été déconnectés. &nbsp;</p>
						<p>Pour vous connecter, <a href="<?php echo BASE_URL; ?>writeradmin/">cliquez ici</a></p>
          </div>
      </div>



<?php
};
?>
