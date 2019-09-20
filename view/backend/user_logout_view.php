<?php
	if(!ISSET($_SESSION['id_user_admin']))
	{?>

<?php $title = 'Connectez-vous'; ?>
<?php ob_start(); ?>
					<!-- Confirmation -->

					<div class="card my-4">
		        <h5 class="card-header">Bonjour !</h5>
		          <div class="card-body">
		            <p>Vous n'êtes pas connectés. &nbsp;</p>
								<p>Pour vous connecter, <a href="<?php echo BASE_URL; ?>writeradmin/">cliquez ici</a></p>
		          </div>
		      </div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/template_login.php';?>

<?php }

	else {
	session_destroy();

	// Suppression des cookies de connexion automatique
	setcookie('username', '');
	setcookie('pass', '');
?>

<?php $title = 'Déconnexion'; ?>
<?php ob_start(); ?>

			<!-- Bienvenue -->
      <div class="card my-4">
        <h5 class="card-header">A bientôt !</h5>
          <div class="card-body">
            <p>Vous avez été déconnectés. &nbsp;</p>
						<p>Pour vous connecter, <a href="<?php echo BASE_URL; ?>writeradmin/">cliquez ici</a></p>
          </div>
      </div>



<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/template_login.php';?>

<?php
};
?>
