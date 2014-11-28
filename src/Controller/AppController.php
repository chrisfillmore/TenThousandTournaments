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
        $this->set('nav', $this->makeNav());
    }
    
    protected function makeNav(array $nav = []) {
        if ($nav) {
            foreach ($nav as $key => $value)
                $this->nav[$key] = $value;
        }
        if (array_key_exists('buttons', $nav) && $nav['buttons']) {
            foreach ($nav['buttons'] as $name => $properties) {
                $this->nav['buttons'][$name] = $this->makeButton($name, $properties);
            }
        } else {
            $this->nav['buttons'] = $this->defaultButtons();
        }
        return $this->nav;
    }
    
    protected function replaceSpaces($input) {
        $output = strtolower($input);
        $output = str_replace(' ', '_', $output);
        return $output;
    }
    
    private function defaultButtons() {
        return
            [
                'About' =>
                    [
                        'controller' => 'pages',
                        'action' => 'about',
                        'buttons' => []
                    ],
                'Contact' => 
                    [
                        'controller' => 'pages',
                        'action' => 'contact',
                        'buttons' => []
                    ]
            ];
    }
    
    private function defaultButtonProperties($name) {
        if (!$name) throw new Exception('A name must be provided for this button.');
        return
            [
                'controller' => $this->replaceSpaces($name),
                'action' => 'view',
                'buttons' => []
            ];
    }
    
    private function makeButton($name, array $properties = []) {
        if (!$name) throw new Exception('A name must be provided for this button.');
        $buttonProperties = [];
        
        if  (array_key_exists('controller', $properties) && $properties['controller'] &&
                array_key_exists('action', $properties) && $properties['action'] &&
                array_key_exists('buttons', $properties))
                $buttonProperties = $properties;
        else
            $buttonProperties = $this->defaultButtonProperties($name);
        
        return $buttonProperties;
    }
}
