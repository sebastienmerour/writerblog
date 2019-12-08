<?php if(!empty($_SESSION['errors'])) : ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Erreur !</strong> <?= $_SESSION['errors']['errors']; ?>
    </div>
<?php unset($_SESSION['errors']); ?>
<?php endif; ?>
