<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class LeaguesController extends AppController {
    public $helpers = array('Html');
    
    public function index() {
        $leagues = TableRegistry::get('Leagues');
        $query = $leagues->find();
        $this->set('leagues', $query);
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid League')); }
        /*
        $test = $this->League->query(
                "SELECT `Admin`.`id`, "
                . "`AdminsLeaguesTitle`.`admin_id`, "
                . "`AdminsLeaguesTitle`.`league_id`, "
                . "`AdminsLeaguesTitle`.`title_id` "
                . "FROM `ten_thousand_tournaments`.`admins` AS `Admin` "
                . "JOIN `ten_thousand_tournaments`.`admins_leagues_titles` "
                . "AS `AdminsLeaguesTitle` "
                . "ON (`AdminsLeaguesTitle`.`league_id` = $id "
                . "AND `AdminsLeaguesTitle`.`admin_id` = `Admin`.`id`) "
                . "GROUP BY `AdminsLeaguesTitle`.`admin_id`" 
        );
        $this->set('test', $test);
        $params = array(
            'conditions' => array(
                'League.id' => $id
            ),
            'recursive' => 2,
            'joins' => array(
                array(
                    'table' => 'admins_leagues_titles',
                    'alias' => 'AdminsLeaguesTitle',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'AdminsLeaguesTitle.league_id = League.id'
                    )
                ),
                array(
                    'table' => 'admins',
                    'alias' => 'Admin',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Admin.id = AdminsLeaguesTitle.admin_id'
                    )
                )
            ),
            'contain' => array(
                'Sport',
                'Season' => array(
                    'fields' => array(
                        'id',
                        'year'
                    )
                ),
                'Admin' => array(
                    'fields' => array(),
                    'User',
                    'Title' => array(
                        'conditions' => "league_id = $id",
                        'fields' => array(
                            'name'
                        )
                    )
                )
            )
        );*/
        
        
        //$league = $this->League->find('first', $params);
        
        $league = $this->Leagues->findByLeagueId($id);
        if (!$league) { throw new NotFoundException(__('Invalid League')); }
        $this->set('league', $league);
    }
}
