<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->Html->link(
                $team['name'],
                [
                    'controller' => 'teams',
                    'action' => 'view',
                    $team['id']
                ]); ?>
        </h3>
    </div>
    <div class="panel-body"><?= $this->element('schedule'); ?></div>
</div>


