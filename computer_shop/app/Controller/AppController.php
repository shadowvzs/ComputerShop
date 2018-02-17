<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $components = array('Flash', 'Session', 'Auth');
	
    public function beforeFilter() {
		$this->loadModel('Cart');
	    $this->set('count',$this->Cart->getCount());
		
        $this->Auth->authError = __('Login failed.', true);
        $this->Auth->loginError = __('Login failed.', true);
         $this->Auth->allow('index', 'login');
         
        $admin = false;

        if(strpos($_SERVER['REQUEST_URI'], 'admin')) {
            if($this->Auth->user('group_id') != 1){
                $this->Auth->logout();
            } else {
                $this->layout = 'admin';
                $admin = true;

                $badge = array();

                $badge['contact'] = ClassRegistry::init('Contact')->find('count', array (
                    'conditions' => array(
                        'active' => 0,
                    )
                ));

                $badge['order'] = ClassRegistry::init('Order')->find('count', array (
                    'conditions' => array(
                        'active' => 1,
                        'status' => 0
                    )
                ));

                $this->set('badge', $badge);
            }
        } else {
			$categories = ClassRegistry::init('Category');
            $product = ClassRegistry::init('Product');

            $this->set('categories', $categories->getAllActiveCategory());
            
            $this->set('topProducts', $product->query(" SELECT e.id, e.slug, e.name, sum(r.rate) as rate FROM products e LEFT JOIN reviews r ON r.product_id = e.id WHERE e.active = 1 GROUP BY e.id ORDER BY rate DESC LIMIT 0,10" ));
            $this->set('eventProducts', $product->query(" SELECT e.id, e.slug, e.name, d.price_modifier as discount FROM products e LEFT JOIN discounts d ON d.id = e.discount_id WHERE e.active = 1 AND (d.start_date < NoW() AND d.end_date > NOW()) GROUP BY e.id ORDER BY (e.price / 100 * d.price_modifier) DESC LIMIT 0,10 "));
            
            $categories = ClassRegistry::init('Category');
            $conditions = array('fields' => array('slug', 'name'), 'conditions' => array('active' => 1));
            $default = array('any'=>'Any');            
            $this->set('categs', array_merge($default, $categories->find('list', $conditions)));
            $this->set('brands', array_merge($default, ClassRegistry::init('Brand')->find('list', $conditions)));
            $this->set('series', array_merge($default, ClassRegistry::init('Classification')->find('list', $conditions)));
            $this->set('accessories', array_merge($default, ClassRegistry::init('Accessory')->find('list', $conditions)));

		}		
		$this->loadModel('Cart');
	    $this->set('admin', $admin);
	    $this->set('count',$this->Cart->getCount());
		     
    }
	
	public function beforeRender() {
		
		$this->Page = ClassRegistry::init('Page');
		$this->Category = ClassRegistry::init('Category');
			
		$menu = $this->Page->find('all', array(
				'conditions' => array(
                        'Page.active' => 1,
                        'Page.header' => 1
                )
        ));
        $this->set('menu', $menu);
	}
}