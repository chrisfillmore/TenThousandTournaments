<?php

namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class GamesController extends TenThousandController {
    public $helpers = array('Html');
    
    public function season($id) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        
        $gamesTable = TableRegistry::get('Games');
        $query = $gamesTable
                ->find()
                ->contain([
                    'Locations',
                    'Teams' => ['foreignKey' => 'id'],
                    'Seasons.Leagues'
                ])
                ->where(['Games.season_id' => $id]);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        
        $games = $query->toArray();
        $this->set('season', $season);
    }
}