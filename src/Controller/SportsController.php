<?php

namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class SportsController extends TenThousandController {
    public $helpers = array('Html');
    
    public $sports = [];
    
    public function initialize() {
        parent::initialize();
        $sportsTable = TableRegistry::get('Sports');
        $query = $sportsTable
                ->find()
                ->combine('id', 'name');
        // Get the sports for use elsewhere
        $this->sports = $query->toArray();
        $this->set('navButtons', ['Sports' => $query->toArray()]);
    }
    
    public function index() {
        $sports = TableRegistry::get('Sports');
        $query = $sports
                ->find()
                ->contain([
                    'Leagues'
                ]);
        if (!$query) { throw new NotFoundException(__('No Sports')); }
        $this->set('sports', $query->toArray());
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        
        $sportsTable = TableRegistry::get('Sports');
        $query = $sportsTable
                ->find()
                ->contain([
                    'Leagues'
                ])
                ->where(['Sports.id' => $id]);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        
        $sport = $query->toArray();
        $this->set('sport', $sport);
        
        $leagues = $this->recursiveObjectToArray($sport);
        $leagues = Hash::combine($leagues, '{n}.league.id', '{n}.league.name');
        $this->set('leagues', $leagues);
        
        $this->set('navButtons',
            [
                'Sports' => $this->sports,
                'Leagues' => $leagues
            ]);
    }
}
