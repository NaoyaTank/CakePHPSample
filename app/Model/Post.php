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
            'rule1' => array(
	            'rule' => array('notEmpty'),
	            'message' => 'empty post is not accepted'
	    	),
	    	'rule2' => array(
	    		'rule' => array('maxLength', 140),
	    		'message' => 'Please enter less than 140 letters'
	    	)
	    )
	);
}
