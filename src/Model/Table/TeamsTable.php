<?php

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class TeamsTable extends TenThousandTable {
    public function initialize(array $config) {
        $this->belongsTo('Reps');
        $this->belongsToMany('Seasons');
        $this->belongsToMany('Players');
        $this->belongsTo('Leagues', ['className' => 'Seasons.Leagues']);
        //$this->hasMany('Games');
        $this->hasMany(
                    'HomeGames',
                    [
                        'className' => 'Games',
                        'foreignKey' => 'home_team_id'
                    ]
                );
        $this->hasMany(
                    'AwayGames',
                    [
                        'className' => 'Games',
                        'foreignKey' => 'away_team_id'
                    ]
                );
    }
}