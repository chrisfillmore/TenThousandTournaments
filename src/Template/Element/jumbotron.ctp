<div class="jumbotron">
    <h1>Your solution for sports league management</h1>
    <p>Ten Thousand Tournaments is the scaleable sports league management system.</p>
    <p>Learn more about our...</p>
    <p><?php
        echo $this->Html->link(
                'Sports',
                [
                    'controller' => 'sports',
                    'action' => 'index'
                ],
                [
                    'class' => 'btn btn-primary btn-lg',
                    'role' => 'button'
                ]
            );
        echo '&nbsp;';
        echo $this->Html->link(
                'Leagues',
                [
                    'controller' => 'leagues',
                    'action' => 'index'
                ],
                [
                    'class' => 'btn btn-primary btn-lg',
                    'role' => 'button'
                ]
            );
        ?>    
    </p>
</div>