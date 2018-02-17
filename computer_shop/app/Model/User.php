<?php
// app/Model/User.php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
	
	public $actsAs = array(
		'Multivalidatable', 
		'Sluggable' => array(
				'overwrite' => true,
				'translation' => 'utf-8',
				'label' => 'name'
		),
	);

	public $belongsTo = array(
		'Group' => array('className' => 'Group',
				'foreignKey' => 'group_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);	
	
	public $hasMany = array('Feedback' => array(
		'className' => 'Feedback',
		'foreignKey' => 'user_id',
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
	
	var $validationSets = array(
		   'login' => array(
				'username' => array(
					'loginRule-1' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Only alphabets and numbers allowed',
						'last' => true
					 ),
					'loginRule-2' => array(
						'rule' => array('minLength', 5),
						'message' => 'Minimum length of 5 characters'
					)
				),
				'password' => array(
					'loginRule-1' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Only alphabets and numbers allowed',
						'last' => true
					 ),
					'loginRule-2' => array(
						'rule' => array('minLength', 5),
						'message' => 'Minimum length of 5 characters'
					)
				)       
			),
		   'recover' => array(
				'username' => array(
					'loginRule-1' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Only alphabets and numbers allowed',
						'last' => true
					 ),
					'loginRule-2' => array(
						'rule' => array('minLength', 5),
						'message' => 'Minimum length of 5 characters'
					)
				),
				'email' => array('email' => array('rule' => 'email', 'required' => true))      
			),			
			'registration' => array(
				'username' => array(
					'loginRule-1' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Only alphabets and numbers allowed',
						'last' => true
					 ),
					'loginRule-2' => array(
						'rule' => array('minLength', 5),
						'message' => 'Minimum length of 5 characters'
					)
				),
				'email' => array('email' => array('rule' => 'email', 'required' => true)),
				'password' => array(
					'loginRule-1' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Only alphabets and numbers allowed',
						'last' => true
					 ),
					'loginRule-2' => array(
						'rule' => array('minLength', 5),
						'message' => 'Minimum length of 5 characters'
					)
				)
			)
	);

    public function beforeSave($options = array()) {
        if (!$this->id) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }
	
}