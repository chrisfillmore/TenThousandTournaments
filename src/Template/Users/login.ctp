<?php
$this->layout = 'default'; 
echo $this->Html->css('register',['inline' => false]);
?>

<div id="register">
<?php 
    echo $this->Flash->render('auth');
    echo $this->Form->create(
        $user,
        [
            'class' => 'form-signin',
            'role' => 'form',
        ]); ?>

<h2>Log in</h2>
<?php
    echo $this->Form->input(
            'username',
            [
                'placeholder' => 'Username',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->input(
            'password',
            [
                'placeholder' => 'Password',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->button(
            __('Login'),
            [
                'class' => 'btn btn-lg btn-success btn-block'
            ]);
    echo $this->Form->end();
?>
</div>