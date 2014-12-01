<?php
namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class SeasonsController extends TenThousandController {

    public $helpers = array('Html');
    
    public function index() {
        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain([
                    'Games',
                    'Teams',
                    'Leagues'
                ]);
        $this->set('seasons', $query->toArray());
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        
        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain([
                    'Games',
                    'Teams',
                    'Leagues'
                ])
                ->where(['Seasons.id'  => $id]);
        $season = $query->first();
        $this->set('season', $season);
        
        $teams = $this->recursiveObjectToArray($season['teams']);
        $teams = Hash::combine($teams, '{n}.id', '{n}.name');
        
        $this->set('nav', $this->makeNav(
                [
                    'heading' => $season['league']['name'],
                    'controller' => 'leagues',
                    'action' => 'view/' . $season['league']['id'],
                    'buttons' =>
                    [
                        'Schedule' =>
                        [
                            'controller' => 'seasons',
                            'action' => 'schedule/' . $season['id'],
                            'buttons' => []
                        ],
                        'Teams' =>
                        [
                            'controller' => 'teams',
                            'action' => 'view',
                            'buttons' => $teams
                        ]
                    ]
                ]));
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
                ->where(['Seasons.id' => $id]);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        
        $season = $query->first();
        $this->set('season', $season);
        
        $teams = $this->recursiveObjectToArray($season['teams']);
        $teams = Hash::combine($teams, '{n}.id', '{n}.name');
        
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
