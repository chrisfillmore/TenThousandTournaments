<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class SportsController extends AppController {
    public $helpers = array('Html');

    public function index() {
        $sports = TableRegistry::get('Sports');
        $query = $sports
                ->find()
                ->contain([
                    'Leagues'
                ]);
        if (!$query) { throw new NotFoundException(__('No Sports')); }
        $this->set('sports', $query->toArray());
        
        $nav = new Navigation([
            'subNav' => [
                'heading' => 'Sports',
                'controller' => 'sports',
                'buttons' => [
                    'Select Sport' => [
                        'controller' => 'sports',
                        'action' => 'view',
                        'buttons' => SportsController::getAllSports()
                    ]
                ]
            ]
        ]);
        
        $this->set('nav', $nav->getNav());
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        
        $sportsTable = TableRegistry::get('Sports');
        $query = $sportsTable
                ->find()
                ->contain([
                    'Leagues'
                ])
                ->where(['Sports.id' => $id])
                ->hydrate(false);
        
        if (!$query) { throw new NotFoundException(__('Invalid League')); }
        
        $sport = $query->first();
        $this->set('sport', $sport);
        
        $nav = new Navigation([
            'subNav' => [
                'heading' => $sport['name'],
                'controller' => 'sports',
                'id' => $sport['id'],
                'buttons' => [
                    'Select Sport' => [
                        'controller' => 'sports',
                        'action' => 'view',
                        'buttons' => SportsController::getAllSports()
                    ]
                ]
            ]
        ]);
        
        $this->set('nav', $nav->getNav());
    }
    
    public static function getAllSports() {
        $sportsTable = TableRegistry::get('Sports');
        $query = $sportsTable
                ->find()
                ->hydrate(false);
        $sports = $query->toArray();
        $sports = Hash::combine($sports, '{n}.id', '{n}.name');
        return $sports;
    }
}
