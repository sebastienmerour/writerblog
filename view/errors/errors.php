<?php
if (!empty($_SESSION['errors']['errors'])) {
?>
   <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Erreur !</strong> <?= $_SESSION['errors']['errors']; ?>
   </div>
    <?php
}
?>
<?php
if (!empty($_SESSION['errors']['loginfailed'])) {
?>
       <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong>Erreur !</strong> <?= $_SESSION['errors']['loginfailed']; ?>
       </div>
    <?php
}
?>
<?php
if (!empty($_SESSION['errors']['username'])) {
?>
   <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Erreur !</strong> <?= $_SESSION['errors']['username']; ?>
   </div>
<?php
}
if (!empty($_SESSION['errors']['passdifferent'])) {
?>
<div class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <strong>Erreur !</strong> <?= $_SESSION['errors']['passdifferent']; ?>
   </div>
<?php
}
if (!empty($_SESSION['errors']['email'])) {
?>
<div class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <strong>Erreur !</strong> <?= $_SESSION['errors']['email']; ?>
   </div>
 <?php
}
?>

<?php
unset($_SESSION['errors']);
?>
