<?php $this->layout = 'default'; ?>

<h1><?= $user['first_name'] . ' ' . $user['last_name']; ?></h1>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Groups</h3>
    </div>
    <div class="panel-body">
        <?php foreach ($user['groups'] as $group) : ?>
        <p><?= $group['title']['name']; ?></p>
        <?php endforeach; ?>
    </div>
</div>