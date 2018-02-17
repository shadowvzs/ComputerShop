<?php
App::uses('AppModel', 'Model');
class Category extends AppModel {
	
	public $actsAs = array(
			'Sluggable' => array(
                    'overwrite' => true,
                    'translation' => 'utf-8',
                    'label' => 'name'
            ),
			'Containable'
	);
	
	public $recursive = 2;
	
	public $belongsTo = array(
		'Parent' => array(
				'className' => 'Category',
				'foreignKey' => 'parent_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);	
	
	public $hasMany = array(
		'Child' => array(
			'className' => 'Category',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Child.order asc',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
        )
	);	
	
	public function getAllCategory() {
		$parent_pages = $this->find('all', array(
			'order'=>array('Category.order'=>'asc'),
			'conditions' => array(
				'Category.parent_id' => 0	
			)
		));
		return $parent_pages;
	}	
	
	public function getAllActiveCategory() {
		$parent_pages = $this->find('all', array(
			'order'=>array('Category.order'=>'asc'),
			'conditions' => array(
				'Category.parent_id' => 0	
			), 
			'contain' => array('Child' => array('conditions' => array('Child.active' => 1)))
		));
		return $parent_pages;
	}	
}