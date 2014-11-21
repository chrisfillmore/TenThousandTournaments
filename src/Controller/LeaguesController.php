<?php

namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;

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
        
        $league = TableRegistry::get('Leagues');
        $query = $league
                ->find()
                ->contain([
                    'Admins.Users' => [
                        'foreignKey' => 'id'
                    ],
                    'Roles.Titles' => ['foreignKey' => 'id'],
                    'Sports',
                    'Seasons'
                ])
                ->where(['Leagues.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        $this->set('league', $query->first());
        /*
        $admins = TableRegistry::get('AdminsLeaguesRoles');
        $query = $admins
                ->find()
                ->contain([
                    'Admins.Users' => ['foreignKey' => 'id'],
                    'Roles.Titles'=> ['foreignKey' => 'id']
                ])
                //->group('admin_id')
                ->where(['league_id' => $id]);
        if (!$query) { throw new NotFoundException(__('No League Admins')); }
        $this->set('admins', $query->toArray());
        
        $admins2 = TableRegistry::get('AdminsLeaguesRoles');
        $query2 = $admins2
                ->find()
                ->contain([
                    'Admins.Users' => ['foreignKey' => 'id'],
                    'Roles.Titles'=> ['foreignKey' => 'id']
                ])
                //->group('league_id')
                ->where(['league_id' => $id]);
        $keys = ['admin_id'];
        $test = $this->groupMultiAssociation($query2->toArray(), $keys);
        $this->set('test', $test);
        */
        $league_admins = TableRegistry::get('Leagues');
        $query3 = $league_admins
                ->find()
                ->contain([
                    'Admins.Users' => ['foreignKey' => 'id'],
                    'Roles.Titles'=> ['foreignKey' => 'id']
                ])
                ->where(['Leagues.id' => $id]);
        $this->set('league_admins', $query3->toArray());
    }
}
