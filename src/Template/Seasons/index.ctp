<h1>Seasons</h1>
<table>
    <tr>
        <th>id</th>
        <th>Year</th>
        <th>League</th>
        <th>Team</th>
        <th>Player</th>
    </tr>
    
    <?php foreach ($seasons as $season) : ?>
    <tr>
        <td><?php echo $this->Html->link(
                $season['id'],
                array(
                    'controller' => 'seasons',
                    'action' => 'view',
                    $season['id']
                    )
                ); ?></td>
        <td><?php echo $season['year']; ?></td>
        <td><?php echo $season['league']; ?></td>
        <td><?php echo $season['team']; ?></td>
        <td><?php echo $season['player']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($league); ?>
</table>