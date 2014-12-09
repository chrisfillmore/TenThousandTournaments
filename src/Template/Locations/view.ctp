<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Address</h3>
    </div>
    <div class="panel-body">
        <p><?= $location['address']; ?></p>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Games at <?= $location['name']; ?></h3>
    </div>
    <div class="panel-body">
        <?= $this->element('schedule'); ?>
    </div>
</div>