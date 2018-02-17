<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class FeedbacksController extends AppController {
	var $uses = array('Product', 'Feedback', 'Users', 'Review');
	var $thisModel = 'Review';

	
	public function beforeFilter() {
		
		parent::beforeFilter();

	}
	
	public function index() {
	
		return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		
	}	

	public function add() {

		$this->autoRender = false;

		if ($this->request->is('post') || $this->request->is('put')) {
			unset($this->request->data['_method']);
			echo ($this->Feedback->save($this->request->data)) ? $this->Feedback->id : "0";
		}

		die;
	}

	public function get() {

		$this->autoRender = false;

		if ($this->request->is('post') || $this->request->is('put')) {
			$product_id = $this->request->data["product_id"];
			$page = $this->request->data["page"] ;
			$perPage = $this->request->data["perPage"];
			$start = $page * $perPage;
			$feedbacks = $this->Feedback->find('all', array(
				'conditions' => array (
					'Feedback.product_id' => $product_id,
					'Feedback.active' => 1,
				),
				'recursive' => -1,
				'limit' => $perPage,
				'page' => $page,
				'order' => 'Feedback.created DESC',
				'contain' => 'User'
			));

			$count = $this->Feedback->find('count', array(
				'conditions' => array (
					'active' => '1', 
					'product_id' => $product_id
				)
			));

			$response = array( 'count' => $count, 'list' => $feedbacks);

			echo json_encode($response);

		}

		die;
	}	
	
	public function delete() {

		$this->autoRender = false;

		if ($this->request->is('post') || $this->request->is('put')) {
			$id = $this->request->data["id"];
			if (!$id || $id == 0 || !$record = $this->Feedback->findById($id)) { 
				die("0");
			}
			
			$myId = $this->Auth->user('id');
			$myGroupId = $this->Auth->user('group_id');

			if ($record['Feedback']['user_id'] == $myId || $myGroupId == 1) {
				$this->Feedback->delete($id);
				die("1");
			}else{
				die("0");
			}
		}
	}			
	
    public function admin_index() {	
	
		$model = "Feedback";
		$this->paginate = array(
		    'limit' => 20,
			'order' => array(
			$model.'.id' => 'asc'
			)			
		);
		
		$data = $this->paginate($model);
		$this->set($model, $data);
		$this->set('model', $model);

    }	
	
	public function admin_view($id=null) {
		
		$model = 'Feedback';

		if ($data = $this->$model->findById($id)) {
			$data = array_merge ($data, 
								ClassRegistry::init('User')->findById($data[$model]['user_id']),
								ClassRegistry::init('Product')->findById($data[$model]['product_id'])
			);
			$this->set($model, $data);
			$this->set('model', $model);
		}else{
			return $this->redirect(array('controller' => 'feedbacks', 'action' => 'index'));
		}		
	}
		
	public function admin_delete($id=null) {
		
		$model = 'Feedback';

		if ($this->$model->findById($id)) {
			$this->$model->delete($id);
			$this->Flash->success(__(' Record was added'));
		}	
		
		return $this->redirect(array('controller'=>'feedbacks','action' => 'index'));		
	}	
}