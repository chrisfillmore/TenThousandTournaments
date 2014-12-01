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

namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;

class TeamsController extends TenThousandController {
       
    public function index() {
        
    }
    
    public function schedule($id = null) {
        
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }

        $gamesTable = TableRegistry::get('HomeGames');
        $query = $gamesTable
                ->find()
                ->contain([
                    'Teams',
                    'Leagues',
                    'Games'
                ])
                ->where(['HomeGames.home_team_id' => $id]);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        
        $this->set('games', $query->toArray());
        
        
        
        $this->set('nav', $this->makeNav(
                [
                    'heading' => $season['league']['name'],
                    'controller' => 'leagues',
                    'action' => 'view/' . $season['league']['id'],
                    'buttons' =>
                    [
                        $season['year'] . ' Season' =>
                        [
                            'controller' => 'seasons',
                            'action' => 'view/' . $season['id'],
                            'buttons' => []
                        ],
                        'Teams' =>
                        [
                            'controller' => 'teams',
                            'action' => 'schedule',
                            'buttons' => $teams
                        ]
                    ]
                ]));
        
    }
}