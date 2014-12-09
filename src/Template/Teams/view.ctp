<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Current Roster</h3>
    </div>
    <div class="panel-body">
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
    </div>
</div>

