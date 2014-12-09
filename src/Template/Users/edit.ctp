<?php $this->layout = 'default'; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Edit your Profile</h3>
    </div>
    <div class="panel-body"><?php
        echo $this->form->create(
                $user,
                [
                    'class' => 'form-horizontal',
                    'role' => 'form'
                ]); ?>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->input(
                'Users.first_name',
                [
                    'placeholder' => 'First Name',
                    'value' => $user['first_name'],
                    'required' => true,
                    'class' => 'form-control'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->input(
                'Users.last_name',
                [
                    'placeholder' => 'Last Name',
                    'value' => $user['last_name'],
                    'required' => true,
                    'class' => 'form-control'
                ]); ?>
        </div>
        <div class="col-sm-10 form-group"><?php
        echo $this->Form->button(
                __('Update Profile'),
                [
                    'class' => 'btn btn-success'
                ]); ?>
        </div><?php
        echo $this->Form->end(); ?>
    </div>
</div>