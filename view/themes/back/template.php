<?php require('template_header.php'); ?>

<?php require('template_nav.php'); ?>
<!-- Page Content -->
<div class="container-fluid">
  <div class="row">
    <?php if(ISSET($_SESSION['id_user_admin']))
              {
         require('template_sidebar_login.php'); }
         else {
         }?>

<div class="main container">
  <div class="row container">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 id="home" class="h2">Administration du Blog</h1>
        <div class="btn-toolbar mb-3 mb-md-0">
          <div class="btn-group mr-2">
            <?php if(ISSET($_SESSION['id_user_admin'])){?>
            <a href="<?php echo BASE_URL; ?>writeradmin/additem" role="button" class="btn btn-sm btn-success">Ecrire un article</a>
          <?php } else {}?>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        	<?php echo $content; ?>
      </div>
    </main>
  </div>
</div>
</div>
</div>

<?php require('template_footer.php'); ?>
