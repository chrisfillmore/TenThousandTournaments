<li class="divider"></li>
<li class="dropdown-header">Manage</li><?php
foreach ($adminNav as $link) : ?>
<li><?= $this->Html->link(
    $link['name'], [
        'controller' => $link['controller'],
        'action' => 'edit',
        $link['id']
    ]); ?>
</li>
<?php endforeach; ?>
