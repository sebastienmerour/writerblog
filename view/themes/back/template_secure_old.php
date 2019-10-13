<?php require('template_header.php'); ?>
<?php require('template_nav.php'); ?>

<!-- Page Content -->
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="<?php echo BASE_URL; ?>writeradmin/index.php#home">
              <span data-feather="home"></span>
              Accueil <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>writeradmin/?action=additem">
              <span data-feather="edit"></span>
              Ecrire un article
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>writeradmin/index.php#lastitems">
              <span data-feather="book-open"></span>
              Derniers Articles
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>writeradmin/index.php#tomoderate">
              <span data-feather="filter"></span>
              Commentaires signalés
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>writeradmin/index.php#allcomments">
              <span data-feather="message-square"></span>
              Tous les commentaires
            </a>
          </li>
          <li class="nav-item">
              <hr>
              <div class="m-3">~ Jean Forteroche, acteur et écrivain ~ © 2019</div>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 id="home" class="h2">Administration du Blog</h1>
        <div class="btn-toolbar mb-3 mb-md-0">
          <div class="btn-group mr-2">
            <a href="<?php echo BASE_URL; ?>writeradmin/?action=additem" role="button" class="btn btn-sm btn-success">Ecrire un article</a>
          </div>
        </div>
      </div>

        <?php echo $content; ?>





    </main>
  </div>
</div>
<?php require('template_footer.php'); ?>
