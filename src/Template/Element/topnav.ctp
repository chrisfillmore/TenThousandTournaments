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
            <?php if ($loggedIn) : ?>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form navbar-right" role="form">
                        <button class="btn btn-success" href="<?=
                        $this->Url->build([
                            'controller' => 'users',
                            'action' => 'logout'
                        ]); ?>">Log out
                        </button>
                    </form>
                </li>
            </ul>
            <?php else : ?>
            <form class="navbar-form navbar-right" role="form" action="<?=
            $this->Url->build([
                'controller' => 'users',
                'action' => 'login'
            ]); ?>">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Username" autocomplete="off"></input>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Password" autocomplete="off"></input>
                </div>
                <button class="btn btn-success" type="submit">Log in</button>
                <a class="btn btn-primary" role="button" href="<?= $this->Url->build([
                    'controller' => 'users',
                    'action' => 'add'
                    ]); ?>">Register</a>
            </form>
            <?php endif; ?>
        </div>
    </div>
</nav>