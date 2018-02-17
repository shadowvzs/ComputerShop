<?php 
class FormHelper {
	protected static $CREATED_FORM;
	public static $PATTERN = [
		'EMAIL'=> ['/^([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$)$/','Please type valid email address'],
		'NAME_HUN'=>['/^([a-zA-Z0-9 ÁÉÍÓÖŐÚÜŰÔÕÛáéíóöőúüűôõû]+)$/','Please use hungarian letters'],
		'NAME'=>['/^([a-zA-Z0-9 ]+)$/','Please use english letters or space'],
		'ALPHA_NUM'=>['/^([a-zA-Z0-9]+)$/','Please use alphanumeric character'],
		'STR_AND_NUM'=>['/^([0-9]+[a-zA-Z]+|[a-zA-Z]+[0-9]+|[a-zA-Z]+[0-9]+[a-zA-Z]+)$/','Use international letter with number'],
		'LOWER_UPPER_NUM'=>['/^(?=.{5,8}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$$/','Please use lowercase, uppercase letter and number']
	];
	
	public static function getForm($glue=''){
		return implode($glue, static::$CREATED_FORM);
	}	
	
	public static function init($inputArray=[]) {
		$response=['ValidFormArray'=>false,'wasPosted'=> false,'validInput'=>false, 'CreatedInputs'=>false];
		if (!isset($_SESSION['validForm'])) {$_SESSION['validForm']=false;}
		//if (empty($inputArray)) {$response;}
		$response['ValidFormArray']=true;
	
		if ($response['wasPosted']=static::isPOST($inputArray)) {
			$_SESSION['validForm']=false;
			unset($_SESSION['input']['error']);
			$response['validInput']=static::validateInput($inputArray);
			$_SESSION['validForm']=$response['validInput'];
			$url = str_replace('&amp;','&',(htmlspecialchars($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], ENT_QUOTES, 'utf-8')));
			redirect($url);
		}else{
			$response['CreatedInputs']=static::createInputFromArray($inputArray);
		}
		return $response;
	}
	
	public static function clearSession(){
		if (isset($_SESSION['input']['file'])) {
			$file = $_SESSION['input']['file'];
			if ($file[0]){
				$path = '/public/img/articles/'.$file[1];
				if (file_exists($path)) {
					unlink($path);
				}
			}
		}
		unset($_SESSION['validForm']);
		unset($_SESSION['input']);
	}

	protected static function isPOST ($inpFORM){
		if (isset($inpFORM['input'])){
			if (isset($inpFORM['input']['file']))  { unset($inpFORM['input']['file']);}
			return empty(array_diff_key($inpFORM['input'], $_POST));
		}
		return false;
	}
	
	protected static function validateInput ($FORM){
		$errors = [];
        if (isset($_FILES["file"])){
    		$tmp = time().'.jpg';
       		$_SESSION['input']['file']=[uploadImg($_FILES["file"],  $tmp), $tmp];
        }
		foreach ($FORM['input'] as $fieldName => $input){
			if (isset($input['rule'])) {
				foreach ($input['rule'] as $prop => $value) {
					if ($prop==='pattern') {
						if (isset($value['type'])&&!empty($value['type'])){
							$type = $value['type'];
							if (!static::ValidateType($type, $fieldName)) { static::registerError ($fieldName, static::$PATTERN[$type][1]); }
						}
						if (isset($value['length'])&&!empty($value['length'])){
							$min=(isset($value['length'][0])&&($value['length'][0]>0)) ? $value['length'][0] : '0';
							$max=(isset($value['length'][1])&&($value['length'][1]>0)) ? $value['length'][1] : '65536';
							if (!static::lengthBetween($fieldName, $min, $max)) { static::registerError ($fieldName, 'length must be between '.$min.' - '.$max); }
						}
						
					}else if($prop==='match'){
						if (!static::macthFields($fieldName,$value)) {static::registerError ($fieldName, 'This field must be same than '.$value);}
					}
				}
			}	
			if ($input[0] != 'submit' && $input[0] != 'file') {$_SESSION['input'][$fieldName]=htmlspecialchars($_POST[$fieldName], ENT_QUOTES);}
		}
		return !(isset($_SESSION['input']['error']) && !empty($_SESSION['input']['error']));
	}
	
	protected static function registerError ($key, $error) {
		if (isset($_SESSION['input']['error'][$key])) {
			$_SESSION['input']['error'][$key] .= '<br>'.$error;
		}else{
			$_SESSION['input']['error'][$key] = $error;
		}
	}
	
	protected static function macthFields ($key1, $key2){
		return (htmlspecialchars($_POST[$key1])===htmlspecialchars($_POST[$key2]));
	}
	
	protected static function ValidateType ($type, $key){
		$_POST[$key]=trim($_POST[$key]);
		return preg_match(static::$PATTERN[$type][0], htmlspecialchars($_POST[$key], ENT_QUOTES));
	}	
	
	protected static function lengthBetween ($key, $min, $max){
		$len=strlen(htmlspecialchars(trim($_POST[$key])));
		return (($len >= $min)&&($len<=$max));
	}
	
	protected static function createInputFromArray ($FORM) {
		$out = [];
		$showError = false;
		$formName = 'newForm';
		if (isset($FORM['create'])&&!empty($FORM['create'])){
			$enctype = isset($FORM['create']['enctype']) ? ' enctype="'.$FORM['create']['enctype'].'"' : '';
			$out[] = sprintf('<form action="%s" method="%s" %s>',isset($FORM['create']['url']) ? $FORM['create']['url'] : '', isset($FORM['create']['method']) ? $FORM['create']['method'] : 'POST', $enctype);
			if (isset($FORM['create']['name'])) {$formName=$FORM['create']['name'];}
			if (isset($FORM['create']['showError']) && ($FORM['create']['showError'])) {$showError=$FORM['create']['showError'];}
		} 
		if (isset($FORM['input'])&&!empty($FORM['input'])){
			foreach ($FORM['input'] as $fieldName => $input) {
				$attr=[];
				$usedAttr = [];
				$rule=[];
				$ruleHint = null;
				$defValue = null;
				$options=[];
				$inputType = $input[0];
				//$cachedValue = ((isset($input['cache']) && $input['rule']));
				//$cachedValue = (isset($input['cache']);
				if (isset($input['attr'])) {
					foreach ($input['attr'] as $prop => $value) {
						if ($prop==='value' && $inputType==='textarea'){
							$defValue=$value;
						}else{
							$usedAttr[] = is_int($prop) ? $value : $prop;
							$attr[] = !is_int($prop) ? sprintf('%s="%s"', $prop, $value) : $value;
						}
					}
				}
				
				if (isset($input['rule'])) {
					foreach ($input['rule'] as $prop => $value) {
						if ($prop==='pattern') {
							if (isset($value['type'])&&!empty($value['type'])){
								$type = $value['type'];
								$min=(isset($value['length'][0])&&($value['length'][0]>0)) ? $value['length'][0] : '0';
								$max=(isset($value['length'][1])&&($value['length'][1]>0)) ? $value['length'][1] : '65536';
								$ruleHint = static::$PATTERN[$type][1]. ' ( '.$min.'-'.$max. ' character ) ';
								if ($createdPattern = static::getHTMLPattern($type,$min,$max)){
									$rule[]=sprintf(' pattern="%s"',$createdPattern);
								}
							}
						}
					}
				}		
				
				
				if (isset($input['options']) && is_array($input['options'])) {
					$selected = isset($input['selected']) ? $input['selected'] : '';
					
					foreach ($input['options'] as $value) {
						$select = strtolower($value)===strtolower($selected) ? $selected = ' selected' : '';
						$options[] = sprintf("<option value='%s'%s>%s</option>",$value,$select,ucfirst(strtolower($value)));
					}
				}	
				$prevValue = (isset($_SESSION['input'][$fieldName]) && isset($input['cache']));
				if (!in_array('title', $usedAttr) && $ruleHint) {$attr[]=sprintf('title="%s"', $ruleHint); }
				if ($inputType === 'select') {
					$newInput = sprintf('<select name="%s"%s>%s</select>', $fieldName, !empty($attr) ? ' '.implode(' ',$attr) : '', implode('<br>',$options));
				}else if($inputType === 'textarea'){
					if (!$defValue) {$defValue=$prevValue ? $_SESSION['input'][$fieldName] : ''; }
					$newInput = sprintf('<textarea name="%s"%s%s>%s</textarea>', $fieldName, !empty($attr) ? ' '.implode(' ',$attr) : '', !empty($rule) ? ' '.implode(' ', $rule) : '', $defValue);
				
				}else{
					if (!in_array('value', $usedAttr)) {$attr[]=sprintf('value="%s"', $prevValue ? $_SESSION['input'][$fieldName] : ''); }
					$newInput = sprintf('<input type="%s" name="%s"%s%s>', $inputType, $fieldName, !empty($attr) ? ' '.implode(' ',$attr) : '', !empty($rule) ? ' '.implode(' ', $rule) : '');
				}
				if (($showError)&&($inputType!=='submit')){
					$haveError = isset($_SESSION['input']['error'][$fieldName]);
					$errorDiv = sprintf('<div id="%s" class="%s">%s</div>', $fieldName.'_error', isset($showError['class']) ? $showError['class'] : '',$haveError ? $_SESSION['input']['error'][$fieldName] : '');
					if ($showError['position']==='before') {
						$newInput= $errorDiv.$newInput;
					}else if ($showError['position']==='after'){
						$newInput= $newInput.$errorDiv;
					}
				}
				$out[] = $newInput;
			}
		}
		if (isset($FORM['end']) && ($FORM['end'])){
			$out[] = '</form>';
		}
		static::$CREATED_FORM = $out;
		return true;
	}
	
	
	public static function getHTMLPattern($type, $min, $max){
		return '(?=.{'.$min.','.$max.'}$)'.substr(static::$PATTERN[$type][0],2,-2);
	}		
}