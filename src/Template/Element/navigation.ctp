<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" 
                    data-toggle="collapse" data-target="#navbar" 
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button><?=
            $this->Html->link(
                    'Ten Thousand Tournaments',
                    [
                        'controller' => 'pages',
                        'action' => 'home'
                    ],
                    ['class' => 'navbar-brand']
                ); ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <?php
            foreach ($navButtons as $name => $menu) :
                if ($menu) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
               role="button" aria-expanded="false">
                        <?= $name; ?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu"><?php
                        foreach ($menu as $link) : ?>
                            <li><a href="#"><?= $link; ?></a></li><?php
                        endforeach; ?>
                    </ul>
                </li><?php
                continue;
                elseif (strtolower($name) == $currentPage) : ?>
                    <li class="active"><?php
                else : ?>
                    <li><?php
                endif;
                echo $this->Html->link(
                        $name,
                        [
                            'controller' => 'pages',
                            'action' => strtolower($name)
                        ]
                    ); ?>
                    </li><?php
            endforeach; ?>
            </ul>
        </div>
    </div>
</nav>