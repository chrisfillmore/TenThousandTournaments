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
                    'Teams'
                ])
                ->where(['Games.season_id' => $id]);
        if (!$query) { throw new NotFoundException(__('No Season')); }
        
        
    }
}