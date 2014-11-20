<?php
namespace App\Controller;

use App\Controller\TenThousandController;
use Cake\ORM\TableRegistry;

class SeasonsController extends TenThousandController {

    public $helpers = array('Html');
    
    public function index() {
        $seasons = TableRegistry::get('Seasons');
        $query = $seasons
                ->find()
                ->contain([
                    'Divisions',
                    'Teams',
                    'Players',
                    'Leagues'
                ]);
        $this->set('seasons', $query->toArray());
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        
        $season = TableRegistry::get('Seasons');
        $query = $season
                ->find()
                ->contain([
                    'Divisions',
                    'Teams'
                ])
                ->where(['Seasons.id'  => $id]);
        $this->set('season', $query->toArray());
    }

}
