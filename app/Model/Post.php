<?php
class Post extends AppModel {

	public $belongsTo = array(
		'User' =>  array(
				'order' => array('Post.created DESC'),
				'fields' => array('User.username', 'User.img_name'),
			),
		);

    public $validate = array(
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
}
