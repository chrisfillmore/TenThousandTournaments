<?php $this->layout = 'default'; ?>

<?= $this->element('register-create'); ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Existing Leagues</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
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
    </div>
</div>
