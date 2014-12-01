<?php

/* 
 * Copyright (C) 2014 Chris
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class TeamsTable extends TenThousandTable {
    public function initialize(array $config) {
        $this->belongsToMany('Seasons');
        $this->belongsToMany('Players');
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