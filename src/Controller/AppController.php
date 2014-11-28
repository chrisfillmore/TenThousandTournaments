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
    
    protected $nav =
        [
            'heading' => 'Ten Thousand Tournaments',
            'controller' => 'pages',
            'action' => 'home',
            'current' => 'Home',
            'buttons' => []
        ];
/**
 * Initialization hook method.
 *
 * Use this method to add common initialization code like loading components.
 *
 * @return void
 */
    public function initialize() {
        $this->loadComponent('Flash');
        $this->makeNav();
    }
    
    protected function makeNav(array $nav = []) {
        
        if ($nav) {
            foreach ($nav as $key => $value)
                $this->nav[$key] = $value;
        } else {
            $this->nav =
                
        }
        
        if (!$this->nav['buttons']) {
            foreach ($nav['buttons'] as $key => $value) {
                if (!array_key_exists('controller', $value))
                    $nav['buttons'][$key]['controller'] = 'pages';
                if (!array_key_exists('action', $value))
                    $nav['buttons'][$key]['action'] = $this->replaceSpaces($key);
                if (!array_key_exists('buttons', $value))
                    $nav['buttons'][$key]['buttons'] = [];
            }
        }
        
        return $nav;
    }
    
    protected function replaceSpaces($input) {
        $output = strtolower($input);
        $output = str_replace(' ', '_', $output);
        return $output;
    }
    
    protected function getNavButton() {
        return
            [
                'controller' => 'pages',
                'action' => 'view',
                'buttons' => []
            ];
    }
}
