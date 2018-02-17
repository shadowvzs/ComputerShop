<?php
App::uses('AppModel', 'Model');

class Accessory extends AppModel {
	
	public $actsAs = array(
			'Sluggable' => array(
                    'overwrite' => true,
                    'translation' => 'utf-8',
                    'label' => 'name'
            ),
	);
	
  	public $hasMany = array('Product' => array(
		'className' => 'Product',
		'foreignKey' => 'accessory_id',
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