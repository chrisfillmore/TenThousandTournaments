<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class SeasonsController extends AppController {

    public $helpers = array('Html');
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        
        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain([
                    'Teams',
                    'Leagues'
                ])
                ->where(['Seasons.id'  => $id]);
        $season = $query->first();
        $this->set('season', $season);
        
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'HomeTeams',
                    'AwayTeams'
                ])
                ->where(['Games.season_id' => $id])
                ->order(['Games.date_time' => 'ASC']);
        $games = $query->toArray();
        $this->set('games', $games);
        
        $teams = AppController::recursiveObjectToArray($season['teams']);
        $teams = Hash::combine($teams, '{n}.id', '{n}.name');
        
        $nav = new Navigation(
                [
                    'heading' => $season['league']['name'],
                    'controller' => 'leagues',
                    'action' => 'view',
                    'id' => $season['league']['id'],
                    'buttons' =>
                    [
                        'Teams' =>
                        [
                            'controller' => 'teams',
                            'action' => 'view',
                            'buttons' => $teams
                        ]
                    ]
                ]);
        $this->set('nav', $nav->getNav());
    }
    
    public function schedule($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }

        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain([
                    'Teams',
                    'Leagues',
                    'Games'
                ])
                ->where(['Seasons.id' => $id])
                ->order(['Seasons.year' => 'DESC']);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        
        $season = $query->first();
        $this->set('season', $season);
        
        $teams = AppController::recursiveObjectToArray($season['teams']);
        $teams = Hash::combine($teams, '{n}.id', '{n}.name');
        
        $nav = new Navigation([
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
                            'id' => $season['id']
                        ],
                        'Team Schedules' =>
                        [
                            'controller' => 'teams',
                            'action' => 'schedule',
                            '?' => ['season' => $season['id']],
                            'buttons' => $teams
                        ]
                    ]
                ]);
        $this->set('nav', $nav->getNav());
    }
}
