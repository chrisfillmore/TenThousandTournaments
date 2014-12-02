<?php $this->layout = 'default'; ?>

<h1>Sports</h1>

<div class="list-group">
    <?php foreach ($sports as $sport) : ?>
    <a class="list-group-item" href="#">
        <h4 class="list-group-item-heading"><?= $sport['name']; ?></h4>
        <?php foreach ($sport['leagues'] as $league) : ?>
        <p class="list-group-item-text"><?= $league['name']; ?></p>
        <?php endforeach; ?>
    </a>
    
    <?php endforeach; ?>
</div>