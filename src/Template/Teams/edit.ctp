<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Edit <?= $team['name']; ?></h3>
    </div>
    <div class="panel-body"><?php
        echo $this->form->create(
                $team,
                [
                    'class' => 'form-horizontal',
                    'role' => 'form'
                ]); ?>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->input(
                'Teams.name',
                [
                    'placeholder' => 'Team Name',
                    'value' => $team['name'],
                    'required' => true,
                    'class' => 'form-control',
                    'label' => 'Team Name'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->button(
                __('Update Team'),
                [
                    'class' => 'btn btn-success'
                ]); ?>
        </div><?php
        echo $this->Form->end(); ?>
    </div>
</div>