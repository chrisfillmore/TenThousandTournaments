<h1>
    <?php echo $league['League']['name']; ?>
</h1>

<p>
    This is a <?php echo strtolower($league['Sport']['name']); ?> league.
</p>

<p>
    This league has <?php echo count($league['Admin']); ?> administrators:
</p>
<ul>
    <?php foreach ($league['Admin'] as $admin) : ?>
    <li>
        <?php echo $this->Html->link(
        $admin['User']['first_name'] . ' ' . $admin['User']['last_name'],
        array(
            'controller' => 'users',
            'action' => 'view',
            $admin['User']['id']
            )
        ); ?>
        <ul>
            <?php foreach ($admin['Title'] as $title) : ?>
            <li>
                <?php echo $title['name']; ?>
            </li>
            <?php endforeach; ?>
            <?php unset($title); ?>
        </ul>
    </li>
    <?php endforeach; ?>
    <?php unset($admin); ?>
</ul>

<p><?php echo $league['League']['name']; ?> has played <?php echo count($league['Season']); ?> 
seasons:</p>
<ul>
    <?php foreach ($league['Season'] as $season) : ?>
    <li><?php echo $this->Html->link($season['year'],
        array('controller' => 'seasons', 'action' => 'view', $season['id'])); ?></li>
    <?php endforeach; ?>
    <?php unset($season); ?>
</ul>
<pre><?php echo var_dump($league); ?></pre>
<pre><?php //echo var_dump($test); ?></pre>