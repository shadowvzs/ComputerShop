<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

//use Cake\Routing\Router;

class ProductsController extends AppController {
	var $uses = array('Discount', 'ProductsImage', 'Brand', 'Review', 'Feedback', 'Product', 'Country', 'Category');
	var $thisModel = 'Product';
	var $thisController = 'products';

	public function beforeFilter() {

		parent::beforeFilter();

	    $this->Auth->allow('index', 'view', 'cart', 'review');
		$shop_country = $this->Country->find('first', array('conditions' => array('name'=>'Romania')));
		$shop_country_id = $shop_country['Country']['id'];
		
		if ($this->Auth->user('id')) {	
			$user_country_id = $this->Auth->user('country_id');
			$vat = ($user_country_id === $shop_country_id) ? $shop_country['Country']['vat'] : 0;
			$user_discount = $this->Auth->user('discount');
		}else{
			$vat = $shop_country['Country']['vat'];
			$user_discount = 0;
		}
		$this->vat = $vat;
		$this->set('vat', intval($vat));
		$this->set('server_currency', $shop_country['Country']['currency']);
		$this->set('user_discount', $user_discount);
		
			
	}

	
    public function index($id=null) {
 
    	$model = $this->thisModel;
    	$pager = $this->pager();
		$this->Category = ClassRegistry::init('Category');
		$conditions = array('fields' => array('slug', 'name'), 'conditions' => array('active' => 1));
		$default = array('any'=>'Any');

		$this->set('search', $pager['search_data']);
		$this->set( $model, $pager['data']);
    	$this->set('model', $model);
    	$this->set('controller', $this->thisController);
    	$this->set('categs', array_merge($default, $this->Category->find('list', $conditions)));
    	$this->set('brands', array_merge($default, $this->Brand->find('list', $conditions)));
    	$this->set('series', array_merge($default, ClassRegistry::init('Classification')->find('list', $conditions)));
    	$this->set('accessories', array_merge($default, ClassRegistry::init('Accessory')->find('list', $conditions)));
    	$this->set('categories', $this->Category->getAllActiveCategory());
   }	

    public function view($slug=null) {
		
    	$model = $this->thisModel;
    	$controller = $this->thisController;

		if (!$slug) { 
			return $this->redirect(array('controller' => $controller, 'action' => 'index')); 
		}
		if (!$id = $this->Product->findBySlug($slug, array('id'))[$model]['id']) { 
			return $this->redirect(array('controller' => $controller, 'action' => 'index')); 
		}

    	$products = $this->$model->find('first', array(
			'conditions' => array(
				$model.'.id' => $id, 
				$model.'.active' => 1)
			)
		);
	
	 	if ($products) {
    		$images['ProductsImage'] = $this->ProductsImage->find('list', array(
				'conditions' => array(
					'ProductsImage.product_id' => $id
				)
				
			));
    		$reviews['Review'] = $this->Review->find('all', array(
				'conditions' => array(
					'Review.product_id' => $id
				)
			));
    		$feedbacks['Feedback'] = $this->Feedback->find('all', array(
				'conditions' => array(
					'Feedback.product_id' => $id
				)
			));
    		$discount['Discount'] = $this->Discount->find('all', array(
				'conditions' => array(
					'Discount.id' => $products['Product']['discount_id']
				)
			));

    		$users['User'] = $this->Auth->user();
			$data = array_merge($products, $images, $reviews, $feedbacks, $users);
			
			$ProductMeta = array(
				'meta_title' => $products[$model]['meta_title'],
				'meta_description' => $products[$model]['meta_description'],
				'meta_keyword' => $products[$model]['meta_keyword'],
			);

			$review = ClassRegistry::init('Review')->find('list', array (
				'fields' => array('rate'),
				'conditions' => array(
					'product_id' => $id,
					'active' => 1,
				)
			));

			if (!empty($review)) {
				$review = round(array_sum($review)/count($review), 1);
			}else{
				$review = 0;
			}

			$data['Score'] = $review;
			
			$this->set('ProductMeta', $ProductMeta);
			$this->set($model, $data);
    		$this->set('model', $model);
			$this->set('thisUser', $this->Auth->User());
    		
    	} else { 
			return $this->redirect(array('controller' => $controller,'action' => 'index')); 
		}
    	
	}

