<?php
App::uses('Helper', 'View');
class AdminActionHelper extends AppHelper {
	var $helpers = array('Html', 'Form', 'Icon');

	public function mixTool($id = null, $combo=1, $model=null, $stat = 1, $field='active', $fontSize='18px') {
		if (!$id || !$model || $combo < 1) {return '';}
		$maxOption = 10;
		$binaryStr = decbin(intval($combo));
		$max2=$maxOption-preg_replace('/0/','',$combo); 	//fastest escape
		$combo = array_map(function ($a) { return intval($a[0]); },str_split(strrev(str_pad($binaryStr, $maxOption, '0', STR_PAD_LEFT))));
		
		$model=ucfirst(strtolower($model));
		$controller = strtolower(Inflector::pluralize($model));
		if ($controller === "feedback") { $controller ="feedbacks"; }
		// somehow have problem with feedback word, isn't pluralized

		$toggle = array(
			'label'  => $stat==1 ? 'times-circle-o' : 'check-circle-o',
			'color'  => $stat==1 ? 'red' : 'blue',
			'action' => $stat==1 ? 'toggle' : 'toggle'
		);
		$toolOrders=[1,2,3,4,5];		
		
		$out = [];
		for ($i=0; ($i<$maxOption); $i++) {
			if ($combo[$i]===1) {
				$out[] = $this->getTool($toolOrders[$i], $id, $model, $stat, $field, $toggle, $controller, $fontSize);
				if ($max2 === 0) {break;}else{$max2--;}
			}
		}
		return (implode(' ',$out));
		
	}
	
	protected function getTool($index, $id, $model, $stat, $field, $toggle, $controller, $fontSize) {
		if ($index===1) {
			return $this->Html->link($this->Icon->icon('eye','', true,  'black', $fontSize),array('controller' => $controller,'action' => 'view',   $id), array('escape' => false,'title'=>'Show informations'));
		}else if($index===2) {
			return $this->Html->link($this->Icon->icon('edit','',true,  'blue', $fontSize), array('controller' => $controller,'action' => 'edit',   $id), array('escape' => false,'title'=>'Edit informations'));
		}else if($index===3) {
			return $this->Form->postLink($this->Icon->icon($toggle['label'],'',true,$toggle['color'],  $fontSize),  array('controller' => $controller,'action' => $toggle['action'], $id, $model, $field), array('escape' => false, 'title'=>'Activate or deactivate'));
		}else if($index===4) {
			return $this->Form->postLink($this->Icon->icon('delete','',true, 'red', $fontSize),  array('controller' => $controller,'action' => 'delete', $id, $model), array('escape' => false, 'title'=>'Permanently delete', 'confirm' => 'Are you sure?'));
		}else if($index===5) {
			return $this->Form->postLink($this->Icon->icon('delete','',true, 'red', $fontSize),  array('controller' => $controller,'action' => 'remove_from_list', $id, $field), array('escape' => false, 'title'=>'Remove from list'));
		}else{
			return '';
		}
	}
	
	public function forUsers($id = null, $model=null, $stat = 1, $field='active' ) {
		if (!$id || !$model) {return '';}

		$model=ucfirst(strtolower($model));
		$controller = strtolower(Inflector::pluralize($model));
		
		$toggle = array(
			'label'  => $stat==1 ? 'delete' : 'undo',
			'color'  => $stat==1 ? 'red' : 'blue',
			'action' => $stat==1 ? 'toggle' : 'toggle'
		);
		
		$tools=array(
				$this->Html->link($this->Icon->icon('eye','', true,  'black','18px'),array('controller' => $controller,'action' => 'view',   $id), array('escape' => false,'title'=>'Show informations')),
				$this->Html->link($this->Icon->icon('edit','',true,  'blue', '18px'), array('controller' => $controller,'action' => 'edit',   $id), array('escape' => false,'title'=>'Edit informations')), 
				$this->Form->postLink($this->Icon->icon($toggle['label'],'',true,$toggle['color'],  '18px'),  array('controller' => $controller,'action' => $toggle['action'], $id, $model, $field), array('escape' => false, 'title'=>'Activate or deactivate', 'confirm' => 'Are you sure?'))
		);
		//die($model.'-'.$field);
		return (implode(' ',$tools));
		
	}

	
	
	public function forMessage($id = null, $model=null, $stat = 1, $field='active', $which=false ) {
		if (!$id || !$model) {return '';}

		$model=ucfirst(strtolower($model));
		$controller = strtolower(Inflector::pluralize($model));
		
		$toggle = array(
			'label'  => $stat==1 ? 'undo' : 'check',
			'color'  => $stat==1 ? 'red' : 'blue',
			'action' => $stat==1 ? 'toggle' : 'toggle'
		);
		$tools=array(
				$this->Html->link(    $this->Icon->icon('eye','', true,  'black','18px'),array('controller' => $controller,'action' => 'view',   $id), array('escape' => false,'title'=>'View this')),
				$this->Form->postLink($this->Icon->icon($toggle['label'],'',true,$toggle['color'],  '18px'),  array('controller' => $controller,'action' => $toggle['action'], $id, $model, $field), array('escape' => false, 'title'=>'Mark solved or unsolved this message', 'confirm' => 'Are you sure?'))
		);
		if (!$which) {
			return (implode(' ',$tools));
		} else {
			return $tools[$which];
		}
	}
}

