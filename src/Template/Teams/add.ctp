<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Register a New Team</h3>
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
                    'required' => true,
                    'class' => 'form-control',
                    'label' => 'Team Name'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->select(
                'Teams.league_id',
                $leagues,
                [
                    'empty' => '(Choose a League)',
                    'class' => 'form-control',
                    'label' => 'League',
                    'required' => true
                ]); ?>
        </div>
        <div style="display: none;"><?php
        echo $this->Form->text(
                'Teams.rep_id',
                [
                    'value' => $userLoggedIn,
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->button(
                __('Register'),
                [
                    'class' => 'btn btn-success'
                ]); ?>
        </div><?php
        echo $this->Form->end(); ?>
    </div>
</div>