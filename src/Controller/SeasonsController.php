<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Routing\Router;
use Cake\Event\Event;

class SeasonsController extends AppController {

    public $helpers = array('Html');
    
    public function beforeFilter(Event $event) {
        $this->Auth->allow(['schedule']);
    }
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        $teamId = $this->request->query('team');
        $this->redirect('/teams/schedule/' . $teamId . '/?season=' . $id);
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
    
    public function add() {
        if (array_key_exists('league', $this->request->query))
            $leagueId = $this->request->query['league'];
        else {
            $this->Flash->error(__('Cannot create Season: League not specified.'));
            return $this->redirect(['action' => 'index']);
        }

        $season = $this->Seasons->newEntity([
            'year' => date('Y') + 1,
            'league_id' => $leagueId
        ]);
        
        if ($this->Seasons->save($season)) {        
            $this->Flash->success(__('Your season has been created!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to create your league.'));
    }
    
    public static function seasonsThisTeam($teamId) {
        $seasonsTeamsTable = TableRegistry::get('SeasonsTeams');
        $query = $seasonsTeamsTable
                ->find()
                ->contain(['Seasons'])
                ->where(['SeasonsTeams.team_id' => $teamId])
                ->order(['SeasonsTeams.season_id' => 'desc'])
                ->hydrate(false);
        $seasonsList = $query->toArray();
        $seasonsList = Hash::combine($seasonsList,
                '{n}.season_id',
                '{n}.season.year');
        return $seasonsList;
    }
}
