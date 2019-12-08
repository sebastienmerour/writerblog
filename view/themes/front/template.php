<?php require('template_header.php'); ?>
<?php require('template_nav.php'); ?>

<!-- Page Content -->
<div class="main container">
  <div class="row container">

    <!-- Post Content Column -->
    <div class="col-lg-8">
			<?= $content ?>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
      <?php if(!ISSET($_SESSION['id_user']))
                {
			     require('template_my_account_login.php'); }
           else {
             require('template_my_account_logout.php');
           }?>
			<?php require('template_statistiques_items.php')?>
    </div><!-- Fin du div col-md-4 -->

  </div><!-- Fin du div row -->


</div><!-- Fin du div container -->
<?php require('template_footer.php'); ?>
