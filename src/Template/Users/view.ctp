<?php $this->layout = 'default'; ?>

<?php foreach ($userInfo as $group) : ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $group['name']; ?></h3>
    </div>
    <div class="panel-body">
        <?php foreach ($group['values'] as $id => $name) : ?>
        <p><?= $this->Html->link(
                $name,
                [
                    'controller' => $group['controller'],
                    'action' => 'view',
                    $id
                ]
                ); ?></p>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>