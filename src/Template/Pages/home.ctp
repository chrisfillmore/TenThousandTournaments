<?php $this->layout = 'default'; ?>

<div class="jumbotron">
    <h1>Your solution for sports league management</h1>
    <p>Ten Thousand Tournaments is the scaleable sports league management system.</p>
</div>

<div class="row">
    <div class="col-md-4">
        <h2>Leagues</h2>
        <p>Ten Thousand Tournaments provides all the tools you need to support your league.</p>
        <p><a class="btn btn-info" role="button" href="<?= $this->Url->build([
            'controller' => 'leagues',
            'action' => 'view'
            ]); ?>">Learn more &raquo;</a></p>
    </div>
    <div class="col-md-4">
        <h2>Teams</h2>
        <p>Is your team looking for a League? Ten Thousand Tournaments has leagues for many sports.</p>
        <p><a class="btn btn-info" role="button" href="<?= $this->Url->build([
            'controller' => 'sports',
            'action' => 'view'
            ]); ?>">Learn more &raquo;</a></p>
    </div>
    <div class="col-md-4">
        <h2>Players</h2>
        <p>Are you looking for a team to join? Many leagues offer registration options for individual players.</p>
        <p><a class="btn btn-info" role="button" href="<?=$this->Url->build([
            'controller' => 'sports',
            'action' => 'view'
            ]); ?>">Learn more &raquo;</a></p>
    </div>
</div>

