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
use Cake\Network\Exception\NotFoundException;

class TeamsController extends AppController {
    
    public $helpers = array('Html');
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Team')); }
        
        // Roster info
        $teamsTable = TableRegistry::get('Teams');
        $query = $teamsTable
                ->find()
                ->contain([
                    'Players.Users',
                    'Leagues',
                    'Seasons',
                    'Reps'
                    ])
                ->where(['Teams.id' => $id])
                ->hydrate(false);
        if (!$query) { throw new NotFoundException(__('No Team')); }
        $team = $query->first();
        $this->set('team', $team);        
        
        // Current season
        $season = Hash::sort($team['seasons'], '{n}.year', 'desc')[0];
        
        // Next game
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'Locations',
                    'HomeTeams',
                    'AwayTeams'
                    ])
                ->where([
                    'Games.date_time >' => date('Y-m-d'),
                    'OR' => [
                        ['Games.home_team_id' => $id],
                        ['Games.away_team_id' => $id]
                    ]
                ])
                ->order(['Games.date_time' => 'ASC'])
                ->limit(3);
        $nextGame = $query->toArray();
        
        $this->set('games', $nextGame);

        
        
        // Teams in the current season
        $teamsList = TeamsController::teamsThisSeason($season['id']);
        
        // Seasons this team has played
        $seasonsList = SeasonsController::seasonsThisTeam($id);
        
        $nav = new Navigation([
            'heading' => $team['league']['name'],
            'controller' => 'leagues',
            'action' => 'view',
            'id' => $team['league']['id'],
            'subNav' => [
                'heading' => $team['name'],
                'controller' => 'teams',
                'action' => 'view',
                'id' => $team['id'],
                'buttons' => [
                    'Schedule' => [
                        'controller' => 'teams',
                        'action' => 'schedule',
                        'id' => $id,
                        '?' => ['season' => $season['id']]
                    ],
                    'Teams' => [
                        'controller' => 'teams',
                        'action' => 'view',
                        '?' => ['season' => $season['id']],
                        'buttons' => $teamsList
                    ],
                    'Seasons' => [
                        'controller' => 'seasons',
                        'action' => 'view',
                        'id' => $season['id'],
                        '?' => ['team' => $id],
                        'buttons' => $seasonsList
                    ]
                ]
            ]
        ]);
        $this->set('nav', $nav->getNav());
    }
    
    public function schedule($teamId = null) {
        
        if (!$teamId) { throw new NotFoundException(__('Invalid Team')); }
        
        if (array_key_exists('season', $this->request->query))
            $seasonId = $this->request->query['season'];
        
        // Games
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'HomeTeams',
                    'AwayTeams',
                    'Locations'
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
        
        $games = $query->toArray();
        $this->set('games', $games);      
        
        // Season
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
        
        // Teams this season
        $teamsList = TeamsController::teamsThisSeason($seasonId);
        
        // Seasons this team
        $seasonsList = SeasonsController::seasonsThisTeam($teamId);
        
        $nav = new Navigation([
            'heading' => $season['league']['name'],
            'controller' => 'leagues',
            'action' => 'view',
            'id' => $season['league']['id'],
            'subNav' => [
                'heading' => $team['name'],
                'controller' => 'teams',
                'action' => 'view',
                'id' => $team['id'],
                'buttons' => [
                    'Roster' => [
                        'controller' => 'teams',
                        'action' => 'view',
                        'id' => $teamId
                    ],
                    'Teams' => [
                        'controller' => 'teams',
                        'action' => 'schedule',
                        '?' => ['season' => $season['id']],
                        'buttons' => $teamsList
                    ],
                    'Seasons' => [
                        'controller' => 'seasons',
                        'action' => 'view',
                        'id' => $season['id'],
                        '?' => ['team' => $teamId],
                        'buttons' => $seasonsList
                    ]
                ]
            ]
        ]);
        
        $this->set('nav', $nav->getNav());
    }
    
    public function add() {
        $userId = $this->Auth->user('id');
        if (!$userId) {
            $this->Flash->default(__('You must log in to proceed.'));
            $this->redirect($this->Auth->redirectUrl());
        }
        
        $this->subNav = false;
        $this->set('subNav', $this->subNav);
        $this->set('leagues', LeaguesController::getAllLeagues());
        
        $team = $this->Teams->newEntity($this->request->data);
        
        // Check if this user is already a player
        $playersTable = TableRegistry::get('Players');
        $query = $playersTable->find();
        $query->select([
                    'count' => $query->func()->count('*')
                ])
                ->where(['id' => $userId])
                ->hydrate(false);
        $count = $query->first()['count'];
        
        // if not, then add user to player table
        if ($count == 0) {
            $player = $playersTable->newEntity(['id' => $userId]);
            $this->Teams->Reps->Players->save($player);
        }
        
        // Check if this user is already a rep
        $repsTable = TableRegistry::get('Reps');
        $query = $repsTable->find();
        $query->select([
                    'count' => $query->func()->count('*')
                ])
                ->where(['id' => $userId])
                ->hydrate(false);
        $count = $query->first()['count'];
        
        // if not, then add user to rep table
        if ($count == 0) {
            $rep = $repsTable->newEntity(['id' => $userId]);
            $this->Teams->Reps->save($rep);
        }
        
        // Add the team
        if ($this->request->is('post')) {
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('Your team has been registered!'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to register your team.'));
        }
        $this->set('team', $team);
    }
    
    public static function teamsThisSeason($seasonId) {
        $seasonsTeamsTable = TableRegistry::get('SeasonsTeams');
        $query = $seasonsTeamsTable
                ->find()
                ->contain(['Teams'])
                ->where(['SeasonsTeams.season_id' => $seasonId])
                ->order(['SeasonsTeams.team_id' => 'asc'])
                ->hydrate(false);
        $teamsList = $query->toArray();
        $teamsList = Hash::combine($teamsList,
                '{n}.team_id',
                '{n}.team.name');
        return $teamsList;
    }
}