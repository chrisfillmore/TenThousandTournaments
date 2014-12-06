<nav id="subnav" class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2" aria-expanded="false" aria-controls="navbar2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php if ($nav['subNav']['heading']) {
          echo $this->Html->link(
            $nav['subNav']['heading'],
            [
                'controller' => $nav['subNav']['controller'],
                'action' => $nav['subNav']['action'],
                $nav['subNav']['id']
            ],
            ['class' => 'navbar-brand']
        );
        }
        ?>
    </div>
    <div id="navbar2" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
            <?php
            foreach ($nav['subNav']['buttons'] as $name => $menu) :
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
    </div><!--/.nav-collapse -->
  </div><!--/.container-fluid -->
</nav>