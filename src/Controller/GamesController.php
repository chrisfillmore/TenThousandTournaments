<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class GamesController extends AppController {
    public $helpers = array('Html');
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        
    }
}