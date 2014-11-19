<?php

class UsersController extends AppController {
    public $helpers = array('Html');

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid User')); }
        
        $params = array(
            'conditions' => array(
                'User.id' => $id
            ),
            'recursive' => 2
        );
        $user = $this->User->find('first', $params);
        if (!$user) { throw new NotFoundException(__('Invalid User')); }
        $this->set('user', $user);
    }
}