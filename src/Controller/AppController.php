<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
/**
 * Initialization hook method.
 *
 * Use this method to add common initialization code like loading components.
 *
 * @return void
 */
    public function initialize() {
        $this->loadComponent('Flash');
        $nav = new Navigation();
        $this->set('nav', $nav->getNav());
    }
    
    static function replaceSpaces($input) {
        $output = strtolower($input);
        $output = str_replace(' ', '_', $output);
        return $output;
    }
    
    static function recursiveObjectToArray($obj) {
        if(is_object($obj))
            $obj = AppController::objectToArray($obj);
        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val)
                $new[$key] = AppController::recursiveObjectToArray($val);
        }
        else
            $new = $obj;
        return $new;
    }
    
    static function objectToArray(&$Instance) {
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
    
    static function spliceChildIntoParent(array $parentHash, array $childHash, $parentIndex = 'parent', $childIndex = 'children') {
        if (count($parentHash) < 1 || count($childHash) < 1) {
            $error = "One of the supplied arrays is empty";
            throw new TenThousandException($error);
        }
        
        $splice = [];
        foreach ($parentHash as $key => $value)
            $splice[$key][$childIndex] = $value;
        
        foreach ($childHash as $parentValues) {
            foreach ($parentValues as $parentKey => $parentValue) {
                $splice[$parentKey][$parentIndex] = $parentValue;
            }
        }
        
        return $splice;
    }
}

class Navigation {
    
    private $nav = [];
    
    public function __construct(array $nav = []) {
        if ($nav)
            $this->nav = $this->makeNav($nav);
        else
            $this->nav = $this->defaultNav();
    }
    
    public function getNav() { return $this->nav; }
    
    private function makeNav(array $navInput) {
        $navOutput = $this->defaultHeader();
        
        foreach ($navInput as $key => $value) {
            if ($key == 'buttons') continue;
            $navOutput[$key] = $value;
        }
        
        if ($navInput['buttons']) {
            $navOutput['buttons'] = $this->createButtons(array_keys($navInput['buttons']));
            foreach ($navInput['buttons'] as $button => $properties) {
                foreach ($properties as $key => $property)
                    $navOutput['buttons'][$button][$key] = $property;
            }
        }
        return $navOutput;
    }
    
    private function defaultNav() {
        $nav = $this->defaultHeader();
        $nav['buttons'] = $this->defaultButtons();
        return $nav;
    }
    
    private function defaultHeader() {
        $nav =
            [
                'heading' => 'Ten Thousand Tournaments',
                'controller' => 'pages',
                'action' => 'home',
                'id' => '',
                'current' => 'Home',
                'buttons' => []
            ];
        return $nav;
    }
    
    private function defaultButtons() {
        $buttons = 
            [
                'About' =>
                    [
                        'controller' => 'pages',
                        'action' => 'about',
                        'id' => '',
                        '?' => [],
                        'buttons' => []
                    ],
                'Contact' => 
                    [
                        'controller' => 'pages',
                        'action' => 'contact',
                        'id' => '',
                        '?' => [],
                        'buttons' => []
                    ]
            ];
        return $buttons;
    }
    
    private function defaultButtonProperties($name) {
        if (!$name) throw new Exception('A name must be provided for this button.');
        $button =
            [
                'controller' => AppController::replaceSpaces($name),
                'action' => '',
                'id' => '',
                '?' => [],
                'buttons' => []
            ];
        return $button;
    }
    
    private function createButtons(array $buttonNames) {
        $buttons = [];
        foreach ($buttonNames as $value) {
            $buttons[$value] = $this->defaultButtonProperties($value);
        }
        return $buttons;
    }
    
    
}