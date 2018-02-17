<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class PagesController extends AppController {
	var $uses = array('Page');
	var $thisModel = 'Page';

	
	public function beforeFilter() {
		$this->Auth->allow('view');
		parent::beforeFilter();

	}
	
    public function index() {
	
		return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		
	}	

	public function view($slug=null){
		if (!$slug) {
			//throw new notFoundException(__('Page not found'));
		}
		$page = $this->Page->find('first', array(
			'conditions' => array(
				'Page.slug' => $slug
			)
		));
		$this->set('page', $page);
	}

	public function terms(){

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
		if (empty($id) || empty($id)) { return false;}
		
		if($this->request->is('get')) {
			$this->Flash->success(__('Action not allowed'));
			$this->redirect(array('action' => 'index'));
		}
		
		$model=$this->thisModel;
		
		$lastChar = substr($model, -1);
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
		if ($data = $this->$model->find('first', array('conditions' => array('id' => $id)))) {
			$this->set($model, $data);
		}		
		$this->set('model', $model);
		$this->set('controller', $this->thisController);
	}
	
	public function admin_add() {

		$model = $this->thisModel;

        if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;

            if ($this->$model->save($data)) {
				$id = $this->$model->id;
                $this->Flash->success(__('Successfully added a new '.strtolower($model).''));
                return $this->redirect(array('controller' => $this->thisController,'action' => 'view', $id));
            }

            $this->Flash->error(
                __('Something went wrong. Please, try again.')
            );
		}
		
		$this->set('model', $model);
		$this->set('controller', $this->thisController);	
	}
	
    public function admin_edit($id = null) {
	
		$model = $this->thisModel;
		$data=$this->$model->find('first', array('conditions' => array('id' => $id)));
		if ($data) {
			$this->set($model, $data);
		}else{ return $this->redirect(array('action' => 'index')); }

        if ($this->request->is('post') || $this->request->is('put')) {

			$data=$this->request->data;
			$data[$model]['id']=$id;

            if ($this->$model->save($data)) {
                $this->Flash->success(__('This '.strtolower($model).' has been changed'));
                return $this->redirect(array('action' => 'view', $id));
            }

            $this->Flash->error(
                __('The changes could not be saved. Please, try again.')
            );
		}
		
		$this->set('model', $model);
		$this->set('controller', $this->thisController);		
    }

	public function admin_delete($id = null) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$model = $this->thisModel;
			$assocModel = $this->thisAssocModel;
			if (!$data = $this->$model->find('first', array('conditions' => array($model.'.id' => $id), 'contain' => $assocModel))) {
				$this->Flash->error(__('This '.strtolower($model).' not exist'));
				$this->redirect($this->referer());
			}

			$this->$model->delete($id);
			$this->Flash->success(__('This '.strtolower($model).' was deleted'));
			$this->redirect($this->referer());
		}
	}
	
	public function admin_remove_from_list ($id=null,$field=null) {
		
		if (!$id || !$field) { 
			return $this->redirect($this->referer()); 
		}
		$model = $this->thisModel;
		if (!$data = $this->$model->find('first', array('conditions' => array('id' => $id)))) { 
			$this->Flash->error(__('Series not exist')); 
			return $this->redirect($this->referer()); 
		}

		$data[$model][$field] = null;
		$this->$model->save($data);
		$this->redirect($this->referer());
		$this->Flash->success(__('Removed from list')); 
	}	
		
}
