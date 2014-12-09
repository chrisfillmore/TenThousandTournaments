<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Utility\Hash;

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
                ->where(['Users.id' => $id])
                ->hydrate(false);
        if (!$query) { throw new NotFoundException(__('No User')); }
        
        $groups = $query->first()['groups'];
        $groups = Hash::extract($groups, '{n}.id');

        $query = $usersTable
                ->find()
                ->contain($this->getUserAssociations($groups))
                ->where(['Users.id' => $id])
                ->hydrate(false);
        
        $user = $query->first();
        
        $userInfo = $this->getExtendedUserInfo($user);
        $this->set('userInfo', $userInfo);
        $this->set('user', $user);

        $nav = new Navigation([
            'subNav' => [
                'heading' => $user['first_name'] . ' ' . $user['last_name'],
                'controller' => 'users',
                'action' => 'view',
                'id' => $user['id'],
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
            $contain[] = $models[$group];
        }
        return $contain;
    }
    
    protected function getExtendedUserInfo($user) {
        $groups = Hash::combine($user['groups'], '{n}.id', '{n}.title');
        
        define('ADMIN_GROUP_ID', 1);
        define('PLAYER_GROUP_ID', 2);
        
        /* Magic numbers galore */
        if (array_key_exists('admin', $user)) {
            $leagues = Hash::combine($user['admin']['leagues'], '{n}.id', '{n}.name');
            $groups[ADMIN_GROUP_ID]['controller'] = 'leagues';
            $groups[ADMIN_GROUP_ID] = Hash::insert($groups[ADMIN_GROUP_ID], 'values', $leagues);
        }
        
        if (array_key_exists('player', $user)) {
            $teams = Hash::combine($user['player']['teams'], '{n}.id', '{n}.name');
            $groups[PLAYER_GROUP_ID]['controller'] = 'teams';
            $groups[PLAYER_GROUP_ID] = Hash::insert($groups[PLAYER_GROUP_ID], 'values', $teams);
        }
        
        return $groups;
    }
}