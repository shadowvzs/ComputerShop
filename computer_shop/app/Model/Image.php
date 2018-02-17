<?php
// app/Model/User.php
App::uses('AppModel', 'Model');

class Image extends AppModel {
	public $hasMany = array('Brand' => array(
		'className' => 'Brand',
		'foreignKey' => 'image_id',
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