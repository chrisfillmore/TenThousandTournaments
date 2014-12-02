<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class SportsController extends AppController {
    public $helpers = array('Html');

    
    public function initialize() {
        parent::initialize();
        $sportsTable = TableRegistry::get('Sports');
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
        
        $leagues = AppController::recursiveObjectToArray($sport);
        $leagues = Hash::combine($leagues, '{n}.league.id', '{n}.league.name');
        $this->set('leagues', $leagues);
        
    }
}
