<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Routing\Router;
use Cake\Event\Event;

class SeasonsController extends AppController {

    public $helpers = ['Html', 'Url', 'Form'];
    
    public function beforeFilter(Event $event) {
        $this->Auth->allow(['index', 'view', 'schedule']);
    }
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        $teamId = $this->request->query('team');
        if (!$teamId) {
            return $this->redirect([
                'controller' => 'seasons',
                'action' => 'schedule',
                $id
            ]);
        }
        $this->redirect('/teams/schedule/' . $teamId . '/?season=' . $id);
    }
    
    public function schedule($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }

        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain([
                    'Leagues'
                ])
                ->where(['Seasons.id' => $id])
                ->hydrate(false);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        
        $leagueId = $query->first()['league_id'];
        $this->redirect('/leagues/view/' . $leagueId);
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
            return $this->redirect([
                'controller' => 'leagues',
                'action' => 'edit',
                $leagueId
            ]);
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
