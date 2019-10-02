<?php $this->title = "Mon Blog"; ?>

<?php foreach ($items as $item):
    ?>
    <article>
        <header>
            <a href="<?= "item/index/" . $this->clean($item['id']) ?>">
                <h1 class="titleItem"><?= $this->clean($item['title']) ?></h1>
            </a>
            <time><?= $this->clean($item['date_creation_fr']) ?></time>
        </header>
        <p><?= $this->clean($item['content']) ?></p>
    </article>
    <hr />
<?php endforeach; ?>
