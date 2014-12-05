<?php
$this->layout = 'default'; 
echo $this->Html->css('register',['inline' => false]);
?>

<?php
    echo $this->Form->create(
        $user,
        [
            'class' => 'form-signin',
            'role' => 'form'
        ]); ?>
<h2>Register</h2>
<?php
    echo $this->Form->input(
            'Users.username',
            [
                'placeholder' => 'Username',
                'required' => true,
                'class' => 'form-control',
                'autofocus' => true
            ]);
    echo $this->Form->input(
            'Users.password',
            [
                'placeholder' => 'Password',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->input(
            'confirmPassword',
            [
                'placeholder' => 'Confirm Password',
                'required' => true,
                'class' => 'form-control'
            ]);
    echo $this->Form->button(
            __('Register'),
            [
                'class' => 'btn btn-lg btn-primary btn-block',
                'style' => $this->Html->style(
                        [
                            'margin-top' => '20px'
                        ])
            ]);
    echo $this->Form->end();
?>