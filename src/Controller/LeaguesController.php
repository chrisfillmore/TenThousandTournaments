<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Network\Exception\NotFoundException;
use Cake\Event\Event;

class LeaguesController extends AppController {
    public $helpers = ['Html', 'Url', 'Form'];
    
    public function beforeFilter(Event $event) {
        $this->Auth->allow(['index', 'view']);
    }
    
    public function index() {
        $leaguesTable = TableRegistry::get('Leagues');
        $query = $leaguesTable
                ->find()
                ->contain([
                    'Sports',
                    'Seasons'
                ]);
        if (!$query) { throw new NotFoundException(__('No Leagues')); }
        $leagues = $query->toArray();
        $this->set('leagues', $leagues);
        
        $sportList = [];
        
        foreach ($leagues as $league)
            $sportList[$league['sport']['id']] = $league['sport']['name'];
        
        $nav = new Navigation([
                        'subNav' => [
                            'heading' => 'Leagues',
                            'controller' => 'leagues',
                            'buttons' => [
                                'Sports' => [
                                        'controller' => 'sports',
                                        'action' => 'view',
                                        'buttons' => $sportList
                                ] 
                            ]
                        ]
                    ]);
        $this->set('nav', $nav->getNav()); 
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        
        // Get info about the league
        $leaguesTable = TableRegistry::get('Leagues');
        $query = $leaguesTable
                ->find()
                ->contain([
                    'Sports'
                ])
                ->where(['Leagues.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        $league = $query->first();
        
        if (!$league['is_active']) {
            $this->Flash->default(__('This league has not been activated yet.'));
            return $this->redirect('/leagues');
        }
        $this->set('league', $league);
        
        // Get info about the current season
        $seasonsTable = TableRegistry::get('Seasons');
        $query = $seasonsTable
                ->find()
                ->contain([
                    'Teams'
                ])
                ->where(['Seasons.league_id' => $id])
                ->order(['Seasons.year' => 'DESC']);
        if (!$query) { throw new NotFoundException(__('No Seasons')); }
        $season = $query->first();
        $this->set('season', $season);
        
        if (!$season) {
            $this->Flash->default(__('That league has not scheduled a season yet.'));
            return $this->redirect('/leagues');
        }
        
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'Locations',
                    'HomeTeams',
                    'AwayTeams'
                ])
                ->where(['Games.season_id' => $season['id']])
                ->order(['Games.date_time' => 'ASC']);
        $games = $query->toArray();
        $this->set('games', $games);
        
        // Get info about league admins and their roles
        $admins_leagues_roles = TableRegistry::get('AdminsLeaguesRoles');
        $query = $admins_leagues_roles
                ->find()
                ->contain(
                    [
                        'Admins.Users' => ['foreignKey' => 'id'],
                        'Roles.Titles'=> ['foreignKey' => 'title_id']
                    ])
                ->where(['league_id' => $id])
                ->hydrate(false);
        $admins = $query->toArray();
        if (!$admins) { throw new NotFoundException(__('No Admins')); }
        
        // Begin seriously massaging the data
        $admins_roles = Hash::combine($admins,
                '{n}.role_id',
                '{n}.role.title.name',
                '{n}.admin_id'
                );
        $roles_admins = Hash::combine($admins,
                '{n}.admin_id',
                ['%s %s', '{n}.admin.user.first_name', '{n}.admin.user.last_name'],
                '{n}.role_id'
                );
        $admins = AppController::spliceChildIntoParent($admins_roles, $roles_admins, 'name', 'roles');
        // end massage, ahh....
        
        $this->set('admins', $admins);
        
        $teamsList = [];
        foreach ($season['teams'] as $team) {
            $teamsList[$team['id']] = $team['name'];
        }
        
        $nav = new Navigation([
                    'subNav' => [
                        'heading' => $league['name'],
                        'controller' => 'leagues',
                        'action' => 'view',
                        'id' => $league['id'],
                        'buttons' => [
                            'Team Schedules' => [
                                'controller' => 'teams',
                                'action' => 'schedule',
                                'buttons' => $teamsList,
                                '?' => ['season' => $season['id']]
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
        $this->set('sports', SportsController::getAllSports());
        
        $league = $this->Leagues->newEntity($this->request->data);
        
        // Check if this user is already an admin
        $adminsTable = TableRegistry::get('Admins');
        $query = $adminsTable->find();
        $query->select([
                    'count' => $query->func()->count('*')
                ])
                ->where(['id' => $userId])
                ->hydrate(false);
        $count = $query->first()['count'];
        
        // if not, then add user to admin table and add to admin group
        if ($count == 0) {
            $admin = $adminsTable->newEntity(['id' => $userId]);
            $this->Leagues->Admins->save($admin);
            $this->addUserToGroup($userId, 1);
        }
        
        // make the league
        if ($this->request->is('post')) {
            if ($this->Leagues->save($league)) {
                $leaguesTable = TableRegistry::get('Leagues');
                $query = $leaguesTable
                        ->find()
                        ->select(['id'])
                        ->order(['id' => 'DESC']);
                $league = $query->first();
                
                $adminsLeaguesTable = TableRegistry::get('AdminsLeaguesRoles');
                $query = $adminsLeaguesTable->query();
                $query->insert(['admin_id', 'league_id', 'role_id'])
                        ->values([
                            'admin_id' => $userId,
                            'league_id' => $league['id'],
                            'role_id' => 1
                        ])
                        ->execute();
                
                $this->Flash->success(__('Your league has been created!'));
                return $this->redirect([
                    'action' => 'edit',
                    $league['id']
                ]);
            }
            $this->Flash->error(__('Unable to create your league.'));
        }
        $this->set('league', $league);
    }
    
    public function edit($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        
        $userId = $this->Auth->user('id');
        
        // check if the user is an admin of this league
        $adminsLeaguesTable = TableRegistry::get('AdminsLeaguesRoles');
        $query = $adminsLeaguesTable->find();
        $query->select([
                    'count' => $query->func()->count('*')
                ])
                ->where([
                    'AdminsLeaguesRoles.league_id' => $id,
                    'AdminsLeaguesRoles.admin_id' => $userId
                ]);
        $isAdmin = $query->first()['count'];
        
        if (!$isAdmin) {
            $this->Flash->error(__('You do not have permission to modify this league.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $this->set('subNav', false);
        
        $league = $this->Leagues->get($id);
        $seasons = $this->Leagues
                ->find()
                ->contain(['Seasons.Teams'])
                ->where(['Leagues.id' => $id])
                ->hydrate(false)
                ->first()['seasons'];
        
        if ($seasons) {
            $seasons = Hash::sort($seasons, '{n}.year', 'desc');
            $this->set('currentSeason', $seasons[0]);
        } else
            $this->set('currentSeason', false);
        
        
        if ($this->request->is(['post', 'put'])) {
            $this->Leagues->patchEntity($league, $this->request->data);
            if ($this->Leagues->save($league)) {
                $this->Flash->success(__('Your league has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your league.'));
        }

        $this->set('league', $league);
    }
    
    public static function getAllLeagues() {
        $leaguesTable = TableRegistry::get('Leagues');
        $query = $leaguesTable
                ->find()
                ->hydrate(false);
        if (!$query) { throw new NotFoundException(__('No Leagues')); }
        $leagues = $query->toArray();
        $leagues = Hash::combine($leagues, '{n}.id', '{n}.name');
        return $leagues;
    }
}
