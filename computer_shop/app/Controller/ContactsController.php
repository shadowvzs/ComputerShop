<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ContactsController extends AppController {
	
	var $uses = array('User', 'Product', 'Order', 'Contact', 'Group', 'Page', 'Discount');
	
	public function beforeFilter() {
		
        parent::beforeFilter();
		$this->Auth->allow('add');
		
	}
	
    public function index() {
	
		return $this->redirect(array('controller'=>'contacts','action' => 'add'));
    
	}	
	
	public function add() {
		
		if ($this->request->is('post')) {
            $this->Contact->create();
            if ($this->Contact->save($this->request->data)) {
                $this->Flash->success(__('The message was sent'));
                return $this->redirect(array('action' => 'index'));
            }else{
				$this->Flash->error(__('Cannot send this message...'));
			}			
		}		
	}
	
	public function getLastRecords($table, $col, $limit) {
		return $this->$table->find('all', array(
			'limit' => $limit,
			'order' => $table.'.'.$col.' DESC' )
		);
	}
	
	
    public function admin_index() {	
	
		$this->paginate = array(
		    'limit' => 10,
			'order' => array(
			'Contact.title' => 'desc'
			)			
		);
		$data = $this->paginate('Contact');
		$this->set('contacts', $data);
    }	
	
    public function admin_dashboard() {	
	
		$this->set('users', $this->getLastRecords('User', 'created', 10));
		$this->set('contacts', $this->getLastRecords('Contact', 'created', 10));
		$this->set('groups', $this->getLastRecords('Group', 'created', 10));
		$this->set('orders', $this->getLastRecords('Order', 'created', 10));
		$this->set('products', $this->getLastRecords('Product', 'created', 10));
		$this->set('discounts', $this->getLastRecords('Discount', 'end_date', 10));
		
    }	

	public function admin_toggle ($id=null, $model=null, $field='active') {
		
		if (empty($id)||empty($id)) { return false;}
		
		if($this->request->is('get')) {
			$this->Flash->success(__('Action not allowed'));
			$this->redirect(array('action' => 'index'));
		}
		
		$model=ucfirst(strtolower($model));
		$data = array($model=>array('id' => $id, $field => 1));
		
		$lastChar=substr($model, -1);
		$tableName = strtolower($lastChar === 'y' ? substr($model,0,-1).'ies' : ($lastChar === 's' ? $model : $model.'s'));
		$query = sprintf("UPDATE `%s` SET `%s`= 1 - `%s` WHERE `id`='%u'", $tableName, $field, $field, $id);
		$action = $this->$model->query($query);
		//$Ad = ClassRegistry::init('Ad'); $Ad->AssociatedModel->find()	<- other way	
		if (is_array($action)){
			$this->Flash->success(__('field: '.$field.', changed (id='.$id.')')); 
		}		
		$this->redirect($this->referer());
	}	
	
	public function admin_view($id=null) {
		
		$messages=$this->Contact->find('first', array('conditions' => array('id' => $id)));
		if ($messages) {
			$this->set('messages', $messages);
		}
		
		if ($this->request->is('post')) {
			$contact = $this->Contact->find('first', array('conditions' => array('id' => $id)));
			if (!$contact) {return;}
			$contact=$contact['Contact'];
			$name=$contact['name'];
			$data=$this->request->data['Contact'];
			$to = $data['email'];
			$msg=$data['textarea'];
			$sender = 'shadowvzs@hotmail.com';
			$host='localhost';
			$emailMessage='Dear '.$name.', thank you for message, we allways care about our clients, so this is our answer message: <br><br>'.$msg.'<br><br>Please do not reply to this mail.<br>With best regards <b>Computer Shop Team</b>!';
			$Email = new CakeEmail();
			$Email->emailFormat('html')
				->to($to)
				->subject('Answer from Computer Shop Team')
				->from($sender)
				->send($emailMessage);
			$this->Flash->success(__(' Mail sent '));	
			$this->redirect($this->referer());		
		}			
	}
	
	public function admin_add() {
		$this->redirect(array('controller'=>'contacts','action' => 'index'));
		
	}
	
    public function admin_edit($id = null) {
		
		$messages=$this->Contact->find('first', array('conditions' => array('id' => $id)));
		if ($messages) {
			$this->set('messages', $messages);
		}
		
    }	
}
