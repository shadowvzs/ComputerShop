<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class AccessoriesController extends AppController {
	var $uses = array('Accessory', 'Page', 'Product');
	var $thisModel = 'Accessory';
	var $thisAssocModel = 'Product';
	var $thisController = 'Accessories';
	
	public function beforeFilter() {
		
		parent::beforeFilter();

	}
	
    public function index() {
	
		return $this->redirect(array('controller' => 'users','action' => 'login'));
		
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
	

	public function admin_toggle ($id=null, $model=null, $field='active') {
		if ($model === null) {$model = $this->thisModel;}
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
		$data=$this->$model->find('first', array('conditions' => array($model.'.id'=>$id), 'contain' => $assocModel));
		if ($data) {
			$this->set($model, $data);
		}		
		$this->set($assocModel, $this->$assocModel->find('list', array('conditions' => array('accessory_id' => $id))));
		$this->set('model', $model);
		$this->set('assocModel', $assocModel);
		$this->set('controller', $this->thisController);
	}


	public function admin_add() {

		$model = $this->thisModel;
		$assocModel = $this->thisAssocModel;

        if ($this->request->is('post') || $this->request->is('put')) {
			$data=$this->request->data;

            if ($this->$model->save($data)) {
				$id = $this->$model->id;
                $this->Flash->success(__('Successfully added a new '.strtolower($model).''));
                return $this->redirect(array('controller'=>$this->thisController,'action' => 'view', $id));
            }

            $this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		
		$this->set('brands', $this->$assocModel->find('list'));
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

			$data = $this->request->data;
			$data[$model]['id']=$id;

            if ($this->$model->save($data)) {
                $this->Flash->success(__('This '.strtolower($model).' has been changed'));
                return $this->redirect(array('action' => 'view', $id));
            }

            $this->Flash->error(
                __('The changes could not be saved. Please, try again.')
            );
		}
		
		$this->set('brands', $this->$assocModel->find('list'));
		$this->set('model', $model);
		$this->set('assocModel', $assocModel);
		$this->set('controller', $this->thisController);		
    }

	public function admin_delete($id = null) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$model = $this->thisModel;
			$assocModel = $this->thisAssocModel;
			$data = $this->$model->find('first', array('conditions' => array($model.'.id' => $id), 'contain' => $assocModel));
			if (!$data) {
				$this->Flash->error(__('This '.strtolower($model).' not exist'));
				$this->redirect($this->referer());
			}

			$this->$model->delete($id, false);
			$this->Flash->success(__('This '.strtolower($model).' was deleted'));
			$this->redirect($this->referer());
		}
	}
	
}
