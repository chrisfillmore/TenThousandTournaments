<div class="well">
    <p>Registering a new team with Ten Thousand Tournaments is easy as can be. 
        Can't find the league you're looking for? Create a new one!</p>
    <a class="btn btn-lg btn-primary" role="button" href="<?= $this->Url->build([
        'controller' => 'teams',
        'action' => 'add'
        ]); ?>">Register a New Team</a>&nbsp;&nbsp;
    <a class="btn btn-lg btn-success" role="button" href="<?= $this->Url->build([
        'controller' => 'leagues',
        'action' => 'add'
        ]); ?>">Create a New League</a>   
</div>