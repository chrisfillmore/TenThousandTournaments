<table class="table table-striped">
    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Home Team</th>
        <th>Away Team</th>
        <th>Location</th>
    </tr>
    <?php foreach ($games as $game) : ?>
    <tr>
        <td><?= date('Y-m-d', strtotime($game['date_time'])); ?></td>
        <td><?= date('G:i', strtotime($game['date_time'])); ?></td>
        <td><?= $this->Html->link(
                    $game['home_team']['name'],
                    [
                        'controller' => 'teams',
                        'action' => 'view',
                        $game['home_team']['id']
                    ]
                ); ?>
        </td>
        <td><?= $this->Html->link(
                    $game['away_team']['name'],
                    [
                        'controller' => 'teams',
                        'action' => 'view',
                        $game['away_team']['id']
                    ]
                ); ?>
        </td>
        <td><?= $this->Html->link(
                $game['location']['name'],
                [
                    'controller' => 'locations',
                    'action' => 'view',
                    $game['location']['id']
                ]); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>