	public function review() {
		
		$this->autoRender = false;
		
        if ($this->request->is('post')) {

			if (!$this->Auth->user('id')) {
				die("-1");
			}

			$data = array ('Review' => $this->request->data['Review']);
			$user_id = $this->Auth->user('id');
			$prod_id = $data['Review']['product_id'];

			$record = $this->Review->find('first', 
				array(
					'conditions' => array(
						'user_id' => $user_id, 
						'product_id' => $prod_id
					)
				)
			);
		
			$data['Review']['active'] = 1;
			$data['Review']['user_id'] = $user_id;
			
			if (!empty($record)){
				$data['Review']['id'] = $record['Review']['id'];
			}
			

			$this->Review->save($data);
	
			$review = $this->Review->find('list', array (
				'fields' => array('rate'),
				'conditions' => array(
					'product_id' => $prod_id,
					'active' => 1,
				)
			));

			if (empty($review)) { 
				die("0"); 
			}

			$review = round(array_sum($review) / count($review), 1);
			die($review);
		}

	}

    
    public function admin_index($id=null) {	

		$model = $this->thisModel;
		$pager = $this->pager();

		
		$this->set('search', $pager['search_data']);
		$this->set($model, $pager['data']);

		$this->set('model', $model);
		$this->set('controller', $this->thisController);
		$this->set('categories', $this->Category->getAllActiveCategory());
		
    }	
    
    public function admin_add() {

    	$this->uses = array('Discount', 'Brand', 'Product', 'ProductsImage',  'Category', 'Accessory', 'Classification');
    	
    	$model = $this->thisModel;
    	$controller = $this->thisController;
  	

    		if ($this->request->is('post') || $this->request->is('put')) {
				
				if ($this->Product->save($this->request->data)) {

					$this->Flash->success(__(' Product added '));
					return $this->redirect(array('controller' => 'products' , 'action' => 'view', $this->Product->id)); 

				}
  
    		}
  
    		$users['User'] = $this->Auth->user();
    		
    		$discount['Discount'] = $this->Discount->find('list', array(
				'conditions' => array(
					'Discount.active' => '1'
				),
				'keyField' => 'id', 
				'valueField' => 'name'
			));

    		$brand['Brand'] = $this->Brand->find('list', array(
				'conditions' => array('Brand.active' => '1'), 
				'keyField' => 'id', 
				'valueField' => 'name'
			));

    		$category['Category'] = $this->Category->find('list', array(
				'conditions' => array('Category.active' => '1'),
				'keyField' => 'id', 
				'valueField' => 'name'));

    		$accessory['Accessory'] = $this->Accessory->find('list', array('conditions' => array(
				'Accessory.active' => '1'),
				'keyField' => 'id', 
				'valueField' => 'name'));

    		$series['Classification'] = $this->Classification->find('list', array(
				'conditions' => array('Classification.active' => '1'),
				'keyField' => 'id', 
				'valueField' => 'name'));
    		
    		$discount['Discount'][0] = "Normal discount";
    		$brand['Brand'][0] = "No brand";
    		$category['Category'][0] = "No category";
    		$accessory['Accessory'][0] = "Not set part";
    		$series['Classification'][0] = "Not series";
    		$data = array_merge($users, $discount, $category, $brand, $accessory, $series);
    		$this->set($model, $data);
    		$this->set('model', $model);
    		$this->set('controller', $this->thisController);

    }
	
    public function admin_view($id=null) {
    	
    	$model = $this->thisModel;
    	$controller = $this->thisController;
    	$products = $this->$model->find('first', array('conditions' => array($model.'.id' => $id)));
    	if ($products) {
    		
      		$images['ProductsImage'] = $this->ProductsImage->find('list', array(
				  'conditions' => array('ProductsImage.product_id' => $id)
			));
			$review = ClassRegistry::init('Review')->find('list', array (
				'fields' => array('rate'),
				'conditions' => array(
					'product_id' => $id,
					'active' => 1,
				)
			));

			if (!empty($review)) {
				$review = round(array_sum($review)/count($review), 1);
			}else{
				$review = 0;
			}
				
     		$feedbacks['Feedback'] = $this->Feedback->find('all', array('conditions' => array('Feedback.product_id'=>$id)));
			$users['User'] = $this->Auth->user();
			 
			$data = array_merge($products,$images,$feedbacks, $users);
			$data['Score'] = $review;
    		$this->set($model, $data);
    		$this->set('model', $model);
    		$this->set('controller', $this->thisController);
    		
     	} else { return $this->redirect(array('controller'=>$controller,'action' => 'index')); }
     	
    }
    
