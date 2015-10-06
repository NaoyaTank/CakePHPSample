<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $hasMany = array('Post');

    public $validate = array(
        'username' => array(
            'rule1' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'User name you entered has already used'
            ),
            'rule3' => array(
                'rule' => array('between', 5, 20), 
                'message' => 'Please Enter more than 5 letters, less than 15 letters'
            )
        ),
        'email' => array(
            'rule1' => array(
                'rule' => array('notEmpty'),
                'message' => 'A email is required'
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'A email you entered has already used'
            ),
            'rule3' => array(
                'rule' => array('email'),
                'message' => 'Please enter valid formated email'
            ),
        ),
        'password' => array(
            'rule1' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'rule2' => array(
                'rule' => array('between', 8, 20),
                'message' => 'Please Enter more than 8 letters, less than 20 letters'
            ),
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            ),
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

    public function isOwnedBy($parameter_user_id, $logined_user_id) {
        return $parameter_user_id === $logined_user_id;
    }

    public function save_img($file, $path) {
        move_uploaded_file($file, $path);
    }

    public function get_img_name($user_id, $img_name) {
         return $user_id . '_' . $img_name;
    }

    public function get_img_path($img_name) {
         return IMAGES . $img_name;
    }
}
