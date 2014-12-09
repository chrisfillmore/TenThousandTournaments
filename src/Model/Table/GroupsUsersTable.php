<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GroupsUsersTable extends Table {
    public function initialize(array $config) {
        $this->belongsTo('Users');
        $this->belongsTo('Groups');
    }
}