    public function admin_edit($id=null) {
    	
    	$this->uses = array('Discount', 'ProductsImage', 'Brand', 'Review', 'Feedback', 'Product', 'Category', 'Accessory', 'Classification');
    	
    	$model = $this->thisModel;
    	$controller = $this->thisController;
    	$products = $this->$model->find('first', array('conditions' => array($model.'.id'=>$id)));
    	
    	if (!$products) { return $this->redirect(array('controller'=> $controller,'action' => 'index')); }
			
		if ($this->request->is('post') || $this->request->is('put')) {

			$data=$this->request->data;
			$data[$model]['id'] = $id;

			if ($this->$model->save($data)) {
				$this->Flash->success(__($model.' was changed (id='.$id.')'));
			}else{
				$this->Flash->success(__($model.' unchanged, error occured (id='.$id.')'));
			}
			return $this->redirect(array('controller' => $controller, 'action' => 'view', $id));
		}
		
		$images['ProductsImage'] = $this->ProductsImage->find('all', array(
			'conditions' => array('ProductsImage.product_id' => $id)
		));
		$reviews['Review'] = $this->Review->find('all', array('conditions' => array('Review.product_id'=>$id)));
		$feedbacks['Feedback'] = $this->Feedback->find('all', array('conditions' => array('Feedback.product_id'=>$id)));
		$users['User'] = $this->Auth->user();

		$discount['Discount'] = $this->Discount->find('list', array(
			'fields' => array('id', 'name'),
			'conditions' => array(
				'Discount.active' => '1'
			)
		));
		$brand['Brand'] = $this->Brand->find('list', array(
			'conditions' => array('Brand.active' => '1'),
			'keyField' => 'id', 
			'valueField' => 'name')
		);
		$category['Category'] = $this->Category->find('list', array(
			'conditions' => array('Category.active' => '1'),
			'keyField' => 'id', 
			'valueField' => 'name')
		);
		$accessory['Accessory'] = $this->Accessory->find('list', array(
			'conditions' => array(
				'Accessory.active' => '1'
			),
			'keyField' => 'id', 
			'valueField' => 'name')
		);
		$series['Classification'] = $this->Classification->find('list', array(
			'conditions' => array(
				'Classification.active' => '1'
			),
			'keyField' => 'id', 
			'valueField' => 'name'));
		$category['Category'][0] = "No category";
		$discount['Discount'][0] = "Normal discount";
		$brand['Brand'][0] = "No brand";
		$accessory['Accessory'][0] = "Not set part";
		$series['Classification'][0] = "Not series";
		$data = array_merge($products, $images, $reviews, $feedbacks, $users, $discount, $category, $brand, $accessory, $series);
		$this->set($model, $data);
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
		
		$model = $this->thisModel;

		$lastChar=substr($model, -1);
		$tableName = strtolower($lastChar === 'y' ? substr($model,0,-1).'ies' : ($lastChar === 's' ? $model : $model.'s'));
		$query = sprintf("UPDATE `%s` SET `%s`= 1 - `%s` WHERE `id`='%u'", $tableName, $field, $field, $id);
		$action = $this->$model->query($query);

		if (is_array($action)){
			$this->Flash->success(__('field: '.$field.', changed (id='.$id.')')); 
		}		
		$this->redirect($this->referer());
		
	}	
	
	public function admin_remove_from_list ($id=null,$field=null) {
		
		if (!$id || !$field) { 
			return $this->redirect($this->referer()); 
		}
		$model = $this->thisModel;

		if (!$data = $this->$model->find('first', array('conditions' => array($model.'.id' => $id)))) { 
			$this->Flash->error(__('Product not exist')); 
			$this->redirect($this->referer()); 
		}

		$data[$model][$field] = null;
		$this->$model->save($data);
		$this->redirect($this->referer());
		$this->Flash->success(__('Removed from list')); 
		
	}	

