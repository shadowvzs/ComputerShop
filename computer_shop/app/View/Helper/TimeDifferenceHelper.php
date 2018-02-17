<?php
App::uses('Helper', 'View');
class TimeDifferenceHelper extends AppHelper {
	public function fromNow($datetime1 = null, $shortForm = false ) {
		if (!$datetime1) {return 'DateTime not declared';}
		$datetime2=date('Y-m-d H:i:s');
		return $this->calc($datetime1, $datetime2, $shortForm);
	}
	
	public function calc($datetime1 = null, $datetime2 = null, $shortForm = false ) {
		if (!$datetime1) {return 'DateTime not declared';}
		if (!$datetime2) {$datetime2=date('Y-m-d H:i:s');}
		$difference = strtotime($datetime2)-strtotime($datetime1);
		$lenStr =['day', 'hour', 'min', 'sec'];
		$lenInt =[86400, 3600, 60, 1];
		$len = count($lenInt);
		$out =[];
		for ($i=0;$i<$len;$i++){
			if ($difference >=$lenInt[$i]){
				$n = floor($difference/$lenInt[$i]);
				$out[] = $n.' '.$lenStr[$i];
				$difference-=$n*$lenInt[$i];
				if ($shortForm) {$out[0]=$out[0].'+';break;}
			}			
		}
		return implode(', ', $out);
	}
}