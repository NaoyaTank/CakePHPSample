<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
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
            'rule' => array('notEmpty'),
            'message' => 'A password is required'
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
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
}
