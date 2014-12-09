<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">The following leagues are available for this sport:</h3>
    </div>
    <div class="panel-body">
        <table class="table"><?php
            foreach ($sport['leagues'] as $league) : ?>
            <tr>
                <td><?=
                $this->Html->link(
                        $league['name'],
                        [
                            'controller' => 'leagues',
                            'action' => 'view',
                            $league['id'],
                            
                        ]);?>
                </td>
            </tr><?php
             endforeach; ?>
        </table>
    </div>
</div>