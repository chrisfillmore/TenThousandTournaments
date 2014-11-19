<?php

class SeasonsController extends AppController {

    public $helpers = array('Html');
    
    public function index() {
        $this->set('seasons', $this->Season->find('all'));
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid Season')); }
        
        $season = $this->Season->findById($id);
        if (!$season) { throw new NotFoundException(__('Invalid Season')); }
        $this->set('season', $season);
    }

}
