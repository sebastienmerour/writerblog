<?php
$title = "Connexion"; ?>
<?php ob_start(); ?>
<!-- Connexion -->
    <form class="form-signin" method="post" action="<?php echo BASE_URL; ?>user/?action=logincheck">
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


    <?php if(!empty($_SESSION['errMsg'])) {?>
      <div class="bg-danger text-white rounded p-2" id="errMsg">
        <?php echo $_SESSION['errMsg']; } ?>
      </div>
    <?php unset($_SESSION['errMsg']); ?>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2019</p>
  </form>
  <?php $content = ob_get_clean(); ?>
  <?php require __DIR__ . '/template_login.php'; ?>