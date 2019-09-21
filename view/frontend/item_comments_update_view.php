<?php $title = 'Mon blog'; ?>
<?php ob_start(); ?>


<!-- Title -->
<h1 class="mt-4 text-left"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></h1>

<!-- Author -->
<span class="lead">publié par <a href="<?php echo BASE_URL; ?>user/user.php?id_user=';?><?php echo $item['id_user']?>">
  <?php echo htmlspecialchars(strip_tags($item['firstname'])); ?><?php echo '&nbsp;' ?><?php echo htmlspecialchars(strip_tags($item['name']));?></a></span>
  <br>

<!-- Date et Heure de Publication -->
<em>le <?php echo $item['date_creation_fr']; ?></em>


<hr>

<!-- Image du Post -->
<figure class="figure">
<img src="<?php echo BASE_URL; ?>public/images/item_images/';?><?php echo htmlspecialchars(strip_tags($item['image']));?>" class="figure-img img-fluid rounded-right"
alt="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>" title="<?php echo htmlspecialchars(strip_tags($item['title'])); ?>">
<figcaption class="figure-caption text-right"><?php echo htmlspecialchars(strip_tags($item['title'])); ?></figcaption>
</figure>

<hr>

<!-- Item  -->
<p class="lead"><?php echo nl2br(htmlspecialchars(strip_tags($item['content']))); ?></p>

<blockquote class="blockquote">
  <p class="mb-0">"Citation."</p>
  <footer class="blockquote-footer">Victor Hugo
    <cite title="Source Title">Le Monde</cite>
  </footer>
</blockquote>

<hr>
<h2 id="comments">Commentaires</h2>



<?php
  // Préparation de la Pagination des commentaires
    $db = dbConnect();
    $reponse = $db->prepare('SELECT COUNT(*) as nb_comm FROM comments WHERE id_item = ? ');
    $reponse->execute(array($_GET['id'])) or die(print_r($bdd->errorInfo()));
    $datas = $reponse->fetch();
    $nbComm = $datas['nb_comm'];
    $parPage = 5;
    $nbPage = ceil($nbComm/$parPage);

    if(isset($_GET['page']))
    {
      $pageCourante = $_GET['page'];
    }
    else
    {
      $pageCourante = 1;
    }

    $debut = ($pageCourante - 1) * $parPage;
    $fin = $debut + $parPage;

    $reponse->closeCursor();
  ?>

  <?php
  // Pagination des commentaires
  if ($pageCourante > $nbPage) {
      echo('');
  }
  else {

  for($i = 1; $i <= $nbPage; $i++)
  {
    if($i == $pageCourante)
    {
  echo '<div class="btn btn-outline-secondary disabled">'.$i.' </div>';
    }
    else
    {
  echo ' <a class="btn btn-outline-primary" href="?action=readitem&id='.$_GET['id'].'&page='.$i.'#comments">'.$i.'</a> ';
    }
  }
  };

  if ($pageCourante < $nbPage)
  {
  echo ' <a class="btn btn-outline-secondary" href="?action=readitem&id='.$_GET['id'].'&page='. ($pageCourante + 1) .'
  #comments" aria-label="Next"><span aria-hidden="true">&raquo;</span></a> ';
  };


  ?>








<!--  Vérifier si des commentaires existent : -->
<?php if(isset($_GET['page']))
{
  $pageCourante = $_GET['page'];
}
else
{
  $pageCourante = 1;
}
?>
<?php

$db = dbConnect();
$reponse = $db->prepare('SELECT COUNT(*) as nb_comm FROM comments WHERE id_item = ? ');
$reponse->execute(array($_GET['id']));
$datas = $reponse->fetch();
$nbComm = $datas['nb_comm'];
$parPage = 5;
$nbPage = ceil($nbComm/$parPage);

if(isset($_GET['page']))
{
  $pageCourante = $_GET['page'];
}
else
{
  $pageCourante = 1;
}

$debut = ($pageCourante - 1) * $parPage;
$fin = $debut + $parPage;



$req_comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\')
AS date_comment_fr
FROM comments WHERE id_item = ? ORDER BY date_comment DESC LIMIT ?, ?');
//$req_comments->execute(array($item_id, $debut, $parPage));
//$comments = $req_comments->fetch();
//return $comments;

$req_comments->bindParam(1, $_GET['id'], PDO::PARAM_INT);
$req_comments->bindParam(2, $debut, PDO::PARAM_INT);
$req_comments->bindParam(3, $parPage, PDO::PARAM_INT);
$req_comments->execute();
if ($nbComm == 0) {
  echo '<div class="btn btn-outline-secondary disabled">Il n\'y a aucun commentaire</div>';
    }
else {

      while ($comment = $req_comments->fetch())
            {
      ?>


          <!-- Commentaires  -->
          <!-- Mise à jour du Commentaire :  -->
          <?php
                  // Si l'utilisateur a cliqué sur le bouton "submit" relié au name "modify"
                  // on lance le process de modification de commentaire :
                  if(isset($_POST['modify'])) {
                      $messages = array();
                      $newcomment = !empty($_POST['newcomment']) ? trim($_POST['newcomment']) : null;
                      $id_item = $_GET['id'];

                      $commentupdate = $bdd->prepare('UPDATE comments
                      SET comment = :comment
                      WHERE id_item= :id_item');
                      $userupdate->execute(array(
                        ':comment' => htmlspecialchars($newcomment),
                        ':id_item' => htmlspecialchars($id_item)
                      ));

                    // Ici on affiche le message de confirmation :
                    $messages['commentupdated'] = 'Le commentaire a bien été modifié !';
?>

          <hr>
          <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="public/images/default/50x50.png" alt="user">
            <div class="media-body">
              <h5 class="mt-0"><?php echo htmlspecialchars($comment['author'], ENT_QUOTES, 'UTF-8'); ?></h5><em>le
                <?php echo $comment['date_comment_fr']; ?></em><br>

                <form role="form" class="form needs-validation" action="user_update.php" method="post" id="usermodification" novalidate>
                  <p>&nbsp;</p>

                  <div class="form-group">
                      <div class="col-xs-6">
                          <input type="text" class="form-control" name="commentcontent" id="commentcontent" value="<?php $comment['comment'] ?>"
                          title="Modifiez votre commentaire si besoin">
                      </div>
                  </div>
                  <div class="form-group">
      								 <div class="col-xs-12">
      											<br>
      											<button class="btn btn-md btn-success" name="modify" type="submit"> Enregistrer</button>
      											<a href="#"><button class="btn btn-md btn-secondary" type="reset"> Annuler</button></a>
      											<a href="item_comments_view.php"><button class="btn btn-md btn-primary" type="button"> Retour</button></a>
      									</div>
      						</div>

                </form>

            </div>
          </div>
        <?php
        //}
      }
    }
        ?>

<!-- Ajout  de nouveaux commentaires : -->
<hr>
<div class="card my-4">
  <h5 class="card-header">Ajoutez un nouveau commentaire :</h5>
    <div class="card-body">
      <form action="index.php?action=createcomment&amp;id=<?= $item['id'] ?>" method="post">
            <div class="form-group">
                        <input class="form-control" id="author" name="author" type="text" placeholder="Identifiant"><br>
                        <textarea class="form-control" id="comment" name="comment" rows="6" placeholder="Ecrivez ici votre commentaire"></textarea>
            </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>
  </div>
<!-- Fin de l'item -->
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
