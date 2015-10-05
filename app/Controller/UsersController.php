<?php
class UsersController extends AppController {

    public function beforeFilter() {
        debug($this->Auth->user('id'));
        parent::beforeFilter();
        $this->Auth->allow('add', 'login');
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
            if ($this->User->save($data)) {
                $this->Session->setFlash('You are signed up successfly!');
                $this->Auth->login();
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.');
            }
        }
    }

    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
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

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
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