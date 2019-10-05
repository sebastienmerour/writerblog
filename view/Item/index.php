<?php $this->title = 'Jean Forteroche | écrivain et acteur | Blog' . $this->clean($item['title']); ?>

<article>
    <header>
        <h1 class="titreBillet"><?= $this->clean($item['title']) ?></h1>
        <time><?= $this->clean($item['date']) ?></time>
    </header>
    <p><?= $this->clean($item['content']) ?></p>
</article>
<hr />
<header>
    <h1 id="titreReponses">Réponses à <?= $this->clean($item['title']) ?></h1>
</header>
<?php foreach ($comments as $comment): ?>
    <p><?= $this->clean($comment['author']) ?> dit :</p>
    <p><?= $this->clean($comment['content']) ?></p>
<?php endforeach; ?>
<hr />
<form method="post" action="item/comment">
    <input id="author" name="author" type="text" placeholder="Votre pseudo"
           required /><br />
    <textarea id="txtComment" name="content" rows="4"
              placeholder="Votre commentaire" required></textarea><br />
    <input type="hidden" name="id" value="<?= $item['id'] ?>" />
    <input type="submit" value="Comment" />
</form>
