<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Create a New League</h3>
    </div>
    <div class="panel-body"><?php
        echo $this->form->create(
                $league,
                [
                    'class' => 'form-horizontal',
                    'role' => 'form'
                ]); ?>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->input(
                'Leagues.name',
                [
                    'placeholder' => 'League Name',
                    'required' => true,
                    'class' => 'form-control',
                    'label' => 'League Name'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->select(
                'Leagues.sport_id',
                $sports,
                [
                    'empty' => '(Choose a Sport)',
                    'class' => 'form-control',
                    'label' => 'Sport',
                    'required' => true
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->button(
                __('Create This League'),
                [
                    'class' => 'btn btn-success'
                ]); ?>
        </div><?php
        echo $this->Form->end(); ?>
    </div>
</div>