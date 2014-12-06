<?php

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class GamesTable extends TenThousandTable {
    public function initialize(array $config) {
        $this->hasMany('Leagues');
        $this->belongsTo('Seasons');
        $this->belongsTo('Locations');
        $this->belongsTo(
                    'HomeTeams',
                    [
                        'className' => 'Teams',
                        'foreignKey' => 'home_team_id'
                    ]
                );
        $this->belongsTo(
                    'AwayTeams',
                    [
                        'className' => 'Teams',
                        'foreignKey' => 'away_team_id'
                    ]
                );
    }
}
