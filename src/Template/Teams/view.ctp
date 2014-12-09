<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Next Games</h3>
    </div>
    <div class="panel-body"><?php
    if ($games)
         echo $this->element('schedule');
    else { ?>
        <p>No upcoming games.</p><?php
    } ?>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Current Roster</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <tr>
                <th style="width: 5%; text-align: right;">#</th>
                <th>Player Name</th>
            </tr>
            <?php foreach ($team['players'] as $player) : ?>
            <tr>
                <td style="width: 5%; text-align: right;">
                    <?= $player['jersey_number']; ?>
                </td>
                <td><?= $this->Html->link(
                        $player['user']['first_name'] . ' ' . $player['user']['last_name'],
                        [
                            'controller' => 'users',
                            'action' => 'view',
                            $player['id']
                        ]
                        );
                    if ($player['id'] == $team['rep']['id']) { ?>
                    &nbsp;<span class="label label-primary">Rep</span><?php
                    } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

