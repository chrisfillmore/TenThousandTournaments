<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Administrators</h3>
    </div>
    <div class="panel-body">
        <?php foreach ($admins as $id => $values) : ?>
        <p><?= $this->Html->link(
                $values['name'],
                [
                    'controller' => 'users',
                    'action' => 'view',
                    $id
                ]
                ); ?></p>
        <?php endforeach; ?>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Full Season Schedule</h3>
    </div>
    <div class="panel-body">
        <?= $this->element('schedule'); ?>
    </div>
</div>