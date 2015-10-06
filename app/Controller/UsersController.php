<?php
class UsersController extends AppController {

    public $helpers = array('Html', 'Image');
    public function beforeFilter() {
        // before login
        parent::beforeFilter();
        $this->Auth->allow('add', 'login');
    }

    public function isAuthorized($user) {
        // after login
        if (in_array($this->action, array('add', 'logout'))) {
            return true;
        }

        // after login and collect users request
        if (in_array($this->action, array('view', 'edit', 'delete'))) {
            $userId = (int) $this->request->params['pass'][0];
            if ($this->User->isOwnedBy($userId, (int) $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash('Hello! you are logged in!');
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('Invalid username or password, try again');
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            $data = array(
                'username' => Set::extract($this->request->data, 'User.username'),
                'email'    => Set::extract($this->request->data, 'User.email'),
                'password' => Set::extract($this->request->data, 'User.password'),
                'role'     => 'author'
            );

            $img = $this->request->data['User']['image'];

            if ( $img['name'] ) {
                $data['img_name'] = $this->User->get_img_name($id, $img['name']);
            }

            if ($this->User->save($data)) {
                if ( $img['name'] ) {
                    $save_path = $this->User->get_img_path($data['img_name']);
                    $this->User->save_img($img['tmp_name'], $save_path);
                }
                $this->Session->setFlash('You are signed up successfly!');
                $this->Auth->login();
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.');
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        $this->User->recursive = -1;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = array(
                'email'    => Set::extract($this->request->data, 'User.email'),
                'password' => Set::extract($this->request->data, 'User.password'),
            );

            $img = $this->request->data['User']['image'];

            if ( $img['name'] ) {
                $data['img_name'] = $this->User->get_img_name($id, $img['name']);
            }

            if ($this->User->save($data)) {
                if ( $img['name'] ) {
                    $save_path = $this->User->get_img_path($data['img_name']);
                    $this->User->save_img($img['tmp_name'], $save_path);
                }
                $this->Session->setFlash('Your profile has been updated collectlly!');
                $this->redirect(array('action' => 'view', $this->User->id));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.');
            }
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
    }

    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->User->recursive = -1;
        $this->set('user', $this->User->findById($id));
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
