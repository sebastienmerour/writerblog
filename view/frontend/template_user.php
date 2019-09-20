<?php require('template_header.php'); ?>
<?php require('template_nav.php'); ?>

<!-- Page Content -->
<div class="main container">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">
			<?php echo $content; ?>

      <?php require('statistiques_items_view.php');?>
    </div><!-- Fin du div col-md-4 -->

  </div><!-- Fin du div row -->

</div><!-- Fin du div container -->

<?php require('template_footer.php'); ?>
