<?php
$this->layout = 'default'; 
echo $this->Html->css('register',['inline' => false]);
?>

<div id="register"><?=
    $this->Form->create(
        $user,
        [
            'class' => 'form-signin',
            'role' => 'form',
        ]); ?>

<h2>Register</h2>
<?php
    echo $this->Form->input(
            'Users.first_name',
            [
                'placeholder' => 'First Name',
                'required' => true,
                'class' => 'form-control',
                'autofocus' => true
            ]);
    echo $this->Form->input(
            'Users.last_name',
            [
                'placeholder' => 'Last Name',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->input(
            'Users.username',
            [
                'placeholder' => 'Username',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->input(
            'Users.password',
            [
                'placeholder' => 'Password',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->button(
            __('Register'),
            [
                'class' => 'btn btn-lg btn-primary btn-block'
            ]);
    echo $this->Form->end();
?>
</div>