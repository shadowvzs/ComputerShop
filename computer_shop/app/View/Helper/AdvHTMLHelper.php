<?php
App::uses('Helper', 'View');
class AdvHTMLHelper extends AppHelper {
	var $helpers = array('Html', 'Form', 'AdminAction');
	
	public function row($label = null, $value='' ) {
		if (!$label || !$value){return '';}
		return "<li class='list-group-item clearfix'><span class='pull-left font-weight-bold'>".__($label)."</span><span class='pull-right'>".__($value)."</span></li>";
	}	
	
	public function rowGroup($data) {
		$out=[];	
		foreach ($data as $key => $value) {
			$out[] = $this->row($key, $value);
		}	

		return "<ul class='list-group list-group-striped'>".implode('',$out)."</ul>";
	}
	
	public function listButton ($id, $title, $targetViewController, $targetRemoveModel, $targetField){
		$viewLink = $this->Html->link($title,array('controller'=>$targetViewController,'action' => 'view', $id), array('escape' => false));
		$removeLink = $removeLink = $this->AdminAction->mixTool($id, 16, $targetRemoveModel, null, $targetField);
		return "<li class='list-group-item'>".$viewLink.' - '.$removeLink."</li>";
	}
	
	public function createListButton ($model, $data, $controller, $field) {
		return [$model=>($data['id']===null) ? 'No parent category' : "<ul class='list-inline list-unstyled'>".($this->listButton ($data['id'], $data['name'], $controller, $model, $field))."</ul>"];
	}
}

