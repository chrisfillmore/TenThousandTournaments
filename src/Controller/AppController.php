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
use App\Exception\TenThousandException;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    protected $subNav = true;
    
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
        $this->set('subNav', $this->subNav);
        
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Leagues'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ]
        ]);
        $loggedIn = $this->Auth->user('id');
        $this->set('loggedIn', $loggedIn);
    }
    
    public function beforeFilter(Event $event) {
        $this->Auth->allow(['index', 'view']);
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
        $navOutput = $this->defaultNav();
        
        foreach ($navInput as $navKey => $navValue) {
            if ($navKey == 'subNav') {
                foreach ($navInput['subNav'] as $subNavKey => $subNavValue) {
                    if ($subNavKey == 'buttons') {
                        $navOutput['subNav']['buttons'] =
                                $this->createButtons(
                                        array_keys($subNavValue),
                                        $subNavValue
                                        );
                        continue;
                    };
                    $navOutput['subNav'][$subNavKey] = $subNavValue;
                }
                continue;
            }
            $navOutput[$navKey] = $navValue;
        }
        
        unset($navOutput['subNav']['subNav']);
        return $navOutput;
    }
    
    private function defaultNav($subHeader = false) {
        $nav =
            [
                'heading' => 'Ten Thousand Tournaments',
                'controller' => 'pages',
                'action' => 'home',
                'id' => '',
                'subNav' => [
                    'heading' => '',
                    'controller' => '',
                    'action' => '',
                    'id' => '',
                    'buttons' => []
                ]
            ];
        return $nav;
    }
    
    private function createButtons(array $buttonNames, array $buttonData) {
        $buttons = $this->defaultButtonProperties($buttonNames);

        foreach ($buttonData as $button => $properties) {
            foreach ($properties as $key => $property)
                $buttons[$button][$key] = $property;
        }
        
        return $buttons;
    }
    
    private function defaultButtonProperties(array $names) {
        if (!$names) throw new Exception('Names must be provided to make buttons.');
        
        $buttons = [];
        
        foreach ($names as $name) {
            $buttons[$name] =
            [
                'controller' => AppController::replaceSpaces($name),
                'action' => '',
                'id' => '',
                '?' => [],
                'buttons' => []
            ];
        }
        
        return $buttons;
    }
}