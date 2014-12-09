<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class LocationsController extends AppController {
    
    public $helpers = ['Html'];
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Location')); }
        
        $locationsTable = TableRegistry::get('Locations');
        $query = $locationsTable
                ->find()
                ->where(['Locations.id' => $id]);
        if (!$query) { throw new NotFoundException(__('Invalid Location')); }
        
        $location = $query->first();
        $this->set('location', $location);
        
        $nav = new Navigation([
            'subNav' => [
                'heading' => $location['name'],
                'controller' => 'locations',
                'id' => $id
            ]
        ]);
        
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'HomeTeams',
                    'AwayTeams',
                    'Locations'
                ])
                ->where(['Games.location_id' => $id])
                ->order(['Games.date_time' => 'DESC']);
        
        if ($query)
            $this->set('games', $query->toArray());
        
        $this->set('nav', $nav->getNav());
    }
}