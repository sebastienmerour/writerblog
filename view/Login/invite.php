<?php $this->title = 'Connectez-vous'; ?>

<div>
<!-- Bienvenue -->
<h1 class="mt-4">Bonjour !</h1>
<hr>

<!-- Confirmation -->
<div class="container">
  <div class="row">
    <p>Vous n'êtes pas connectés. &nbsp;</p>
    <p>Pour vous connecter, <a href="login">cliquez ici</a></p>
  </div>
</div>
<hr>
</div>
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
Le blog contient '. $number_of_items_pages.' pages<br>'; ?>
