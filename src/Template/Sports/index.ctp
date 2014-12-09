<?php $this->layout = 'default'; ?>

<?= $this->element('register-create'); ?>

<div class="list-group">
    <?php foreach ($sports as $sport) : ?>
    <a class="list-group-item" href="<?= $this->Url->build(
            [
                'controller' => 'sports',
                'action' => 'view',
                $sport['id']
            ]
            ); ?>">
        <h4 class="list-group-item-heading"><?= $sport['name']; ?></h4>
        <?php foreach ($sport['leagues'] as $league) : ?>
        <p class="list-group-item-text"><?= $league['name']; ?></p>
        <?php endforeach; ?>
    </a>
    
    <?php endforeach; ?>
</div>