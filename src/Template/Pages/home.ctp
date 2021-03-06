<?php $this->layout = 'default'; ?>

<div class="jumbotron">
    <h1>The premier solution for sports league management online</h1>
    <p>Ten Thousand Tournaments is the scaleable sports league management system.</p>
</div>

<div class="row">
    <div class="col-md-4">
        <h2>Leagues</h2>
        <p>Ten Thousand Tournaments provides all the tools you need to support your league.</p>
        <p><a class="btn btn-info" role="button" href="<?= $this->Url->build([
            'controller' => 'leagues'
            ]); ?>">Learn more &raquo;</a></p>
    </div>
    <div class="col-md-4">
        <h2>Teams</h2>
        <p>Is your team looking for a League? Ten Thousand Tournaments has leagues for many sports.</p>
        <p><a class="btn btn-info" role="button" href="<?= $this->Url->build([
            'controller' => 'sports'
            ]); ?>">Learn more &raquo;</a></p>
    </div>
    <div class="col-md-4">
        <h2>Players</h2>
        <p>Are you looking for a team to join? Many leagues offer registration options for individual players.</p>
        <p><a class="btn btn-info" role="button" href="<?=$this->Url->build([
            'controller' => 'users',
            'action' => 'add'
            ]); ?>">Learn more &raquo;</a></p>
    </div>
</div>


