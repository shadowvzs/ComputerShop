<?php
App::uses('AppController', 'Controller');
 
class CartsController extends AppController {
    public $uses = array('Product','Cart','Country');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('update', 'view', 'add');
	}
     
    public function add() {
		
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->Cart->addProduct($this->request->data['Cart']['product_id']);
        }
        echo $this->Cart->getCount();
		
	}
	
	public function view() {
		
		$user_country_id = $this->Auth->user('country_id');
		$shop_country = $this->Country->find('first', array('conditions' => array('name' => 'Romania')));
		$shop_country_id = $shop_country['Country']['id'];
		$user_country = $this->Country->findById($user_country_id);
		
		$vat = $user_country_id === $shop_country_id ? $shop_country['Country']['vat'] : 0;
		$user_discount = $this->Auth->user('discount');
		$this->set(compact('vat'));
		$this->set(compact('user_discount'));
		$this->set('server_currency', $shop_country['Country']['currency']);
		
		$carts = $this->Cart->readProduct();
		$products = array();
		if (null!=$carts) {
			foreach ($carts as $productId => $count) {
				$product = $this->Product->read(null, $productId);
				$product['Product']['count'] = $count;
					$products[]=$product;
			}
		}
		$this->set(compact('products'));
	}
	
	public function update() {
		
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $cart = array();
                foreach ($this->request->data['Cart']['count'] as $index=>$count) {
                    if ($count>0) {
                        $productId = $this->request->data['Cart']['product_id'][$index];
                        $cart[$productId] = $count;
                    }
                }
                $this->Cart->saveProduct($cart);
            }else{
				 $this->Cart->clearTable();
			}
        }
        $this->redirect(array('action'=>'view'));
	}
	
    public function admin_add() {
		
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->Cart->addProduct($this->request->data['Cart']['product_id']);
        }
        echo $this->Cart->getCount();
		
    }		
	
	public function admin_view() {
		
		$user_country_id = $this->Auth->user('country_id');
		$shop_country = $this->Country->find('first', array('conditions' => array('name' => 'Romania')));
		$shop_country_id = $shop_country['Country']['id'];
		$user_country = $this->Country->findById($user_country_id);
		
		$vat = $user_country_id === $shop_country_id ? $shop_country['Country']['vat'] : 0;
		$user_discount = $this->Auth->user('discount');
		$this->set(compact('vat'));
		$this->set(compact('user_discount'));
		$this->set('server_currency', $shop_country['Country']['currency']);
		
		$carts = $this->Cart->readProduct();
		$products = array();
		if (null!=$carts) {
			foreach ($carts as $productId => $count) {
				$product = $this->Product->read(null,$productId);
				$product['Product']['count'] = $count;
					$products[]=$product;
			}
		}
		$this->set(compact('products'));
	}
	
	public function admin_update() {
		
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $cart = array();
                foreach ($this->request->data['Cart']['count'] as $index=>$count) {
                    if ($count > 0) {
                        $productId = $this->request->data['Cart']['product_id'][$index];
                        $cart[$productId] = $count;
                    }
                }
                $this->Cart->saveProduct($cart);
            }else{
				 $this->Cart->clearTable();
			}
        }
        $this->redirect(array('action'=>'view'));
	}
}