<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class UsersController extends AppController {
    public $helpers = array('Html');

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
    }
    
    public function login() {
        $this->subNav = false;
        $this->set('subNav', $this->subNav);
        $this->set('user', null);
        
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function index() {
        $this->redirect('/leagues');
    }
    
    public function view($id = null) {
        if (!$id) { throw new NotFoundException(__('Invalid User')); }
        
        $usersTable = TableRegistry::get('Users');
        $query = $usersTable
                ->find()
                ->contain([
                    'Groups.Titles'
                ])
                ->where(['Users.id' => $id]);
        if (!$query) { throw new NotFoundException(__('No User')); }
        
        $user = $query->first();
        
        $query = $usersTable
                ->find()
                ->contain($this->getUserAssociations($user['groups']))
                ->where(['Users.id' => $id]);
        
        $user = $query->first();
        $this->set('user', $user);

        $nav = new Navigation([
            'subNav' => [
                'heading' => '',
                'controller' => 'pages',
                'action' => 'home',
                'buttons' => [
                    'Leagues' => [
                        'controller' => 'leagues'
                    ]
                ]
            ]
        ]);
        $this->set('nav', $nav->getNav());
    }
    
    public function add() {
        $this->subNav = false;
        $this->set('subNav', $this->subNav);
        
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if ($this->Users->save($user)) {
                $this->Flash->success(__('New user created. Thank you for registering.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add user'));
        }
        $this->set('user', $user);
    }
    
    protected function getUserAssociations(array $groups) {
        $models = [
            1 => 'Admins.Leagues',
            2 => 'Players.Teams',
            3 => 'Referees'
        ];
        $contain = ['Groups.Titles'];
        foreach ($groups as $group) {
            $contain[] = $models[$group['id']];
        }
        return $contain;
    }
}