<?php $this->layout = 'default'; ?>

<h1><?php echo $season['year']; ?> Season Schedule</h1>

<table class="table table-striped">
    <tr>
        <th>Date & Time</th>
        <th>Home Team</th>
        <th>Away Team</th>
    </tr>
    <?php foreach ($games as $game) : ?>
    <tr>
        <td><?= date('Y-m-d H:i', strtotime($game['date_time'])); ?></td>
        <td><?php echo $this->Html->link(
                    $game['home_team']['name'],
                    [
                        'controller' => 'teams',
                        'action' => 'view',
                        $game['home_team']['id']
                    ]
                ); ?></td>
        <td><?php echo $this->Html->link(
                    $game['away_team']['name'],
                    [
                        'controller' => 'teams',
                        'action' => 'view',
                        $game['away_team']['id']
                    ]
                ); ?></td>
    </tr>
    <?php endforeach; ?>
</table>