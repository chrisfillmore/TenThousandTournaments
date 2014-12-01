<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Table;

use App\Model\Table\TenThousandTable;

class SeasonsTeamsTable extends TenThousandTable {
    public function initialize(array $config) {
        $this->belongsTo('Seasons');
        $this->belongsTo('Teams');
    }
}