<?php
	if(!ISSET($_SESSION['id_user']))
	{?>

<?php $title = 'Connectez-vous'; ?>
<?php ob_start(); ?>

					<!-- Bienvenue -->
					<h1 class="mt-4">Bonjour !</h1>

					<!-- Date/Time -->

					<hr>

					<!-- Confirmation -->
					<div class="container">
						<div class="row">
							<p>Vous n'êtes pas connectés. &nbsp;</p>
							<p>Pour vous connecter, <a href="<?php echo BASE_URL; ?>user/?action=login">cliquez ici</a></p>
						</div>
					</div>
					<hr>
				</div>

		    <!-- Sidebar -->
		    <div class="col-md-4">

<?php require('template_my_account_login.php'); ?>
<?php $content = ob_get_clean(); ?>
<?php require('template_user.php'); ?>

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
			<h1 class="mt-4">A bientôt !</h1>

			<!-- Date/Time -->

			<hr>

			<!-- Confirmation -->
			<div class="container">
				<div class="row">
					<p>Vous avez été déconnectés. &nbsp;</p>
					<p>Pour vous connecter, <a href="<?php echo BASE_URL; ?>user/?action=login">cliquez ici</a></p>
				</div>
			</div>
			<hr>

		</div>

    <!-- Sidebar -->
    <div class="col-md-4">
      <?php require('template_my_account_login.php'); ?>

<?php $content = ob_get_clean(); ?>
<?php require('template_user.php'); ?>

<?php
};
?>
