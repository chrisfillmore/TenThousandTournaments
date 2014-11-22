<h1>
    <?php echo $league['name']; ?>
</h1>

<p>
    This is a <?php echo strtolower($league['sport']['name']); ?> league.
</p>

<p>
    This league has <?php echo count($admins); ?> administrators:
</p>
<ul>
    <?php foreach ($admins as $id => $admin) : ?>
    <li>
        <?php echo $this->Html->link(
        $admin['name'],
        array(
            'controller' => 'users',
            'action' => 'view',
            $id
            )
        ); ?>
        <ul>
            <?php foreach ($admin['roles'] as $role) : ?>
            <li>
                <?php echo $role; ?>
            </li>
            <?php endforeach;
            unset($role); ?>
        </ul>
    </li>
    <?php endforeach; ?>
    <?php unset($admin); ?>
</ul>

<p><?php echo $league['name']; ?> has played <?php echo count($league['seasons']); ?> 
seasons:</p>
<ul>
    <?php foreach ($league['seasons'] as $season) : ?>
    <li><?php echo $this->Html->link(
            $season['year'],
            array(
                'controller' => 'seasons',
                'action' => 'view',
                $season['id']
                )
            ); ?></li>
    <?php endforeach; ?>
    <?php unset($season); ?>
</ul>