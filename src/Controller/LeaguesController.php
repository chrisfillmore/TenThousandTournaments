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
                    'Sports',
                    'Seasons'
                ])
                ->where(['Leagues.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        $this->set('league', $query->first());

        $admins = TableRegistry::get('Leagues');
        $query = $admins
                ->find()
                ->contain([
                    'Admins.Users' => ['foreignKey' => 'id'],
                    'Roles.Titles'=> ['foreignKey' => 'id']
                ])
                ->where(['Leagues.id' => $id]);
        $this->set('admins', $query->toArray()[0]);
    }
}
