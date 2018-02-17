<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class OrdersController extends AppController {
	var $uses = array('User', 'Discount', 'Product', 'Page', 'Country', 'Order', 'OrdersProduct', 'Country');
	var $thisModel = 'Order';
	var $thisController = 'orders';

	
	public function beforeFilter() {
		
		parent::beforeFilter();

		$user_country_id = $this->Auth->user('country_id');
		$shop_country = $this->Country->find('first', array('conditions' => array('name' => 'Romania')));
		$shop_country_id = $shop_country['Country']['id'];
		$user_country = $this->Country->findById($user_country_id);
		
		$vat = $user_country_id === $shop_country_id ? $shop_country['Country']['vat'] : 0;
		$user_discount = $this->Auth->user('discount');
		$editLevel = 0;
		$this->set(compact('editLevel')); 	// this mean if not prepared for user then editable	
		$this->set(compact('vat'));
		$this->set(compact('user_discount'));
		$this->set('server_currency', $shop_country['Country']['currency']);
	}
	
    public function index() {

		$model = $this->thisModel;
		$user_id = $this->Auth->user('id');
		$this->paginate = array(
			'limit' => 10,
			'conditions' => array($model.'.user_id' => $user_id),
			'order' => array(
			$model.'.created' => 'desc'
			)			
		);
		$data = $this->paginate($model);
		$this->set($model, $data);
		$this->set('model',$model);
		
	}	

	public function view($id=null) {
		
		$model = $this->thisModel;
		$user_id = $this->Auth->user('id');

		if ($data = $this->$model->find('first', array('conditions' => array('id' => $id, 'user_id' => $user_id)))) {
			$data['OrdersProduct'] = $this->OrdersProduct->find('all', array('conditions' => array('order_id' => $data[$model]['id'])));
			$this->set($model, $data);
		}else{
			$this->Flash->error(__('Order not found...'));
			return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
		}		
		
		$this->set('model', $this->thisModel);
		
	}


	public function add() {

		$this->autoRender = false;

		$id = $this->Auth->user('id');
		$user = $this->User->findById($id); 	// a check if still exist the record

		if (!empty($user) && $user['User']['active'] == 1 && ($this->request->is('post') || $this->request->is('put'))) {

			$req = $this->request->data;
			$products = $this->Cart->readProduct();
			if (is_null($products) || empty($products)) { 
				$this->Flash->error(__('Select something if you want buy...'));
				return $this->redirect(array('controller'=>'products','action' => 'index'));
			}

			$clientType = $req['Cart']['clientType'];
			$paymentType = $req['Cart']['paymentType'];

			$allow1 = (trim($user['User']['city']) !== "" && trim($user['User']['address']) !== "" && trim($user['User']['phone']) !== "");
			$allow2 = true;
			$required_fields = ['city', 'address', 'phone'];

			if ($paymentType == 0) {
				// required stuff what only for post buying
			}elseif ($paymentType == 1){
				$allow1 = (trim($user['User']['bic']) !== "" && trim($user['User']['iban']) !== "");
				$required_fields = array_merge($required_fields, ['bic', 'iban']);
			}
			if ($clientType == 0) {
				// i dont know anything else what need for physical persons
			}elseif ($clientType == 1) {
				$allow2 = (trim($user['User']['company_name']) !== "" && trim($user['User']['number_coc']) !== "" && trim($user['User']['number_vat']) !== "");
				if (!$allow2) {
					$required_fields = array_merge($required_fields, ['company name', 'number coc', 'number vat']);
				}			
			}
			if (!$allow1 || !$allow2) {
				$this->Flash->error(__('Please fill the '.implode(', ',$required_fields).' fields in settings before make order'));
				return $this->redirect(array('controller' => 'carts', 'action' => 'view'));
			}

			$shop_country = $this->Country->find('first', array('conditions' => array('name' => 'Romania')));
			$shop_country_id = $shop_country['Country']['id'];
			$user_country_id = $user['User']['country_id'];
			$user_discount = $user['User']['discount'];
			$vat = ($user_country_id === $shop_country_id) ? $shop_country['Country']['vat'] : 0;
			
			$error = array();
			$orders = array();
			$final_wo_vat = 0;
			$final_with_vat = 0;
			$time = time();

			foreach ($products as $prod_id => $amount) {
				$product = $this->Product->findById($prod_id);

				if (empty($product)) {
					$error[] = __('Product not exist anymore');
					continue;
				}

				$disc = $product['Discount'];
				$item_discount = $disc['id'] ? intval($disc['price_modifier']) : 0;
				$time1 = strtotime($disc['start_date']);
				$time2 = strtotime($disc['end_date']);
				if ($time < $time1 || $time > $time2) {
					$item_discount = 0;
				}
				
				$price = $product['Product']['price'];
				$price_wo_vat = $price - ($price * ($item_discount+$user_discount) / 100);
				$price_wo_vat = (round($price_wo_vat * 100))/100;

				if ($vat > 0) {
					$price_w_vat = $price_wo_vat + ($price_wo_vat * $vat  / 100);
					$price_w_vat = (round($price_w_vat * 100))/100;
				}else{
					$price_w_vat = $price_wo_vat;
				}

				$stack_price_wo_vat = $price_wo_vat * $amount;
				$stack_price_w_vat = $price_w_vat * $amount;

				$final_wo_vat += $stack_price_wo_vat;
				$final_with_vat += $stack_price_w_vat;

				$orders[]=array('OrdersProduct' => array(
					'product_id' => $prod_id, 
					'amount' => $amount, 
					'price_sub' => $price_wo_vat, 
					'price' => $price_w_vat, 
					'product_name' => $product['Product']['name'],
				));

			}

			if (empty($error)) {
				$order = array ( 'Order' => array (
					'user_id' => $id,
					'price_sub_total' => $final_wo_vat,
					'price_vat' => ($final_with_vat - $final_wo_vat),
					'price_total' => $final_with_vat
				));

				$this->Order->save($order);
				$order_id = $this->Order->id; 
				foreach ($orders as $key => $prod) {
					$orders[$key]['OrdersProduct']['order_id'] = $order_id;
				}
				
				$this->OrdersProduct->saveMany($orders, array('deep' => true));
				$this->Cart->clearTable();
				$this->Flash->success(__('Order was sent, thank you for buying at us!'));
				return $this->redirect(array('controller' => 'orders','action' => 'view', $order_id));
			}else{
				$this->Flash->error(__(implode('<br>',$error)));
			}
		}else{
            $this->Flash->error(__('The changes could not be saved. Please, try again.'));
		}
		return $this->redirect(array('controller' => 'carts','action' => 'view'));

	}

	public function admin_add() {

		$this->autoRender = false;

		$id = $this->Auth->user('id');
		$user = $this->User->findById($id); 	// a check if still exist the record

		if (!empty($user) && $user['User']['active'] == 1 && ($this->request->is('post') || $this->request->is('put'))) {
			
			$products = $this->Cart->readProduct();
			if (is_null($products) || empty($products)) { 
				$this->Flash->error(__('Select something if you want buy...'));
				return $this->redirect(array('controller' => 'products', 'action' => 'index'));
			}			

			$req = $this->request->data;
			$clientType = $req['Cart']['clientType'];
			$paymentType = $req['Cart']['paymentType'];

			$allow1 = (trim($user['User']['city']) !== "" && trim($user['User']['address']) !== "" && trim($user['User']['phone']) !== "");
			$allow2 = true;
			
			$required_fields = ['city', 'address', 'phone'];

			if ($paymentType == 0) {
				// required stuff what only for post buying
			}elseif ($paymentType == 1){
				if ($allow1)
				$allow1 = (trim($user['User']['bic']) !== "" && trim($user['User']['iban']) !== "");
				$required_fields = array_merge($required_fields, ['bic', 'iban']);
			}
			if ($clientType == 0) {
				// i dont know anything else what need for physical persons
			}elseif($clientType == 1) {
				$allow2 = (trim($user['User']['company_name']) !== "" && trim($user['User']['number_coc']) !== "" && trim($user['User']['number_vat']) !== "");
				if (!$allow2) {
					$required_fields = array_merge($required_fields, ['company name', 'number coc', 'number vat']);
				}			
			}
			if (!$allow1 || $allow2) {
				$this->Flash->error(__('Please fill the '.implode(', ',$required_fields).' fields in settings before make order'));
				return $this->redirect(array('controller'=>'carts','action' => 'view'));
			}

			$shop_country = $this->Country->find('first', array('conditions' => array('name' => 'Romania')));
			$shop_country_id = $shop_country['Country']['id'];
			$user_country_id = $user['User']['country_id'];
			$user_discount = $user['User']['discount'];
			$vat = ($user_country_id === $shop_country_id) ? $shop_country['Country']['vat'] : 0;
			
			$error = array();
			$orders = array();
			$final_wo_vat = 0;
			$final_with_vat = 0;
			$time = time();

			foreach ($products as $prod_id => $amount) {
				$product = $this->Product->findById($prod_id);

				if (empty($product)) {
					$error[] = __('Product not exist anymore'.' #'.$prod_id);
					continue;
				}

				$disc = $product['Discount'];
				$item_discount = $disc['id'] ? intval($disc['price_modifier']) : 0;
				$time1 = strtotime($disc['start_date']);
				$time2 = strtotime($disc['end_date']);
				if ($time < $time1 || $time > $time2) {
					$item_discount = 0;
				}
				
				$price = $product['Product']['price'];
				$price_wo_vat = $price - ($price * ($item_discount+$user_discount) / 100);
				$price_wo_vat = (round($price_wo_vat * 100))/100;

				if ($vat > 0) {
					$price_w_vat = $price_wo_vat + ($price_wo_vat * $vat  / 100);
					$price_w_vat = (round($price_w_vat * 100))/100;
				}else{
					$price_w_vat = $price_wo_vat;
				}

				$stack_price_wo_vat = $price_wo_vat * $amount;
				$stack_price_w_vat = $price_w_vat * $amount;

				$final_wo_vat += $stack_price_wo_vat;
				$final_with_vat += $stack_price_w_vat;

				$orders[]=array('OrdersProduct' => array(
					'product_id' => $prod_id, 
					'amount' => $amount, 
					'price_sub' => $price_wo_vat, 
					'price' => $price_w_vat, 
					'product_name' => $product['Product']['name'],
				));

			}

			if (empty($error)) {
				$order = array ( 'Order' => array (
					'user_id' => $id,
					'price_sub_total' => $final_wo_vat,
					'price_vat' => ($final_with_vat - $final_wo_vat),
					'price_total' => $final_with_vat
				));

				$this->Order->save($order);
				$order_id = $this->Order->id; 
				foreach ($orders as $key => $prod) {
					$orders[$key]['OrdersProduct']['order_id'] = $order_id;
				}
				
				$this->OrdersProduct->saveMany($orders, array('deep' => true));
				$this->Cart->clearTable();
				$this->Flash->success(__('Order was sent, thank you for buying at us!'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'view', $order_id));
			}else{
				$this->Flash->error(__(implode('<br>',$error)));
			}
		}else{
            $this->Flash->error(__('The changes could not be saved. Please, try again.'));
		}
		return $this->redirect(array('controller' => 'carts', 'action' => 'view'));

	}

	public function edit($id=null) {
		
		$model = $this->thisModel;
		$user_id = $this->Auth->user('id');

		if (!$data=$this->$model->find('first', array('conditions' => array('id' => $id, 'user_id' => $user_id)))) {
			$this->Flash->error(__('Order not found...'));
			return $this->redirect(array('controller'=>'orders','action' => 'index'));
		}

		$editLevel = $this->editLevel;
		
		if (intval($data[$model]['status']) > $editLevel) {
			$this->Flash->error(__('Order not editable ...'));
			return $this->redirect(array('controller' => 'orders','action' => 'view', $id));
		}

		$data['OrdersProduct'] = $this->OrdersProduct -> find('all', array('conditions' => array('order_id' => $data[$model]['id'])));
		$this->set($model, $data);


		if ($this->request->is('post') || $this->request->is('put')){
			$oldData = $data['OrdersProduct'];
			$reqData = $this->request->data['Order'];
			$newData = array();
			
			foreach ( $reqData as $key => $val ) {
		
				if (substr($key, 0,9) === "order_id_"){
					$newKey = substr($key,9);
					$newData[$newKey] = $val < 0 ? 0 : $val;
				}
			}

			if (count($oldData) != count($newData)) {
				$this->Flash->error(__('Ordered products not matching ...'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'view', $id));
			}

			$total_wo_vat = 0;
			$total_w_vat = 0;
			$difference = 0;
			$orders = array();
			$delete = array();

			foreach ( $oldData as $order_prod ) {
			
				$order_prod = $order_prod['OrdersProduct'];

				if (!isset($newData[$order_prod['id']])) { continue; }
				
				$new_amount = intval($newData[$order_prod['id']]);
				$diff = $new_amount - intval($order_prod['amount']) ;
				
				if ($diff !== 0){

					$total_wo_vat += $order_prod['price_sub'] * $diff;
					$total_w_vat += $order_prod['price'] * $diff;
					$difference++;

					if ($new_amount === 0) {
						$delete[] =  $order_prod['id'];
					}else{
						$orders[]=array('OrdersProduct' => array(
							'id' => $order_prod['id'], 
							'amount' => $new_amount
						));
					}
					
				}
			}

			if ($difference > 0) {
				if (!empty($orders)) {
					$this->OrdersProduct->saveMany($orders);
				}

				if (!empty($delete)){

					foreach($delete as $delID) {
						$this->OrdersProduct->delete($delID);
					}
					if (count($delete) === count($oldData)) {
						$this->Order->delete($id);
						$this->Flash->success(__('Order deleted!'));
						return $this->redirect(array('controller' => 'orders', 'action' => 'index'));						
					}
				}
				unset ($data['OrdersProduct']);
				$data[$model]['price_sub_total'] +=  $total_wo_vat;
				$data[$model]['price_total'] +=  $total_w_vat;
				$data[$model]['price_vat'] +=  $total_w_vat-$total_wo_vat;
				$this->Order->save($data);
				$this->Flash->success(__('Order saved, '.$difference.' product was changed in order!'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'view', $id));
			}

		}

		$this->set('model', $this->thisModel);
		
	}


    public function admin_index() {	

		$model = $this->thisModel;
		$user_id = $this->Auth->user('id');

		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$order_id = $data['Order']['order_id'];

			if ((strlen($order_id) < 2) || (substr($order_id,0,1) !== "#")) {
				$this->Flash->error(__('Search with valid id like: #123'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
			}

			$order_id = intval(substr($order_id,1));
			$data = $this->$model->findById($order_id);

			if (empty($data)) {
				$this->Flash->error(__('Order not exist'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
			}else{
				return $this->redirect(array('controller' => 'orders', 'action' => 'view', $order_id));
			}
		}
	
		$this->paginate = array(
			'limit' => 10,
			'order' => array(
			$model.'.created' => 'desc'
			)			
		);
		$data = $this->paginate($model);
		$this->set($model, $data);
		$this->set('model',$model);
    }	
	

	public function admin_view($id=null) {

		$model = $this->thisModel;

		if ($data = $this->$model->findById($id)) {
			$data['OrdersProduct']=$this->OrdersProduct->find('all', array('conditions' => array('order_id' => $data[$model]['id'])));
			$user_id = $data[$model]['user_id'];
			$user = $this->User->findById($user_id);
			$this->set($model, $data);
			$this->set('user', $user);
		}else{
			return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
		}		
		
		$this->set('model', $this->thisModel);

	}
	
	public function admin_edit($id=null) {
		
		$model = $this->thisModel;
		$user_id = $this->Auth->user('id');

		if (!$data = $this->$model->findById($id)) {
			$this->Flash->error(__('Order not found...'));
			return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
		}

		$editLevel = $this->editLevel;

		$data['OrdersProduct'] = $this->OrdersProduct->find('all', array('conditions' => array('order_id' => $data[$model]['id'])));
		$this->set($model, $data);


		if ($this->request->is('post') || $this->request->is('put')){
			$oldData = $data['OrdersProduct'];
			$reqData = $this->request->data['Order'];
			$data[$model]['status'] = $reqData['status'];
			$data[$model]['active'] = $reqData['active'];
			if ($reqData['status'] > 2) {
				$data[$model]['finished'] = date("Y-m-d H:i:s");
			}
			$newData = array();
			
			foreach ( $reqData as $key => $val ) {
		
				if (substr($key, 0,9) === "order_id_"){
					$newKey = substr($key,9);
					$newData[$newKey] = $val < 0 ? 0 : $val;
				}
			}

			if (count($oldData) != count($newData)) {
				$this->Flash->error(__('Ordered products not matching ...'));
				return $this->redirect(array('controller'=>'orders','action' => 'view', $id));
			}

			$total_wo_vat = 0;
			$total_w_vat = 0;
			$difference = 0;
			$orders = array();
			$delete = array();

			foreach ( $oldData as $order_prod ) {
			
				$order_prod = $order_prod['OrdersProduct'];

				if (!isset($newData[$order_prod['id']])) { continue; }
				
				$new_amount = intval($newData[$order_prod['id']]);
				$diff = $new_amount - intval($order_prod['amount']) ;
				
				if ($diff !== 0){

					$total_wo_vat += $order_prod['price_sub'] * $diff;
					$total_w_vat += $order_prod['price'] * $diff;
					$difference++;

					if ($new_amount === 0) {
						$delete[] =  $order_prod['id'];
					}else{
						$orders[]=array('OrdersProduct' => array(
							'id' => $order_prod['id'], 
							'amount' => $new_amount
						));
					}
					
				}
			}

			unset ($data['OrdersProduct']);

			if ($difference > 0) {
				if (!empty($orders)) {
					$this->OrdersProduct->saveMany($orders);
				}

				if (!empty($delete)){

					foreach($delete as $delID) {
						$this->OrdersProduct->delete($delID);
					}
					if (count($delete) === count($oldData)) {
						$this->Order->delete($id);
						$this->Flash->success(__('Order deleted!'));
						return $this->redirect(array('controller' => 'orders', 'action' => 'index'));						
					}
				}
				
				$data[$model]['price_sub_total'] +=  $total_wo_vat;
				$data[$model]['price_total'] +=  $total_w_vat;
				$data[$model]['price_vat'] +=  $total_w_vat-$total_wo_vat;
			}

			$this->Order->save($data);
			$this->Flash->success(__('Order saved, '.$difference.' product was changed in order!'));
			return $this->redirect(array('controller' => 'orders', 'action' => 'view', $id));			

		}

		$this->set('model', $this->thisModel);
		
	}

}
