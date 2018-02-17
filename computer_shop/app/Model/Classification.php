<?php
App::uses('AppModel', 'Model');

class Classification extends AppModel {
	
	public $actsAs = array(
			'Sluggable' => array(
                    'overwrite' => true,
                    'translation' => 'utf-8',
                    'label' => 'name'
            ),
	);
	
 	public $belongsTo = array(
		'Brand' => array('className' => 'Brand',
				'foreignKey' => 'brand_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);	   
}