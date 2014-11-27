<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class SportsController extends AppController {
    public $helpers = array('Html');
    
    public function initialize() {
        parent::initialize();
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
}
