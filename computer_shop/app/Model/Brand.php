<?php
App::uses('AppModel', 'Model');

class Brand extends AppModel {
	public $actsAs = array(
			'Sluggable' => array(
                    'overwrite' => true,
                    'translation' => 'utf-8',
                    'label' => 'name'
            ),
	);
	
 	public $belongsTo = array(
		'Image' => array('className' => 'Image',
				'foreignKey' => 'image_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);	 
	public $hasMany = array('Classification' => array(
		'className' => 'Classification',
		'foreignKey' => 'brand_id',
		'dependent' => true,
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
				
				$newImageName = md5($newImage['name'] . date('m-d-Y H:i')) . '.' . end((explode('.', $newImage['name'])));
				if(move_uploaded_file($newImage['tmp_name'], 'img/brands/' . $newImageName) == true) {
					$Image = ClassRegistry::init('Image');
					$brandId = $this->id;
					if ($Image->save(array(
						'Image' => array (
								'path'=>$newImageName,
						)
					))) {
							$newImageId = $Image->id;

							if (!$created) {
								$oldRecord = $this->findById($this->data[$model]['id']);

								$oldImageId = $this->data[$model]['image_id'];
								$old_Image = $Image->findById($oldImageId);
								$path = WWW_ROOT.'img/brands/'.$old_Image['Image']['path'];
								if(file_exists($path)){
									unlink($path);
								}			
								
								$Image->delete($oldImageId);

							}			
		
							$this->query('UPDATE brands SET image_id='.$newImageId.' WHERE id='.$brandId);

					}
					
				} else {
					$this->Flash->error(__('Unable uploaded!'));
				}
			}
		}
    }	

}