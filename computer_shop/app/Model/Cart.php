<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
 
class Cart extends AppModel {
 
    public $useTable = false;
     
    public function addProduct($productId) {
        $allProducts = $this->readProduct();
		if (null!=$allProducts) {
            if (array_key_exists($productId, $allProducts)) {
                $allProducts[$productId]++;
            } else {
                $allProducts[$productId] = 1;
            }
        } else {
            $allProducts[$productId] = 1;
        }
         
        $this->saveProduct($allProducts);
    }

    public function clearTable(){
        $this->saveProduct([]);
    }
     

    public function getCount() {
        $allProducts = $this->readProduct();
         
        if (count($allProducts)<1) {
            return 0;
        }
         
        $count = 0;
        foreach ($allProducts as $product) {
            $count=$count+$product;
        }
         
        return $count;
    }
 

    public function saveProduct($data) {
        return CakeSession::write('cart',$data);
    }
 
    public function readProduct() {
        return CakeSession::read('cart');
    }
 
}