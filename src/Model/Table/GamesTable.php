<?php

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class GamesTable extends TenThousandTable {
    public function initialize(array $config) {
        $associations = ['Seasons', 'GameStates', 'Locations'];
        $this->multiBelongsTo($associations);
        $this->belongsTo(
                    'HomeTeams',
                    [
                        'className' => 'Teams',
                        'foreignKey' => 'home_team_id'
                    ]
                );
        $this->hasMany(
                    'AwayTeams',
                    [
                        'className' => 'Teams',
                        'foreignKey' => 'away_team_id'
                    ]
                );
    }
}
