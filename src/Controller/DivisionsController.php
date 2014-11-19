<?php

class DivisionsController extends AppController {
    public $helpers = array('Html');
    
    public function index() {
        $this->set('divisions', $this->Division->find('all'));
    }
}
