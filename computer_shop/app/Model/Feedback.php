<?php
App::uses('AppModel', 'Model');

class Feedback extends AppModel {
	
	public $useTable = 'feedbacks';
	
	public $belongsTo = array(
		'User' => array('className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => array ('id', 'first_name', 'last_name', 'email'),
				'order' => ''
		)
	); 

}