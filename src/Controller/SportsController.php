<?php

class SportsController extends AppController {
    public $helpers = array('Html');
    
    public function index() {
        $this->set('sports', $this->Sport->find('all'));
    }
}
