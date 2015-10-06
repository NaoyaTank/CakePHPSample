<?php
class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $paginate = array('limit' => 15);
    public $components = array('Session');

    public function beforeFilter() {
        // before login
        parent::beforeFilter();
        if($this->Session->read('errors')){
        	foreach($this->Session->read('errors') as $model => $errors){
                $this->Post->validationErrors = $errors;
            }
    	    $this->Session->delete('errors');
        }
    }

	public function isAuthorized($user) {
		# after login
	    if (in_array($this->action, array('add', 'index', 'reply'))) {
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
        $this->set('posts', $this->paginate());

        if( $this->Session->read('Message.Inbalid') ){
        	$this->request->data['Post']['body'] = $this->Session->read('Message.Inbalid');
        }

        if($this->Session->read('Message.Reply')){
        	$this->request->data['Post']['body'] = $this->Session->read('Message.Reply');
        	$this->request->data['Post']['reply_post_id'] = $this->Session->read('Message.ReplyId');
        }
   	    $this->Session->delete('Message');
    }

    public function add() {
	    if ($this->request->is('post')) {
            $data = array(
                'body'          => Set::extract($this->request->data, 'Post.body'),
                'user_id'       => $this->Auth->user('id'),
                'reply_post_id' => Set::extract($this->request->data, 'Post.reply_post_id'),
            );

	        if ($this->Post->save($data)) {
	            $this->Session->setFlash('Your post has been saved.');
	            $this->redirect(array('action' => 'index'));
	        } else {
	        	$this->Session->write('errors.Comment',$this->Post->validationErrors);
	        	$this->Session->write('Message.Inbalid', $this->request->data['Post']['body']);
	            $this->redirect(array('action' => 'index'));
	        }
	    }
	}

	public function reply() {
		$to_post_id = $this->request->pass[0];
		$to_post = $this->Post->findById($to_post_id);

		if ($to_post) {
			$reply_msg = '->@' . $to_post['User']['username'] . " " . $to_post['Post']['body'];
			$this->Session->write('Message.Reply', $reply_msg);
			$this->Session->write('Message.ReplyId', $to_post_id);
		}

        $this->redirect(array('action' => 'index'));
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
