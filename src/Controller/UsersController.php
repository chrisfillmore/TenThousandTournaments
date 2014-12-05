<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class UsersController extends AppController {
    public $helpers = array('Html');

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
                    'heading' => 'Ten Thousand Tournaments',
                    'controller' => 'pages',
                    'action' => 'home',
                    'buttons' =>
                    [
                        'Leagues' =>
                        [
                            'controller' => 'leagues',
                            'action' => 'index'
                        ],
                        'Teams' =>
                        [
                            'controller' => 'teams',
                            'action' => 'index'
                        ],
                        'Users' =>
                        [
                            'controller' => 'users',
                            'action' => 'index'
                        ]
                    ]
                ]);
        $this->set('nav', $nav->getNav());
    }
    
    public function add() {
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