<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('AuthComponent', 'Controller/Component');

class UsersController extends AppController {
	
	var $uses = array('User', 'Group', 'Country');
	var $thisModel = 'User';
	var $thisController = 'users';
	
    public $components = array(
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            )
        )
    );
	
	public function beforeFilter() {

        parent::beforeFilter();
		$this->Auth->allow('login','logout','add','index','activate', 'recover', 'reset', 'activation_mail');
		//lets remove the admin prefix if user isn't loggin and use admin prefix
		
		if((!$this->Auth->loggedIn()) && (!empty($this->params['admin']))){
			$action = $this->request->params['action'];
			if (substr($action,-5) !== 'index') {
				$this->redirect(array('controller' => 'products', 'action' => 'index', 'admin' => false));
			}
		}
		
    }
	
    public function index() {
		return $this->redirect(array('controller'=>'products','action' => 'index'));
    }
	
    public function view() {
		
		if ($user = $this->User->findById($this->Auth->user('id'))) {
			
			$country_id=$user['User']['country_id'];
			$country='';
			if ($country_id > 0) {
				$country = $this->Country->findById($country_id);
			}
			$this->set('groups', $this->Group->find('list'));
			$this->set('user', $user['User']);
			$this->set('country', $country['Country']);
		}else{
			return $this->redirect(array('controller' => $this->thisController, 'action' => 'index'));
		}
	}

	public function activation_mail() {

		if ($this->request->is('post')) {
			$this->User->setValidation('recover');	//same verification than recover because same fields
			$data = $this->request->data['User'];
			
			if (empty($user = $this->User->find('first', array(
				'conditions'=>array(
					'username'=>$data['username'],
					'email'=>$data['email']
				)
			)))) { 
				$this->Flash->error(__('User not exist')); 
			}

			$regHash = md5(uniqid());
			$data['creation_hash'] = $regHash;
			$data['id'] = $user['User']['id'];
			$record = array('User' => $data);
			
            if ($this->User->save($record)) {
				$to = $data['email'];
				$id = $user['User']['id'];
				$sender = 'shadowvzs@hotmail.com';
				$host ='localhost';
				$activationLink = "<a href='http://".$host."/computer_shop/activate/".$regHash."/".$id."'> Activate </a>";
				$emailMessage='Hello<br>You got the message because you requested the activation mail sending option on <b>Computer Shop</b> website, you must activate with following link:<br>'.$activationLink;
				$Email = new CakeEmail();
				$Email->emailFormat('html')
					->to($to)
					->subject('Email activation for user account')
					->from($sender)
					->send($emailMessage);
                $this->Flash->success(__('Activation mail was sent to '.$to));
            }else{
				$this->Flash->error(__('Invalid data'));
			}			
		}

	}

	
    public function add() {
		
		$countries = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'country']);
		$this->set('countries',$countries);
		
        if ($this->request->is('post')) {
			$this->User->setValidation('registration');
			
            $this->User->create();
			$pw = $this->request->data['User']['password'];
			// default settings for new account, [active=0=required activation, creation_hash=...=activator hash]
			$this->request->data['User']['active'] = 0;
			$regHash = md5(uniqid());
			$this->request->data['User']['creation_hash'] = $regHash;
			//---- till here -----
            if ($this->User->save($this->request->data)) {
				$user = $this->request->data['User'];
				$to = $user['email'];
				$name = $user['username'];
				$id = $this->User->id;
				$sender = 'shadowvzs@hotmail.com';
				$host ='localhost';
				$activationLink = "<a href='http://".$host."/computer_shop/activate/".$regHash."/".$id."'> Activate </a>";
				$emailMessage ='Hello<br>You got the message because your email address was registered with <b>'.$name.'</b> name on <b>Computer Shop</b> website, but account registration must be confirmed by the following link:<br>'.$activationLink;
				$Email = new CakeEmail();
				$Email->emailFormat('html')
					->to($to)
					->subject('Email activation for registration')
					->from($sender)
					->send($emailMessage);
                $this->Flash->success(__('Confirmation mail was sent to '.$to));
            }else{
				$this->Flash->error(__('Invalid data'));
			}
		}
    }
	
    public function edit() {

        if (!$id=$this->Auth->user('id') || !$user=$this->User->findById($this->Auth->user('id'))) { 
			return $this->redirect(array('controller'=>$this->thisController,'action' => 'index')) ; 
		}
		$countries = $this->Country->find('list', array('fields' => array('id', 'country')));
		$this->set('countries',$countries);

		
        if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['User']['id'] = $id;
            if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('controller' => 'users', 'action' => 'view', $id));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else if ($user) {
			$groups = $this->Group->find('list' );
			$my_group_id = $this->Auth->User('group_id');
			$this->set('groups', array_slice($groups,$my_group_id,count($groups),true));
			$this->set('user', $user['User']);			
 		}	
		
    }
	
	public function activate() {

		if (isset($this->request->params['hash'])&&isset($this->request->params['id'])){
			$hash = $this->request->params['hash'];
			$id = $this->request->params['id'];

			if ($user=$this->User->find('first', array('conditions' => array('id' => $id,'creation_hash' => $hash)))){
				$status=$user['User']['active'];
				if ($status == 0){
					$this->User->id = $id;                
					$this->User->set(array('active' => 1));                
					$this->User->save();
					$this->Flash->success(__('Account registration was confirmed!'));					
				}elseif($status==1){
					$this->Flash->error(__('Account already activated!'));
				}else{
					$this->Flash->error(__('Account cannot activated!'));
				}
			}else{
				$this->Flash->error(__('Wrong activation code or user not exist'));
			}
		}
		$this->redirect(array('action' => 'login'));
	}
	
	public function reset() {

		if (isset($this->request->params['hash']) && isset($this->request->params['id'])){
			$hash = $this->request->params['hash'];
			$id = $this->request->params['id'];
			if ($user = $this->User->find('first', array('conditions' => array('id' => $id,'recovery_hash' => $hash)))){

				if ($user['User']['active']==0) {
					$this->Flash->error( __('Error: account not activated...'));
					return $this->redirect(array('controller' => 'users','action' => 'login'));
				}				
				$passwordHasher = new BlowfishPasswordHasher();
				$newPassword = substr(uniqid(), 0, 8);
				$hashedPassword = $passwordHasher->hash($newPassword);
				$user['User']['password'] = $hashedPassword;
				$user['User']['recovery_hash'] = null;
				if ($this->User->save($user)) {
					$to = $user['User']['email'];
					$sender = 'shadowvzs@hotmail.com';
					$host='localhost';
					$emailMessage = 'Hello, you successfully changed your password, your new password is:<br>'.$newPassword;
					$Email = new CakeEmail();
					$Email->emailFormat('html')
						->to($to)
						->subject('New password')
						->from($sender)
						->send($emailMessage);
					$this->Flash->success(__('Mail sent with new password'));
				} else {
					$this->Flash->error(__('Reset mail failed to sent!'));
				}
				$this->redirect(array('action' => 'login'));
			}else{
				$this->Flash->error(__('Wrong activation code or user not exist'));
			}
		}
		$this->redirect(array('action' => 'login'));
	}	

    public function recover() {
		
	    if ($this->request->is('post')) {
			$this->User->setValidation('recover');
			$data = $this->request->data['User'];

			if ($user=$this->User->find('first', array('conditions'=>array('username' => $data['username'],'email' => $data['email'])))){
				
				$data['recovery_hash'] = md5(uniqid());
				$data['id'] = $user['User']['id'];
				$record['User'] = $data;

				if ($user['User']['active'] == 0) {

					$this->Flash->error( __('Error: account not activated...'));
					return $this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
				
				if ($this->User->save($record)){
				
					$to = $user['User']['email'];
					$id = $data['id'];
					$sender = 'shadowvzs@hotmail.com';
					$host ='localhost';
					$resetLink = "<a href='http://".$host."/computer_shop/reset/".$data['recovery_hash']."/".$id."'> Reset Password </a>";
					$emailMessage ='Hello<br>You got the message because you choosed the reset password option on our site, if you requested the password reset then please click to following link:<br>'.$resetLink;
					$Email = new CakeEmail();
					$Email->emailFormat('html')
						->to($to)
						->subject('Password reset request')
						->from($sender)
						->send($emailMessage);
		  
					$this->Flash->success(__(' Please verify your mail address '));
					return $this->redirect(array('controller'=>'users','action' => 'login'));
				}else{
					$this->Flash->error( __('Error at creating reset key'));
					return $this->redirect(array('controller'=>'users','action' => 'recover'));
				}

  			}
        }
    }
	
	
    public function login() {
		
	    if ($this->request->is('post')) {
			$this->User->setValidation('login');
            if ($this->Auth->login()) {
				if ($this->Auth->User('active') != 1 ) { 
					$this->Auth->logout();
					$this->Flash->error( __('User not activated!')); 
					return false;
				}
				$redirProp = intval($this->Auth->user('group_id')) === 1 ? ['contacts','dashboard',true] : ['products','index',false];
				$this->redirect(array('controller' => $redirProp[0],'action' => $redirProp[1], 'admin' => $redirProp[2]));
            } else {
				$this->Flash->error( __('Username or password incorrect'));
			}
        }
    }
	
	public function logout() {
		$this->Auth->logout();
		return $this->redirect($this->referer());
	}
	
    public function admin_index() {
		$this->paginate = array(
		    'limit' => 10,
			'order' => array(
			'User.title' => 'desc'
			)			
		);
		$data = $this->paginate('User');
        $this->set('users', $data);
    }

    public function admin_add() {
		$countries = $this->Country->find('list', array('fields' => array('id', 'country')));
		$this->set('countries',$countries);
		
        if ($this->request->is('post')) {
			$this->User->setValidation('registration');
            $this->User->create();
			$pw = $this->request->data['User']['password'];
			$this->request->data['User']['active']=1;
			$regHash = md5(uniqid());
			$this->request->data['User']['creation_hash']=$regHash;
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__(' Account created'));
            }else{
				$this->Flash->error(__('Invalid data'));
			}
			$this->redirect($this->referer());
		}
    }	
	
	public function admin_view($id=null) {
		
		$user = $this->User->findById($id);
		$country_id = $user['User']['country_id'];
		$country='';
		if ($country_id > 0) {$country=$this->Country->findById($country_id);}
		if ($user) {
			$this->set('groups', $this->Group->find('list'));
			$this->set('user', $user['User']);
			$this->set('country', $country['Country']);
		}else{
			return $this->redirect(array('controller' => $this->thisController, 'action' => 'index'));
		}
	}
	
    public function admin_edit($id = null) {

		$countries = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'country']);
		$this->set('countries',$countries);

		if (!$id) return;
        if (!$user = $this->User->findById($id)) { 
			return $this->redirect(array('controller' => $this->thisController, 'action' => 'index')) ; 
		}
		
        if ($this->request->is('post') || $this->request->is('put')) {
			$user_data = $this->request->data['User'];
			$user_data['id'] = $id;
            if ($this->User->save($user_data)) {
				$this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('controller'=>'users','action' => 'view', $id));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else if ($user) {
			$groups = $this->Group->find('list' );
			$my_group_id = $this->Auth->User('group_id');
			$this->set('groups', array_slice($groups,$my_group_id,count($groups),true));
			$this->set('user', $user['User']);			
 		}		
    }	
	
	
	public function admin_logout() {
		$this->Auth->logout();
		$this->redirect(array('controller' => 'products', 'action' => 'index'));
	}
		
	public function admin_toggle ($id=null, $model=null, $field='active') {
		
		if (empty($id) || empty($id)) { return false;}
		if($this->request->is('get')) {
			$this->Flash->success(__('Action not allowed'));
			$this->redirect(array('action' => 'index'));
		}
		$model = ucfirst(strtolower($model));
		$data = array($model => array('id' => $id, $field => 1));
		
		$lastChar = substr($model, -1);
		$tableName = strtolower($lastChar === 'y' ? substr($model,0,-1).'ies' : ($lastChar === 's' ? $model : $model.'s'));
		$query = sprintf("UPDATE `%s` SET `%s`= 1 - `%s` WHERE `id`='%u'", $tableName, $field, $field, $id);
		$action = $this->$model->query($query);
		if (is_array($action)){
			$this->Flash->success(__('field: '.$field.', changed (id='.$id.')')); 
		}		
		$this->redirect($this->referer());
	}	
}

