<?php

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class GamesTable extends TenThousandTable {
    public function initialize(array $config) {
        $associations = ['Seasons', 'Teams', 'GameStates', 'Locations'];
        $this->multiBelongsTo($associations);
    }
}
