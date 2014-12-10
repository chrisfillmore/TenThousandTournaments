<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Edit <?= $league['name']; ?></h3>
    </div>
    <div class="panel-body"><?php
        echo $this->form->create(
                $league, [
                    'class' => 'form-horizontal',
                    'role' => 'form'
                ]); ?>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->input(
                'Leagues.name', [
                    'placeholder' => 'League Name',
                    'value' => $league['name'],
                    'required' => true,
                    'class' => 'form-control',
                    'label' => 'League Name'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->input(
                'Leagues.is_active', [
                    'type' => 'checkbox',
                    'checked' => (bool)$league['is_active'],
                    'label' => 'Activate League'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->button(
                __('Update League'), [
                    'class' => 'btn btn-success'
                ]); ?>
        </div><?php
        echo $this->Form->end(); ?>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Manage League</h3>
    </div>
    <div class="panel-body">
        <a class="btn btn-info" role="button" href="<?=$this->Url->build([
            'controller' => 'seasons',
            'action' => 'add',
            '?' => ['league' => $league['id']]
            ]); ?>">Create a New Season</a>
    </div>
</div>

<?php if ($currentSeason) : ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Current Season: <?= $currentSeason['year']; ?></h3>
    </div>
    <div class="panel-body">
        <?php if ($currentSeason['teams']) : ?>
        
        <table class="table table-striped">
            <tr>
                <th>Teams</th>
            </tr>
            <?php foreach ($currentSeason['teams'] as $team) : ?>
            <tr>
                <td><?= $this->Html->link(
                            $team['name'], [
                                'controller' => 'teams',
                                'action' => 'view',
                                $team['id']
                            ]
                        ); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <?php else : ?>
        <p>No teams registered for this season.</p>
        <?php endif; ?>
    </div>
</div>

<?php endif; ?>