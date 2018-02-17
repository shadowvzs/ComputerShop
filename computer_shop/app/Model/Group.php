<?php
// app/Model/User.php
App::uses('AppModel', 'Model');

class Group extends AppModel {
	
	public $useTable = 'groups';
	
	public $hasMany = array('User' => array(
		'className' => 'User',
		'foreignKey' => 'group_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
        )
	);
}