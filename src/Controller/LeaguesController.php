<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Network\Exception\NotFoundException;

class LeaguesController extends AppController {
    public $helpers = array('Html');
    
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
                //->group('Admins.id')
                ->where(['Leagues.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        $league = $query->first();
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
                ->where(['league_id' => $id]);
        $admins = $query->toArray();
        if (!$admins) { throw new NotFoundException(__('No Admins')); }
        
        // Begin seriously massaging the data
        $admins = AppController::recursiveObjectToArray($admins);
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
}
