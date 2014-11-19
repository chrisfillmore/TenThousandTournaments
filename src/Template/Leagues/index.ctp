<h1>Leagues</h1>
<table>
    <tr>
        <th>Sport</th>
        <th>League Name</th>
    </tr>
    
    <?php foreach ($leagues as $league) : ?>
    <tr>
        <td><?php echo $league['Sport']['name']; ?></td>
        <td><?php echo $this->Html->link($league['League']['name'],
            array('controller' => 'leagues', 'action' => 'view',
                $league['League']['id'])); ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($league); ?>
</table>
<pre><?php echo var_dump($leagues); ?></pre>