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
    
    protected function recursiveObjectToArray($obj) {
        if(is_object($obj))
            $obj = $this->objectToArray($obj);
        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val)
                $new[$key] = $this->recursiveObjectToArray($val);
        }
        else
            $new = $obj;
        return $new;
    }
    
    private function objectToArray(&$Instance) {
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
    
    protected function spliceChildIntoParent(array $parentHash, array $childHash, $parentIndex = 'parent', $childIndex = 'children') {
        if (count($parentHash) < 1 || count($childHash) < 1) {
            $error = "One of the supplied arrays is empty";
            throw new TenThousandException($error);
        }
        
        $splice = [];
        foreach ($parentHash as $key => $value)
            $splice[$key][$childIndex] = $value;
        
        foreach ($childHash as $childKey => $parentValues) {
            foreach ($parentValues as $parentKey => $parentValue) {
                $splice[$parentKey][$parentIndex] = $parentValue;
            }
        }
        
        return $splice;
    }
     
}