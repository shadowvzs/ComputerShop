<?php

	if ($user=User::checkUserByName($username,$password)){
	    	$arr = ['success'=>true, 'data'=> $user];
	}else{	
            $arr = ['success'=>false, 'error'=> 'Invalid username or password', 'data'=>['username'=>$username,'password'=>$password]];
      
	}
	echo json_encode($arr);
