<?php

/* 
 * Copyright (C) 2014 Chris
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {
    public function initialize(array $config) {
        $this->belongsToMany('Groups');
        $this->hasOne('Admins', ['foreignKey' => 'id']);
        $this->hasOne('Players', ['foreignKey' => 'id']);
        $this->hasOne('Referees', ['foreignKey' => 'id']);
    }
    
    public function validationDefault(Validator $validator) {
        return $validator
                ->notEmpty('username', 'A username is required')
                ->notEmpty('password', 'A password is required')
                ->notEmpty('first_name', 'Your first name is required')
                ->notEmpty('last_name', 'Your last name is required');
    }
}