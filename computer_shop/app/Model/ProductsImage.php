<?php
App::uses('AppModel', 'Model');

class ProductsImage extends AppModel {

	public function beforeSave($options = array()) {

        $model = get_class($this);
        
		if (isset($this->data[$model]['file'])) {

            $image = $this->data[$model]['file']['image'];
			$this -> upload_image = ($image['size'] > 0 && $image['error'] === 0) ? $image : false;
            unset ($this->data[$model]['file']);
            $newImage = $this->upload_image;
            $newImageName = md5($newImage['name'] . date('m-d-Y H:i')) . '.' . end((explode('.', $newImage['name'])));
            $this->data['ProductsImage']['name'] = $newImageName;
            return (move_uploaded_file($newImage['tmp_name'], 'img/products/' . $newImageName) == true);
	         
        }
		return false;
    }

}