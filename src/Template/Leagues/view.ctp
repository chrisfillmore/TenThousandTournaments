<?php $this->layout = 'default'; ?>

<h1>
    <?php echo $league['name']; ?>
</h1>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Sport</h3>
    </div>
    <div class="panel-body">
        <p><?= $league['sport']['name']; ?></p>
    </div>
</div>

<div class="panel panel-primary">
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

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Seasons</h3>
    </div>
    <div class="panel-body">
        <?php foreach ($seasons as $id => $values) : ?>
        <p><?= $this->Html->link(
                $values['year'],
                [
                    'controller' => 'seasons',
                    'action' => 'view',
                    $id
                ]
                ); ?></p>
        <?php endforeach; ?>
    </div>
</div>