<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class BrandsController extends AppController {
	var $uses = array('Brand', 'Page', 'Image', 'Classification');
	var $thisModel = 'Brand';
	var $thisAssocModel = 'Image';
	var $thisAssocModel2 = 'Classification';
	var $thisController = 'brands';

	
	public function beforeFilter() {
		
		parent::beforeFilter();

	}
	
    public function index() {
	
		return $this->redirect(array('controller'=>'users','action' => 'login'));
		
	}	
	

    public function admin_index() {	
		$model = $this->thisModel;
		$this->paginate = array(
		    'limit' => 20,
			'order' => array(
			$model.'.id' => 'asc'
			)			
		);
		
		$data = $this->paginate($model);
		$this->set($this->thisController, $data);
		$this->set('model', $model);
		$this->set('controller', $this->thisController);
    }	
	

	public function admin_toggle ($id=null, $model, $field='active') {
		
		if (empty($id)||empty($id)) { return false;}
		
		if($this->request->is('get')) {
			$this->Flash->success(__('Action not allowed'));
			$this->redirect(array('action' => 'index'));
		}
		
		$model=$this->thisModel;
		$data = array($model=>array('id'=>$id,$field=>1));
		
		$lastChar=substr($model, -1);
		$tableName = strtolower($lastChar === 'y' ? substr($model,0,-1).'ies' : ($lastChar === 's' ? $model : $model.'s'));
		$query = sprintf("UPDATE `%s` SET `%s`= 1 - `%s` WHERE `id`='%u'", $tableName, $field, $field, $id);
		$action = $this->$model->query($query);

		if (is_array($action)){
			$this->Flash->success(__('field: '.$field.', changed (id='.$id.')')); 
		}		
		$this->redirect($this->referer());
		
	}	
	
	public function admin_view($id=null) {
		$model = $this->thisModel;
		$assocModel = $this->thisAssocModel;
		$assocModel2 = $this->thisAssocModel2;
		$data=$this->$model->find('first', array('conditions' => array($model.'.id'=>$id), 'contain' => $assocModel));
		if ($data) {
			$this->set($model, $data);
		}		
		
		$series=$this->$assocModel2->find('all', array('conditions' => array($assocModel2.'.brand_id' => $id)));
		
		$this->set('series', $series);
		$this->set('model', $model);
		$this->set('assocModel', $assocModel);
		$this->set('assocModel2', $assocModel2);
		$this->set('controller', $this->thisController);
	}
	
	public function admin_add() {

		$model = $this->thisModel;
		$assocModel = $this->thisAssocModel;

        if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->$model->save($this->request->data)) {
				$id = $this->$model->id;
                $this->Flash->success(__('Successfully added a new '.strtolower($model).''));
                return $this->redirect(array('controller'=> $this->thisController,'action' => 'view', $id));
            }

            $this->Flash->error(
                __('Something went wrong. Please, try again.')
            );
		}

		$this->set('model', $model);
		$this->set('assocModel', $assocModel);
		$this->set('controller', $this->thisController);	
	}
	
    public function admin_edit($id = null) {
	
		$model = $this->thisModel;
		$assocModel = $this->thisAssocModel;
		$data = $this->$model->find('first', array('conditions' => array($model.'.id' => $id), 'contain' => $assocModel));
		
		if ($data) {
			$this->set($model, $data);
		}
	
        if ($this->request->is('post') || $this->request->is('put')) {
			
			$this->request->data[$model]['id'] = $id;
			$this->request->data[$model]['image_id'] = $data[$model]['image_id'];
	
            if ($this->$model->save($this->request->data)) {
                $this->Flash->success(__('This '.strtolower($model).' has been changed'));
                return $this->redirect(array('action' => 'view', $id));
            }

            $this->Flash->error(
                __('The changes could not be saved. Please, try again.')
            );
		}

		$this->set('model', $model);
		$this->set('assocModel', $assocModel);
		$this->set('controller', $this->thisController);		
    }

	public function admin_delete($id = null) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$model = $this->thisModel;
			$data = $this->$model->findById($id);
			if (!$data) {
				$this->Flash->error(__('This brand not exist'));
				$this->redirect($this->referer());
			}
		  
			
			$imageId = $data[$model]['image_id']; 
			$brandImage = $this->Image->findById($imageId);
			$imagePath = WWW_ROOT.'img/brands/'.$brandImage['Image']['path']; 
			
			if ($imagePath) { unlink($imagePath); }
			if ($imageId) {   $this->Image->delete($imageId, false); }
			$this->$model->delete($id, true);
			$this->Flash->success(__('This '.strtolower($model).' was deleted'));
			$this->redirect($this->referer());
		}
	}
}
