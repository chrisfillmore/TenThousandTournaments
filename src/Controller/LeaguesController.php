<?php

namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class LeaguesController extends TenThousandController {
    public $helpers = array('Html');
    
    public function index() {
        $leagues = TableRegistry::get('Leagues');
        $query = $leagues
                ->find()
                ->contain([
                    'Sports',
                    'Seasons'
                ]);
        if (!$query) { throw new NotFoundException(__('No Leagues')); }
        $this->set('leagues', $query->toArray());
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        
        // Get info about the league
        $league = TableRegistry::get('Leagues');
        $query = $league
                ->find()
                ->contain([
                    'Sports',
                    'Seasons'
                ])
                //->group('Admins.id')
                ->where(['Leagues.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        $this->set('league', $query->first());
        
        // Get info about league admins and their roles
        $admins_leagues_roles = TableRegistry::get('AdminsLeaguesRoles');
        $query = $admins_leagues_roles
                ->find()
                ->contain([
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
        $splice = $this->spliceChildIntoParent($admins_roles, $roles_admins, 'name', 'roles');
        // end massage, ahh....
        
        $this->set('admins', $splice);
    }
}
