<?php

$FORM = [
	'create'=>['name'=>'RegForm','url'=>'', 'method'=>'POST', 'showError'=>['position'=>'before', 'class'=>'errorMSG']],
	'input'=>[
		'name' => ['text', 'cache'=>true, 'attr'=>['class'=>'reg', 'required','placeholder'=>'Your Name'],'rule'=>['pattern'=>['type'=>'NAME','length'=>[3,64]]]],
		'email' => ['email', 'cache'=>true, 'attr'=>['class'=>'reg', 'required','placeholder'=>'E-mail address'],'rule'=>['pattern'=>['type'=>'EMAIL','length'=>[9,64]]]],
		'password' => ['password', 'attr'=>['class'=>'reg', 'required','placeholder'=>'Password'],'rule'=>['pattern'=>['type'=>'LOWER_UPPER_NUM', 'length'=>[6, 64]]]],
		'password2' => ['password', 'attr'=>['class'=>'reg', 'required','placeholder'=>'Confirm password'],'rule'=>['match'=>'password', 'pattern'=>['type'=>'LOWER_UPPER_NUM', 'length'=>[6, 64]]]],
		'submit' => ['submit', 'attr'=>['class'=>'login', 'value'=>'Create account']]
	],
	'end'=>true,
];


if (isset($_SESSION['validForm']) && $_SESSION['validForm']){
	if (!User::emailExists($_SESSION['input']['email'])) {
	    $user = new User();
	    $user->name=$_SESSION['input']['name'];    
	    $user->email=$_SESSION['input']['email'];    
	    $user->password=md5($_SESSION['input']['password'].secretString());    
	    $user->type='USER';   
	    $user->insert();  
		FormHelper::clearSession();	    
	    redirect('/dashboard.php?page=login');
	}else{
		$_SESSION['input']['error']['email'] = 'This email already used';
	
	}
}

FormHelper::init($FORM);
