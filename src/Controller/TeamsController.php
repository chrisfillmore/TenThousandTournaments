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
        
        // Roster info
        $teamsTable = TableRegistry::get('Teams');
        $query = $teamsTable
                ->find()
                ->contain([
                    'Players.Users',
                    'Leagues',
                    'Seasons'
                    ])
                ->where(['Teams.id' => $id]);
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
                    'OR' => [
                        ['Games.home_team_id' => $id],
                        ['Games.away_team_id' => $id]
                    ]
                ])
                ->order(['Games.date_time' => 'DESC']);
        $nextGame = $query->first();
        
        $this->set('games', [$nextGame]);
        
        // Players
        $players = AppController::recursiveObjectToArray($team['players']);
        $players = Hash::combine($players,
                '{n}.id',
                ['%s %s', '{n}.user.first_name', '{n}.user.last_name']);
        
        // Teams in the current season
        $teamsList = TeamsController::teamsThisSeason($season['id']);
        
        $nav = new Navigation([
            'subNav' => [
                'heading' => $team['league']['name'],
                'controller' => 'leagues',
                'action' => 'view',
                'id' => $team['league']['id'],
                'buttons' => [
                    'View Team Schedule' => [
                        'controller' => 'teams',
                        'action' => 'schedule',
                        'id' => $id,
                        '?' => ['season' => $season['id']]
                    ],
                    'Select Team' => [
                        'controller' => 'teams',
                        'action' => 'schedule',
                        '?' => ['season' => $season['id']],
                        'buttons' => $teamsList
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
            'subNav' => [
                'heading' => $season['league']['name'],
                'controller' => 'leagues',
                'action' => 'view',
                'id' => $season['league']['id'],
                'buttons' => [
                    'View Team Roster' => [
                        'controller' => 'teams',
                        'action' => 'view',
                        'id' => $teamId
                    ],
                    'Select Team' => [
                        'controller' => 'teams',
                        'action' => 'schedule',
                        '?' => ['season' => $season['id']],
                        'buttons' => $teamsList
                    ],
                    'Select Season' => [
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