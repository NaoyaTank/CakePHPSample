<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $components = array(
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'posts',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            )
        ),
        'Session'
    );

    // public function isAuthorized($user) {
	//     if (isset($user['role']) && $user['role'] === 'admin') {
	//         return true;
	//     }
	//     // デフォルトは拒否
	//     return false;
	// }

    public function beforeFilter() {
        // viewでAuth使うとき、以下を入れるしかないのか？
        $this->set('auth', $this->Auth);
        // $this->Auth->allow('index', 'view');
    }
}