	public function admin_change_cover_image($product_id=null, $image_id=null){
		
		if ($image_id === null || $product_id === null) { 
			return $this->Flash->success(__('Missing product or image id!')); 
		}

		$model = $this->thisModel;
		//verification for product and image id
		$product = $this->$model->query(sprintf('SELECT * FROM `products` WHERE `id`="%u"', $product_id));//findById($product_id);
		if (!$product) { 
			$this->Flash->error(__('Product not exist')); 
			$this->redirect($this->referer());
		}
		$image = $this->ProductsImage->findById($image_id);
		if (!$image) { 
			$this->Flash->error(__('Image not exist')); 
			$this->redirect($this->referer()); 
		}
		//lets change the id for image
		$data["Product"] = $product[0]['products'];
		$data[$model]['cover_image_id'] = $image_id;
		if ($this->$model->save($data)) {
			$this->Flash->success(__('Cover image changed!'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_delete($id=null){
		if ($id === null) { return; }

		$images = $this->ProductsImage->find('all', array('conditions' => array(
			'product_id' => $id
		)));

		foreach ($images as $image){
			$path = WWW_ROOT.'/img/products/'.$image['ProductsImage']['name'];
			if (file_exists($path)) {
				unlink($path);
				$this->ProductsImage->delete($image['ProductsImage']['id']);
			}
		}
		$this->Product->delete($id, true);
		$this->redirect(array('controller'=>'products','action' => 'index'));
	}
	
	public function admin_delete_image($image_id=null){
		
		$model=$this->thisModel;
		if ($image_id === null) { return; }
		$image = $this->ProductsImage->findById($image_id);
		if (!$image) { 
			$this->Flash->error(__('Image not exist')); 
			$this->redirect($this->referer()); 
		}
		$product_id = $image['ProductsImage']['id'];
		
		$this->ProductsImage->delete($image_id, false);

		if(file_exists($path = WWW_ROOT.'/img/products/'.$image['ProductsImage']['name'])){
			unlink($path);
		}

		if (!empty($data = $this->$model->find('first', array('conditions' => array($model.'.cover_image_id' => $image_id))))) {
			$data[$model]['cover_image_id']=null;
			$this->$model->save($data);
		}
		
		$this->Flash->success(__('Image deleted!'));
		$this->redirect($this->referer());
		
	}
	
	public function image_upload($id=null){

		if ($id === null) { return; }
		if ($this->request->is('post') || $this->request->is('put')) {
			$imageData = array ('ProductsImage' => array(
				'file' => $this->request->data['Product']['file'],
				'product_id' => $id
			));

			$this->ProductsImage->save($imageData);
		}
		
		$this->redirect($this->referer());
	}
	

	public function slugToId ($main_model, $filter, $get, $query_param=null, $param=null) {

		$slug = $filter."_slug";
		$id = $filter."_id";
		${$slug} = "";
		${$id} = 0;
		if (isset($get[$filter]) && ($get[$filter] != 'any')) {
			${$slug} = trim($get[$filter]);
			$model = ucfirst($filter);
			
			if (!isset($this->$model)) {
				$this -> $model = ClassRegistry::init($model);
			}
			if (${$slug} === "" || !empty($record = $this->$model->findBySlug(${$slug}, array('id')))) {
				${$id} = $record[$model]['id'];
			}
		}
		
		if ($param !== null && ${$id} != 0) { $param = $param.'&'.$filter.'='.${$slug}; }
		if ($query_param !== null && ${$id} != 0) { $query_param = $query_param.' AND '.$main_model.'.'.$filter.'_id = '.${$id}; }
		return compact($slug, $id, 'param', 'query_param');
	}
	
	public function pager($admin=false) {
		
		$vat = $this->vat;
		$conditions = false;	// default stuffs
		$condition = array();		// for shorter form: if (!$var)
		$orderBy = "Product.created DESC";	
		$search_key = "";
		$search_cat = 0;	
		$current_page = 0;
		$filters = array( 'brand', 'classification', 'accessory', 'discount');
		$item_conditions = array('used' => 0, 'new' => 1);
		$item_condition = -1;	// = any
		$show_per_page = 20;
		$model = $this->thisModel;
		$category_slug = "";
		$param = ""; 			// param for pager numbers
		$query_param = "";		// this hold data after group filter verification with slug

		$pagArray = array(
				'limit' => 1,
				'order' => array(
						$model.'.id' => 'asc'
				)
		);
		
		$get = $this->request->query;

		foreach ($filters as $filter) {
			extract($this->slugToId($model, $filter, $get, $query_param, $param), EXTR_IF_EXISTS);
		}

		$query_param = substr($query_param, 4);

		if (isset($get['category']) && ($get['category'] != 'any')) {
			$category_slug = trim($get['category']);
			$this -> Category = ClassRegistry::init('Category');
			$param=$param.'&category='.$category_slug;
			$id = 0;
			if ($category_slug !== "" && ($record = $this->Category->findBySlug($category_slug, array('id')))) { 
				if (!empty($record)) {
					$id	= $record['Category']['id'];
				}
			}
			
			$search_cat = intval($id);
		}

		if (isset($get['page'])) {
			$current_page = intval($get['page']) - 1;
			if ($current_page < 0) {$current_page = 1;}
		}

		
		$thisTable = strtolower(Inflector::pluralize($model));
		$initCondition = $admin ? array() : array("$model.active='1'");
		$condition = $initCondition;


		if ($search_cat > 0) {
			$result = ClassRegistry::init('Category')->find('all', array('conditions' => array('Category.id' => $search_cat)));
			$id_array = array($model.".category_id=".$search_cat);
			if (!empty($result)) {
				$result = $result[0]['Child'];
				foreach($result as $cat) {
					$id_array[] = $model.".category_id=".intval($cat['id']);
					if (isset($cat['Child']) && !empty($cat['Child'])){
						foreach($cat['Child'] as $subcat) {
							$id_array[] = $model.".category_id=".intval($subcat['id']);
						}
					}
				}
			}
			$condition[] = "(".implode(' OR ',$id_array).")";
		}

		if (isset($get['search']) && trim($get['search']) != "") {
			$search_key = $get['search'];
			$param = $param.'&search='.$search_key;
			$condition[] = "(".$model.".name LIKE '%".$search_key."%')";
		}

		if (trim($query_param)) {
			$condition[] = $query_param;
		}
		
		if (isset($get['condition']) && isset($item_conditions[$get['condition']])) {
				$item_condition = $item_conditions[$get['condition']];
				$param = $param.'&condition='.$get['condition'];
				$condition[] = $model.".item_condition = ".$item_condition;
		}

		if (isset($get['min_price']) && intval($get['min_price']) > 0 ) {
				$min_price = intval($get['min_price']);
				$param = $param.'&min_price='.$min_price;
				$min_price = floor($min_price + ($min_price * $vat / 100));
				$condition[] = $model.".price >= ".$min_price;
			
		}

		if (isset($get['max_price']) && intval($get['max_price']) > 0 ) {
			$max_price = intval($get['max_price']);
			$param = $param.'&max_price='.$max_price;
			$max_price = floor($max_price + ($max_price * $vat / 100));
			$condition[] = $model.".price <= ".$max_price;
		}

		
		if (isset($get['orderby'])) {
			$ordering = $get['orderby'];
			$param = $param.'&orderby='.$ordering;
			$ordering = str_replace("_"," ",$ordering);
			$orderBy = $ordering.', '.$orderBy;
		}
		
		if (empty($condition)) {
			$condition="1";
		} else {
			$condition = implode(' AND ', $condition); 
		}

		$query = sprintf("SELECT count(*) as max FROM `%s` as `%s` WHERE %s", $thisTable, $model, str_replace($model.'.','',$condition));
		$count = $this->$model->query($query)[0][0]['max'];

		$start_at = $current_page*$show_per_page;
		$maxPageIndex = intval(ceil($count/$show_per_page));
		if ($count < $start_at) {
			$start_at = $maxPageIndex;
		}
		$belongsTo = $this->$model->belongsTo;
		$join = array();
		
		foreach ($belongsTo as $linkedModel) {
			//put underscore if name have uppercase character ProductsImage => Products_Image
			$className = $linkedModel['className'];
			$table_name = Inflector::pluralize(strtolower( preg_replace('/\B([A-Z])/', '_$1', $className)));
			$field_name = $linkedModel['foreignKey'];
			$join[] = sprintf("LEFT JOIN `%s` `%s` ON %s=%s", $table_name, $className, $model.'.'.$field_name, $className.'.id');
		}

		$joins = implode(" ", $join);
		$query = sprintf("SELECT * FROM `%s` as `%s` %s WHERE %s ORDER BY %s LIMIT %s,%s", $thisTable, $model, $joins, $condition, $orderBy, $start_at, $show_per_page);
		$data = $this->$model->query($query);
		
		if ($maxPageIndex > 1) {			
			//create pagination for view
			$maxIconAmount = 10;
			$maxIconHalf = intval(floor($maxIconAmount / 2));
			$lastIndex = (($current_page+$maxIconHalf) > $maxPageIndex) ? $maxPageIndex : ($current_page+$maxIconHalf);
			
			$start = ($current_page > $maxIconHalf) ? ($current_page-$maxIconHalf) : 0;
			$end = $lastIndex;// ($current_page > ($maxPageIndex-$maxIconHalf)) ? ($current_page+$maxIconHalf) : $lastIndex;
			
			$first = $start > 0 ? "<li><a href='#'>1</a></li>": '';
			$last = $end < $maxPageIndex ? "<li><a href='#'>1</a></li>": '';
			
			if (strlen($param) > 0) { $param=substr($param,1)."&"; }
			
			
			$list = array ("<ul class='pagination'>");
			for ($i = $start; $i < $end; $i++) {
				$class = $i === $current_page ? " class='active'" : '';
				$url = $param."page=".($i + 1);
				$list[] = "<li".$class."><a href='?".$url."'>".($i + 1)."</a></li>";
			}
			$list[] = "</ul>";
		}else{ 
			$list = []; 
		}
		return array('data' => $data, 
					'search_data' => array(
						'page'=>$current_page+1, 
						'param'=>$param, 
						'last' => $maxPageIndex, 
						'paginator' => implode('', $list)));
	}	
}
