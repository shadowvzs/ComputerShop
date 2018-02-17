<?php
App::uses('AppModel', 'Model');

class Page extends AppModel {		
	public $belongsTo = array(
		'Parent' => array('className' => 'Page',
				'foreignKey' => 'parent_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);	
	public $hasMany = array(
		'Child' => array(
			'className' => 'Page',
			'foreignKey' => 'parent_id',
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
	
	public function getCurrentPage($controller, $action){
		return $this->find('first', array(
			'conditions' => array(
				'Page.controller' => $controller,
				'Page.action' => $action
			)
		));
	}
	
	public function getAllPage($action) {
		$parent_pages = $this->find('all', array(
			'conditions' => array(
				'Page.parent_id' => 0,		//if this not egual 'Page.parent_id !=' and in contain Parent not chield then list the childs then parent
				'Page.'.$action => 0
			), 
			'contain' => array('Child' => array('conditions' => array('Child.active' => 1)))
		));
		return $parent_pages;
	}
}
