<?php
App::uses('Helper', 'View');
class AdvFormHelper extends AppHelper {
	var $helpers = array('Html', 'Form');
	
	public function input($field = null, $table_row=null, $label='' ) {
		if (!$field){return '';}
		return "<div class='clearfix'>".$this->Form->input($field, array('class' => 'pull-right','style'=>'resize:none;','label' => array('class'=>'control-label','text'=>__($label).':'), 'default'=>($table_row[$field] ? __($table_row[$field]) : '')))."</div>"; 
	}
	
	public function inputGroup($data, $table_row) {
		$out=[];	
		foreach ($data as $key => $value) {
			$out[] = $this->input($key, $table_row, $value);
		}	
		return implode('',$out);
	}
	
	public function selectOnOff($field, $default=0, $option=['Inactive', 'Active']) {
		
		return $this->Form->input(
			$field,
				array(
					'style'=>'width:150px;',
					'class' => 'pull-right',
					'label' => __(ucfirst($field)).':',
					'type' => 'select',
					'selected'=>$default,
					'options' => array_combine([0,1],[__($option[0]), __($option[1])])
		));		
	}

}

