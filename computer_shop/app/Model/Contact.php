<?php
App::uses('AppModel', 'Model');

class Contact extends AppModel {

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A name is required'
            )
        ),	
        'message' => array(
            'required' => array(
				'rule' => array('minLength', 8),
				'allowEmpty' => false,
                'message' => 'A message must be atleast 8 letter'
            )
        ),
		'email' => array(
			'required' => array(
				'rule' => array('email'),
				'message' => 'Kindly provide your email for verification.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Email cannot be more than 255 characters.'
			)
		)		
    );
}