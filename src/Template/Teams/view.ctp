<?php $this->layout = 'default'; ?>

<h1><?= $team['name']; ?></h1>

<table class="table table-striped">
    <tr>
        <th>Player Name</th>
    </tr>
    <?php foreach ($team['players'] as $player) : ?>
    <tr>
        <td><?php echo $this->Html->link(
                $player['user']['first_name'] . ' ' . $player['user']['last_name'],
                [
                    'controller' => 'users',
                    'action' => 'view',
                    $player['id']
                ]
                ); ?></td>
    </tr>
    <?php endforeach; ?>
</table>