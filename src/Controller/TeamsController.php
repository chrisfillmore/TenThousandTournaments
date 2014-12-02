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

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class TeamsController extends AppController {
    
    public $helpers = array('Html');
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Team')); }
        
        $teamsTable = TableRegistry::get('Teams');
        $query = $teamsTable
                ->find()
                ->contain([
                    'Players.Users',
                    'Leagues'
                    ])
                ->where(['Teams.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('No Team')); }
        
        $team = $query->first();
        $this->set('team', $team);
        
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'Locations',
                    'HomeTeams',
                    'AwayTeams'
                    ])
                ->where([
                    'OR' => [
                        ['Games.home_team_id' => $id],
                        ['Games.away_team_id' => $id]
                    ]
                ])
                ->order(['Games.date_time' => 'DESC']);
        
        if (!$query)
            $nextGame = false;
        else
            $nextGame = $query->first();
        
        $this->set('nextGame', $nextGame);
        
        $players = AppController::recursiveObjectToArray($team['players']);
        $players = Hash::combine($players,
                '{n}.id',
                ['%s %s', '{n}.user.first_name', '{n}.user.last_name']);
        
        $nav = new Navigation([
                    'heading' => $team['league']['name'],
                    'controller' => 'leagues',
                    'action' => 'view',
                    'id' => $team['league']['id'],
                    'buttons' =>
                        [
                            
                            'Team Schedule' => 
                                [
                                    'controller' => 'teams',
                                    'action' => 'schedule',
                                    'id' => $id,
                                    '?' => ['season' => $nextGame['season_id']]
                                ],
                            'Players' =>
                                [
                                    'controller' => 'users',
                                    'action' => 'view',
                                    'buttons' => $players
                                ]
                        ]
                ]);
        $this->set('nav', $nav->getNav());
    }
    
    public function schedule($teamId = null) {
        
        if (!$teamId) { throw new NotFoundException(__('Invalid Team')); }
        
        $seasonId = $this->request->query['season'];
        
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'HomeTeams',
                    'AwayTeams'
                ])
                ->where([
                    'Games.season_id' => $seasonId,
                    'OR' => [
                        ['Games.home_team_id' => $teamId],
                        ['Games.away_team_id' => $teamId]
                    ]
                ])
                ->order(['Games.date_time' => 'ASC']);
        if (!$query) { throw new NotFoundException(__('No Team')); }
        
        $this->set('games', $query->toArray());      
        
        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain(['Leagues'])
                ->where(['Seasons.id' => $seasonId]);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        $season = $query->first();
        $this->set('season', $season);
        
        $teamsTable = TableRegistry::get('Teams');
        $query = $teamsTable
                ->find()
                ->where(['Teams.id' => $teamId]);
        if (!$query) { throw new NotFoundException(__('No Team')); }
        $team = $query->first();
        $this->set('team', $team);
        
        $nav = new Navigation(
                [
                    'heading' => $season['league']['name'],
                    'controller' => 'leagues',
                    'action' => 'view',
                    'id' => $season['league']['id'],
                    'buttons' =>
                    [
                        $season['year'] . ' Season' =>
                        [
                            'controller' => 'seasons',
                            'action' => 'view',
                            'id' => $season['id'],
                        ],
                        $team['name'] =>
                        [
                            'controller' => 'teams',
                            'action' => 'view',
                            'id' => $teamId
                        ]
                    ]
                ]);
        
        $this->set('nav', $nav->getNav());
    }
}