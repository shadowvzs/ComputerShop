<?php
$FORM = [
	'create'=>['name'=>'LogForm','url'=>'', 'method'=>'POST', 'showError'=>['position'=>'before', 'class'=>'errorMSG']],
	'input'=>[
		'email' => ['email', 'cache'=>true, 'attr'=>['class'=>'login', 'required','placeholder'=>'Email address'],'rule'=>['pattern'=>['type'=>'EMAIL','length'=>[9,64]]]],
		'password' => ['password', 'attr'=>['class'=>'login', 'required','placeholder'=>'Password'],'rule'=>['pattern'=>['type'=>'LOWER_UPPER_NUM', 'length'=>[6, 64]]]],
		'submit' => ['submit', 'attr'=>['class'=>'login', 'value'=>'Sign in']]
	],
	'end'=>true,
];

if (isset($_SESSION['validForm']) && $_SESSION['validForm']){
	if ($user=User::checkUser($_SESSION['input']['email'],$_SESSION['input']['password'])){
	    	$user->login();
	    	FormHelper::clearSession();
	       	redirect('/dashboard.php');
	}else{	
		$_SESSION['input']['error']['email'] = 'Wrong email and password pair';
	}	
}

FormHelper::init($FORM);