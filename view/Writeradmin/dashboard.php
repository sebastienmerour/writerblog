<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: ../writeradmin/');
	}
	else {
?>
<?php $this->title = 'Jean Forteroche - Panneau d\'Administration'; ?>
  <!-- News -->
  <?php
  if (!empty($_SESSION['messages']['confirmation']))
            {?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['messages']['confirmation'];
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php
            }
?>
<?php unset($_SESSION['messages']); ?>
  <h2 id="lastitems">Derniers articles</h2>
  <div class="table-responsive">

  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
        <th>Utilisateur</th>
        <th>Titre</th>
        <th>Modification</th>
        <th>Suppression</th>

      </tr>
    </thead>
    <tbody>
      <?php
      while ($item = $items->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><?= $this->clean($item['date_creation_fr']); ?></h6></td>
        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?= "../user/profile/" . $this->clean($item['id_user']) ?>">
        <?= $this->clean($item['firstname']); ?>&nbsp;<?= $this->clean($item['name']);?></a></span></td>
        <td><span class="text-body newstitle"><a target="_blank" href="<?= "../item/indexuser/" . $this->clean($item['id'])?>/1">
				<h6 class="mt-2 text-left"><?= $this->clean($item['title']); ?></h6></a></span></td>
        <td><a href="<?= "readitem/" . $this->clean($item['id'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= "removeitem/" . $this->clean($item['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>

      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>

  <?php
  if ($items_current_page > $number_of_items_pages) {
  	require __DIR__ . '/../errors/items_not_found.php';
  }
  else {
  require('dashboard_pagination_items.php');}
  ?>



</div>


<?php
};
?>
