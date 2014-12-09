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
            <?php if ($userLoggedIn) : ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
                       role="button" aria-expanded="false"><?= $name ?> &nbsp;
                       <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><?= $this->Html->link(
                            'View Profile',
                            [
                                'controller' => 'users',
                                'action' => 'view',
                                $userLoggedIn
                            ]); ?>
                        </li>
                        <li><?= $this->Html->link(
                            'Log Out',
                            [
                                'controller' => 'users',
                                'action' => 'logout'
                            ]); ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <form class="navbar-form" role="form">
                        <a class="btn btn-success" role="button" href="<?= $this->Url->build([
                    'controller' => 'users',
                    'action' => 'logout'
                    ]); ?>">Log Out</a>
                    </form>
                </li>
            </ul>
            <?php else : ?>
            <form class="navbar-form navbar-right" role="form">
                <a class="btn btn-success" role="button" href="<?= $this->Url->build([
                    'controller' => 'users',
                    'action' => 'login'
                    ]); ?>">Log In</a>
                <a class="btn btn-primary" role="button" href="<?= $this->Url->build([
                    'controller' => 'users',
                    'action' => 'add'
                    ]); ?>">Register</a>
            </form>
            <?php endif; ?>
        </div>
    </div>
</nav>