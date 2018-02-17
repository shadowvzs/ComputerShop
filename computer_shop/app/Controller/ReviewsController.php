<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class ReviewsController extends AppController {
	var $uses = array('Product', 'Discount', 'Users', 'Review');
	var $thisModel = 'Review';

	
	public function beforeFilter() {
		
		parent::beforeFilter();

	}
	
    public function index() {
	
		return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		
	}	
	
    public function admin_index() {

		$model = $this->thisModel;
		$this->paginate = array(
		    'limit' => 20,
			'order' => array(
				$model.'.id' => 'asc'
			)			
		);
		
		$statistic = $this->$model->query("SELECT rate as rate, count(*) as count FROM `reviews` WHERE active = 1 GROUP BY rate");

		$data = $this->paginate($model);
		$this->set('reviews', $data);
		$this->set('statistic', $statistic);
		$this->set('model', $model);

    }	
	
	public function admin_view($id=null) {
		
		$model = 'Review';
		if ($data = $this->$model->findById($id)) {
			$data = array_merge ($data, 
								ClassRegistry::init('User')->findById($data[$model]['user_id']),
								ClassRegistry::init('Product')->findById($data[$model]['product_id'])
			);
			$this->set($model, $data);
			$this->set('model', $model);
		}else{
			return $this->redirect(array('controller' => 'reviews', 'action' => 'index'));
		}		
	}
		
	public function admin_delete($id=null) {
		
		$model = 'Review';
		if ($data = $this->$model->findById($id)) {
			$this->$model->delete($id);
			$this->Flash->success(__(' Record was added'));
		}	
		
		return $this->redirect(array('controller' => 'reviews', 'action' => 'index'));		
	}		
}