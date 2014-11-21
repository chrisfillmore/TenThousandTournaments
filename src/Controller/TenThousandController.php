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

namespace App\Controller;

use App\Exception\TenThousandException;

class TenThousandController extends AppController {
    
    protected function groupAssociationById(array $input, string $key) {
        if (count($input) <= 1 || !key)
        foreach ($input as $value)
    }
    
    /*
    protected function groupMultiAssociation(array $rows, array $cols, array $output = []) {
        if (count($cols) > (count($rows) - 1)) {
            $error = 'Number of columns to group by exceeds (# rows - 1)';
            throw new TenThousandException($error);
        }
        
        if (count($cols) < 1) {  return $rows; }
        
        define('LENGTH_OF__ID', 3);
        $key = substr($cols[0], 0, -LENGTH_OF__ID);
        $testing = ['input' => $this->multiObj2Array($rows), 'output' => $output];
        foreach ($rows as $i => $value) {
            if (!is_int($i)) continue;
            if (!array_key_exists($value[$key]['id'], $output)) {
                $output[$value[$key]['id']][$key] = $this->obj2array($value[$key]);
                //unset($rows[$i][$key]);
            }
            $testing = ['input' => $this->multiObj2Array($rows), 'output' => $output];
            $output[$value[$key]['id']][] = $value;
        }

        $this->set('testing', $testing);
        //unset($cols[0]);

        return $output;
    }
    
    private function multiObj2Array(&$instance) {
        $rtn = [];
        foreach ($instance as $key => $value) {
            if (is_object($value))
                $rtn[$key] = $this->obj2Array($value);
            else
                $rtn[$key] = $value;
        }
        return $rtn;
    }
    
    private function obj2array(&$Instance) {
        $clone = (array) $Instance;
        $rtn = array ();
        $rtn['___SOURCE_KEYS_'] = $clone;

        while ( list ($key, $value) = each ($clone) ) {
            $aux = explode ("\0", $key);
            $newkey = $aux[count($aux)-1];
            $rtn[$newkey] = &$rtn['___SOURCE_KEYS_'][$key];
        }

        return $rtn['_properties'];
    }
     */
}