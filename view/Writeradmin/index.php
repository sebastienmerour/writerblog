<?php
	if(ISSET($_SESSION['id_user_admin'])){
    header('location: ../writeradmin/dashboard');
	}
	else {
?>
<?php $this->title = 'Connexion à l\'Administration du blog'; ?>

<?php require __DIR__ . '/../errors/errors.php'; ?>

<div>
  <form class="form-signin" method="post" action="../login/loginadmin">
  <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
  <label for="username" class="sr-only">Identifiant</label>
  <input type="text" id="username" name="username" class="form-control" placeholder="Identifiant" value="<?php if(ISSET($_COOKIE['username'])){echo $_COOKIE['username'];}?>" required autofocus>
  <label for="password" class="sr-only">Mot de passe</label>
  <input type="password" id="pass" name="pass" class="form-control" placeholder="Mot de passe" value = "<?php if(ISSET($_COOKIE['pass'])){echo $_COOKIE['pass'];}?>" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" id="rememberme" name="rememberme" <?php if(ISSET($_COOKIE['username'])){echo 'checked';}?>> Connexion automatique
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Se connecter</button>
  <p>&nbsp;</p>
</form>
</div>
<?php
};
?>
