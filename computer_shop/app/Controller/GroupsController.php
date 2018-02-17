<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class GroupsController extends AppController {
	var $uses = array('User', 'Group', 'Page');
	var $thisModel = 'Group';
	var $thisController = 'groups';

	
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
		
		$model = $this->thisModel;

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
		
		$my_group_id = $this->Auth->User('group_id');
		if ($id < $my_group_id) {$this->redirect(array('controller' => $this->thisController, 'action' => 'index'));}

		if ($data = $this->$model->find('first', array('conditions' => array('id' => $id)))) {
			$this->set($model, $data[$model]);
		}else{
			return $this->redirect(array('controller' => $this->thisController,'action' => 'index'));
		}		
		$this->set('model', $this->thisModel);
		$this->set('controller', $this->thisController);
	}
	
	public function admin_add() {
		$this->set('model', $this->thisModel);
		$this->set('controller', $this->thisController);		
	}
	
    public function admin_edit($id = null) {
		
		$this->set('model', $this->thisModel);
		$this->set('controller', $this->thisController);
		
		$my_group_id = $this->Auth->User('group_id');
		if ($id < $my_group_id) {$this->redirect(array('controller' => $this->thisController, 'action' => 'index'));}
		
		$model = $this->thisModel;
		if ($data = $this->$model->find('first', array('conditions' => array('id' => $id)))) {
			$this->set($model, $data[($this->thisModel)]);
		}else{
			return $this->redirect(array('controller' => $this->thisController, 'action' => 'index'));
		}
		
        if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data[$model]['id'] = $id;
            if ($this->$model->save($data)) {
                $this->Flash->success(__('The '.$lower_name.' has been changed'));
                return $this->redirect(array('action' => 'view', $id));
            }
			
            $this->Flash->error(
                __('The changes could not be saved. Please, try again.')
            );
        }		
    }	
}
