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
    protected function groupMultiAssociation(array $input, array $keys) {
        if (count($keys) > (count($input) - 1)) {
            $error = 'Number of indices exceeds (# columns - 1)';
            throw new TenThousandException($error);
        }
        
        if (count($input) <= 1) { 
            return $input;
        } else {
            $output = [];
            define('LENGTH_OF__ID', 3);
            $key = substr($keys[0], 0, -LENGTH_OF__ID);
            //$testing = [];
            foreach ($input as $value) {
                //$testing[] = $value[$key]['id'];
                if (!array_key_exists($value[$key]['id'], $output)) {
                    $output[$value[$key]['id']] = $this->obj2array($value[$key])['_properties'];
                    unset($value[$key]);
                }
                //$testing[] = $value;
                $output[$value[$key]['id']][] = $value;
                //unset($output[$value[$key . '_id']]);
            }
            //$this->set('testing', $testing);
            //unset($keys[0]);
            return $output;
            /*return $this->groupMultiAssociation([
                $input['admin']['id']
                ],
                [
                    
                ]); */
        }
        
    }
    
    function obj2array(&$Instance) {
        $clone = (array) $Instance;
        $rtn = array ();
        $rtn['___SOURCE_KEYS_'] = $clone;

        while ( list ($key, $value) = each ($clone) ) {
            $aux = explode ("\0", $key);
            $newkey = $aux[count($aux)-1];
            $rtn[$newkey] = &$rtn['___SOURCE_KEYS_'][$key];
        }

        return $rtn;
    }
}