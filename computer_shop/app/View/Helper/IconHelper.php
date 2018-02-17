<?php
App::uses('Helper', 'View');
class IconHelper extends AppHelper {
	public function isActive($label='',$status=0, $color='default') {
		$status=intval($status) === 1 ? true : false;
		return $this->icon(!$status ? 'circle-o' : 'circle', ' '.$label, false, $color, null, !$status ? 'italic' : 'normal');
	}
	
    public function icon($action = null, $label = '', $focusable=false, $color = 'default', $size = null, $style='normal') {

        if ($size == null) {
            $size = '14px';
        }
		
		if ($action !== null) {
			if ($action==='contact'){
				$action='pencil-square-o';
			}elseif ($action==='delete'){
				$action='trash-o';
			}
			$focusable = $focusable ? 'color-focusable' : '';
			return '<span class="'.$focusable.' font-style-'.$style.'" style="font-size:'.$size.';color:'.$color.';"><i class="fa fa-'.$action.'"></i>'.$label.'</span>';
		}
	}
}
