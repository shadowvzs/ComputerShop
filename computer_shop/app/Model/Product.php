<?php
App::uses('AppModel', 'Model');

class Product extends AppModel {

	public $actsAs = array(
			'Sluggable' => array(
                    'overwrite' => true,
                    'translation' => 'utf-8',
                    'label' => 'name'
            ),
			'Containable'
	);	
	
	public $recursive = 1;
	
    public $validate = array(
        'price' => array(
			'rule' => array('comparison', '>=', 1),
			'message' => 'Must be at least 18 years old to qualify.'
		),
        'name' => array(
			'rule'=>'notBlank',
			'message' => 'Cannot be empty.'
		),
    );
	
	public $belongsTo = array(
		'Classification' => array('className' => 'Classification',
				'foreignKey' => 'classification_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),
		'Accessory' => array('className' => 'Accessory',
				'foreignKey' => 'accessory_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),
		'ProductsImage' => array('className' => 'ProductsImage',
				'foreignKey' => 'cover_image_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),
		'Discount' => array('className' => 'Discount',
				'foreignKey' => 'discount_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),			
		'Brand' => array('className' => 'Brand',
				'foreignKey' => 'brand_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),			
		'Category' => array('className' => 'Category',
				'foreignKey' => 'category_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),			
	);	  

	public function beforeSave($options = array()) {

		$model = get_class($this);
		if (isset($this->data[$model]['file'])) {
			$image = $this->data[$model]['file']['image'];
			$this -> upload_image = ($image['size'] > 0 && $image['error'] === 0) ? $image : false;
			unset ($this->data[$model]['file']);
        }
		return true;
    }
    
    public function afterSave($created, $options = array()) {

		$model = get_class($this);
		if ($created || $this->data[$model]['id']) {

			$newImage = $this -> upload_image;
			if ($newImage) {
				
				$ProductsImage = ClassRegistry::init('ProductsImage');
				$newImageName = md5($newImage['name'] . date('m-d-Y H:i')) . '.' . end((explode('.', $newImage['name'])));
				if(move_uploaded_file($newImage['tmp_name'], 'img/products/' . $newImageName) == true) {
					
					$productId = $this->id;
					if ($ProductsImage->save(array (
						'ProductsImage' => array (
								'name'=>$newImageName,
								'product_id' => $productId
						)
					))) {
					
						if (!isset($this->data['cover_image_id']) || !($this->data['cover_image_id']>0)) {
							$this->query('UPDATE products SET cover_image_id='.$ProductsImage->id.' WHERE id='.$productId);
						}
					}
					
				} else {
					$this->Flash->error(__('Unable uploaded!'));
				}
			}
		}

    }
	
}