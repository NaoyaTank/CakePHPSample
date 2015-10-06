<?php
class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');

    public function beforeFilter() {
        // before login
        parent::beforeFilter();
        //$this->Auth->allow('index');
    }

	public function isAuthorized($user) {
		# after login
	    if (in_array($this->action, array('add', 'index'))) {
	        return true;
	    }

	    # after login and collect users request
	    if (in_array($this->action, array('edit', 'delete'))) {
	        $postId = (int) $this->request->params['pass'][0];
	        if ($this->Post->isOwnedBy($postId, $user['id'])) {
	            return true;
	        }
	    }
	    return parent::isAuthorized($user);
	}

    public function index() {
        $this->set('posts', $this->Post->find('all'));
//        debug($this->Post->find('all'));
//        exit;


//        debug($posts);
    }

    public function add() {
	    if ($this->request->is('post')) {
	        $this->request->data['Post']['user_id'] = $this->Auth->user('id');
	        if ($this->Post->save($this->request->data)) {
	            $this->Session->setFlash('Your post has been saved.');
	            $this->redirect(array('action' => 'index'));
	        } else{
	            $this->Session->setFlash('posting was failed');
	        }
	    }
	}

    // public function view($id = null) {
    //     if (!$id) {
    //         throw new NotFoundException(__('Invalid post'));
    //     }

    //     $post = $this->Post->findById($id);
    //     if (!$post) {
    //         throw new NotFoundException(__('Invalid post'));
    //     }
    //     $this->set('post', $post);
    // }


 //    public function edit($id = null) {
	//     if (!$id) {
	//         throw new NotFoundException(__('Invalid post'));
	//     }

	//     $post = $this->Post->findById($id);
	//     if (!$post) {
	//         throw new NotFoundException(__('Invalid post'));
	//     }

	//     if ($this->request->is(array('post', 'put'))) {
	//         $this->Post->id = $id;
	//         if ($this->Post->save($this->request->data)) {
	//             $this->session->setFlash('Your post has been updated.');
	//             return $this->redirect(array('action' => 'index'));
	//         }
	//         $this->session->setFlash('Unable to update your post.');
	//     }

	//     if (!$this->request->data) {
	//         $this->request->data = $post;
	//     }
	// }

	// public function delete($id) {
	//     if ($this->request->is('get')) {
	//         throw new MethodNotAllowedException();
	//     }

	//     if ($this->Post->delete($id)) {
	//         $this->session->setFlash('delete');
	//     } else {
	// 	    $this->session->setFlash('delete error');
	//     }
	//     return $this->redirect(array('action' => 'index'));
	// }
}
