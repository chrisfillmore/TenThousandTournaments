<?php

namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class LeaguesController extends TenThousandController {
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
        
        $leagueList = [];
        
        foreach ($leagues as $league)
            $leagueList[$league['id']] = $league['name'];
        
        $this->set('nav', $this->makeNav(
                [
                    'controller' => 'pages',
                    'action' => 'home',
                    'buttons' =>
                        [
                            'Leagues' =>
                                [
                                    'controller' => 'leagues',
                                    'action' => 'view',
                                    'buttons' => $leagueList
                                ]
                        ]
                ]
            )
        ); 
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        
        // Get info about the league
        $leaguesTable = TableRegistry::get('Leagues');
        $query = $leaguesTable
                ->find()
                ->contain([
                    'Sports',
                    'Teams',
                    'Seasons'
                ])
                //->group('Admins.id')
                ->where(['Leagues.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        $league = $query->first();
        $this->set('league', $league);
        
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
        
        // Begin seriously massaging the data
        $admins = $this->recursiveObjectToArray($admins);
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
        $admins = $this->spliceChildIntoParent($admins_roles, $roles_admins, 'name', 'roles');
        // end massage, ahh....
        
        $this->set('admins', $admins);
        
        $seasons = $this->recursiveObjectToArray($league['seasons']);
        $seasons = Hash::combine($seasons, '{n}.id', '{n}.year');
        $teams = $this->recursiveObjectToArray($league['teams']);
        $teams = Hash::combine($teams, '{n}.id', '{n}.name');
        $this->set('nav', $this->makeNav(
            [
                'heading' => $league['name'],
                'controller' => 'leagues',
                'action' => 'view/' . $league['id'],
                'buttons' =>
                    [
                        'Seasons' => 
                            [
                                'controller' => 'seasons',
                                'action' => 'view',
                                'buttons' => $seasons
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
}
