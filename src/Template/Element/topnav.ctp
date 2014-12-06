<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" 
                    data-toggle="collapse" data-target="#navbar" 
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button><?php
            if ($nav['heading']) {
                echo $this->Html->link(
                    $nav['heading'],
                    [
                        'controller' => $nav['controller'],
                        'action' => $nav['action'],
                        $nav['id']
                    ],
                    ['class' => 'navbar-brand']
                );
            } ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" role="form">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Username" autocomplete="off"></input>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Password" autocomplete="off"></input>
                </div>
                <button class="btn btn-success" type="submit">Sign in</button>
                <a class="btn btn-primary" role="button" href="<?= $this->Url->build([
                    'controller' => 'users',
                    'action' => 'add'
                    ]); ?>">Register</a>
            </form>
        </div>
    </div>
</nav>