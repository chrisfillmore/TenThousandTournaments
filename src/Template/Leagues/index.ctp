<h1>Leagues</h1>
<table>
    <tr>
        <th>Sport</th>
        <th>League Name</th>
    </tr>
    
    <?php foreach ($leagues as $league) : ?>
    <tr>
        <td><?php echo $league['sport']['name']; ?></td>
        <td><?php echo $this->Html->link(
                $league['name'],
                array(
                    'controller' => 'leagues',
                    'action' => 'view',
                    $league['id']
                    )
                ); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($league); ?>
</table>