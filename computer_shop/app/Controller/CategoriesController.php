<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class CategoriesController extends AppController {
	var $uses = array('Category', 'Page');
	var $thisModel = 'Category';
	var $thisController = 'categories';

	
	public function beforeFilter() {
		
		parent::beforeFilter();

	}
	
    public function index() {
	
		return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		
	}	
	
    public function admin_index() {	
    	
		$model = $this->thisModel;
		$allCat = $this->$model->getAllCategory();
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data[$model];
			extract($data, EXTR_PREFIX_SAME, "wddx");
			$order1 = explode(',', $order1);
			$order2 = explode(',', $order2);
			$diff = array_flip(array_diff_assoc($order2, $order1));
			$count = count($diff);
			if ($count > 0){
				$records = array();
				foreach($diff as $key => $value) {
					$records[] = array($model => array('id' => $key, 'order'=> $value));
				}
				if ($this->$model->saveMany($records, array('deep' => true))){
					$this->Flash->success(__('List was changed'));
					$this->redirect($this->referer());
				}
			}
    	}
		
    	$this->set($model, $allCat);
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
		
		$model = $this->thisModel;
		$data = array($model=>array('id'=>$id,$field=>1));
		
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
		$data = $this->$model->findById($id);

		if ($data) {
			$this->set($model, $data);
			if (intval($data[$model]['parent_id']) > 0) {
				$this->set($model.'_parent', $data['Parent']);
			}else{
				$this->set($model.'_sub', $data['Child']);
			}
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
		
		$this->set('categories', $this->$model->find('list'));
		$this->set('model', $model);
		$this->set('controller', $this->thisController);	
	}
	
    public function admin_edit($id = null) {
	
    	$model = $this->thisModel;
    	$data = $this->$model->find('first', array('conditions' => array($model.'.id' => $id)));
    	
    	if ($data) {
    		$this->set($model, $data);
    		if (intval($data[$model]['parent_id']) > 0) {
    			$this->set($model.'_parent', $this->$model->findById($data[$model]['parent_id']));
    		}
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
		
		$this->set('model', $model);
		$this->set('controller', $this->thisController);
		$this->set('categories', $this->$model->find('list'));
    }

	public function admin_delete($id = null) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$model = $this->thisModel;
			$assocModel = $this->thisAssocModel;
			$data = $this->$model->find('first', array('conditions' => array($model.'.id' => $id), 'contain'=>$assocModel));
			if (!$data) {
				$this->Flash->error(__('This '.strtolower($model).' not exist'));
				$this->redirect($this->referer());
			}

			$this->$model->delete($id, false);
			$this->Flash->success(__('This '.strtolower($model).' was deleted'));
			$this->redirect($this->referer());
		}
	}
	
	public function admin_remove_from_list ($id=null,$field=null) {
		
		if (!$id || !$field) { return $this->redirect($this->referer()); }
		$model=$this->thisModel;
		$data=$this->$model->find('first', array('conditions' => array('id' => $id)));
		if (!$data) { $this->Flash->error(__('Category not exist')); $this->redirect($this->referer()); }
		
		$data[$model][$field]=null;
		$this->$model->save($data);
		$this->redirect($this->referer());
		$this->Flash->success(__('Removed from list'));
	}	
	
}
