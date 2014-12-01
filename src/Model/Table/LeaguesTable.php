<?php

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class LeaguesTable extends TenThousandTable {
    public function initialize(array $config) {
        $this->belongsTo('Sports');
        $this->hasMany('Seasons');
        $this->hasMany('Teams');
        $associations = ['Admins', 'Roles'];
        $joinTable = 'admins_leagues_roles';
        $this->multiBelongsToMany($associations, $joinTable);
    }
}