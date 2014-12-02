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
            <ul class="nav navbar-nav">
            <?php
            foreach ($nav['buttons'] as $name => $menu) :
                if ($menu['buttons']) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
               role="button" aria-expanded="false">
                        <?= $name; ?>&nbsp;<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu"><?php
                        foreach ($menu['buttons'] as $id => $link) : ?>
                            <li><?php echo $this->Html->link(
                                    $link,
                                    [
                                        'controller' => $menu['controller'],
                                        'action' => $menu['action'],
                                        $id,
                                        '?' => $menu['?']
                                    ]
                                ); ?>
                            </li><?php
                        endforeach; ?>
                    </ul>
                </li><?php
                continue;
                elseif ($name == $nav['current']) : ?>
                    <li class="active"><?php
                else : ?>
                    <li><?php
                endif;
                echo $this->Html->link(
                        $name,
                        [
                            'controller' => $menu['controller'],
                            'action' => $menu['action'],
                            $menu['id'],
                            '?' => $menu['?']
                        ]
                    ); ?>
                    </li><?php
            endforeach; ?>
            </ul>
        </div>
    </div>
</nav>