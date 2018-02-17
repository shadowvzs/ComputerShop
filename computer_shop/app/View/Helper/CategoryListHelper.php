<?php
App::uses('Helper', 'View');
class CategoryListHelper extends AppHelper {
	var $helpers = array('Html', 'Form', 'Icon');
	public function start($table_data, $slug=false) {
		
		return $this->createList($table_data, $slug );
		
	}
	
	public function createList($data, $slug){
		
		$max = count($data);
		$out = [];
		for ($i = 0;$i < $max;$i++){
			$row = $data[$i];
			$has_sub = empty($row['Child']) ? false : true;
			$cat = $row['Category'];
			$link = $this->createLink($cat['name'].($has_sub ? " <span class='right-arrow'> &#8883; </span>" : ''), $slug ? $cat['slug'] : $cat['id']);
			if (!$has_sub){
				$out[] = "<li>".$link."</li>";
			}else{
				$ret = $this->createSubList($row['Child'], $slug);
				$out[] = "<li class='dropdown-submenu'>".$link.PHP_EOL.$ret.PHP_EOL."</li>".PHP_EOL;
			}
		}
		return implode(PHP_EOL, $out);
	}
	
	public function createSubList($data, $slug ){
		
		$max=count($data);
		$out = [];
		for ($i=0;$i<$max;$i++){
			$row=$data[$i];
			$has_sub = (!isset($row['Child']) || empty($row['Child'])) ? false : true;
			$link = $this->createLink($row['name'].($has_sub ? " <span class='right-arrow'> &#8883; </span>" : ''), $slug ? $row['slug'] : $row['id'] );
			if (!$has_sub){
				$out[]="<li>".$link."</li>";
			}else{
				$ret = $this->createSubList($row['Child'], $slug);
				$out[]="<li class='dropdown-submenu'>".$link.PHP_EOL.$ret.PHP_EOL."</li>".PHP_EOL;
			}
		}
		return (empty($out)) ? '' : "<ul class='dropdown-menu'>".PHP_EOL.implode(PHP_EOL, $out).PHP_EOL."</ul>";
	}
	
	public function createLink($string, $id ) {

		return $this->Html->link($string, array('controller'=>'products', 'action'=>'index', null, '?' =>"category=".$id), array('escape'=>false));

	}
	
}
