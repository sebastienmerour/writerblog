<?php
	if(!ISSET($_SESSION['id_user'])){
?>
<?php $this->title = 'Inscription'; ?>
<form class="form-signin needs-validation" method="post" action="user/createuser" novalidate>
<h1 class="h3 mb-3 font-weight-normal">Rejoignez le site</h1>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<label for "username" class="sr-only">Identifiant :&nbsp;</label>
<input type="text" class="form-control" id="username" name="username" placeholder="Identifiant" required autofocus><br>
<label for "password" class="sr-only">Mot de Passe :&nbsp;</label>
<input type="password" class="form-control" id="pass" name="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
title="Votre mot de passe doit contenir au moins un chiffre, un lettre Majuscule, une lettre minuscule et au minimum 8 caractères"
placeholder="Mot de passe" data-placement="right" required>
<label for "passcheck" class="sr-only">Confirmation :&nbsp;</label>
<input type="password" class="form-control" id="passcheck" name="passcheck" placeholder="Confirmez le Mot de passe" required><br>
<label for "email" class="sr-only">E-mail :&nbsp;</label>
<input type="text" class="form-control" id="email" name="email" placeholder="E-mail" required><br>
<div class="g-recaptcha" data-sitekey="6LerX8QUAAAAAAEdU0JZMW5e9-7UNFVF4VumMHcz"></div>
<button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Envoyer</button>
<p>&nbsp;</p>
<div id="feedback" class="text-left">
	<span class="text-left">Votre mot de passe doit contenir :</span><br>
  <span id="letter" class="invalid">- au moins <b>1 minuscule</b></span><br>
  <span id="capital" class="invalid">- au moins <b>1 majuscule</b></span><br>
  <span id="number" class="invalid">- au moins <b>1 chiffre</b></span><br>
  <span id="length" class="invalid">- au minimum <b>8 caractères</b></span><br>
</div>
	<?php
		if (!empty($_SESSION['errors']['username']))
		{?>
			<div class="bg-danger text-white rounded p-3 mb-3">
  			<?php echo $_SESSION['errors']['username'];?>
			</div>
	<?php
		}
		if (!empty($_SESSION['errors']['passdifferent']))
		{?>
			<div class="bg-danger text-white rounded p-3 mb-3">
  			<?php echo $_SESSION['errors']['passdifferent'];?>
			</div>
	<?php }
		if (!empty($_SESSION['errors']['email']))
		{?>
			<div class="bg-danger text-white rounded p-3 mb-3">
  			<?php echo $_SESSION['errors']['email'];?>
			</div>
	 <?php
		} ?>
<?php unset($_SESSION['errors']); ?>
<?php
	if (!empty($_SESSION['messages']['usercreated']))
	{?>
			<div class="bg-success text-white rounded p-3">
  			<?php echo $_SESSION['messages']['usercreated'];
				?>
			</div>
Pour accéder à votre compte, veuillez vous identifier :
<a href="login">cliquez ici</a>
	<?php
	}
	?>
<?php unset($_SESSION['messages']); ?>
</form>

<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>

<?php
}
else
{
  header('location: ../');
};
?>
