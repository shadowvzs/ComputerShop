<?php

	Router::connect('/contact', array('controller' => 'contacts', 'action' => 'add'));
	Router::connect('/terms', array('controller' => 'pages', 'action' => 'terms'));
	Router::connect('/aboutus', array('controller' => 'pages', 'action' => 'aboutus'));
	Router::connect('/orders', array('controller' => 'orders', 'action' => 'index'));
	Router::connect('/mycart', array('controller' => 'carts', 'action' => 'view'));
	Router::connect('/profile', array('controller' => 'users', 'action' => 'view'));
	Router::connect('/settings', array('controller' => 'users', 'action' => 'edit'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/signup', array('controller' => 'users', 'action' => 'add'));
	Router::connect('/recover', array('controller' => 'users', 'action' => 'recover'));
	Router::connect('/activation', array('controller' => 'users', 'action' => 'activation_mail'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout', 'admin' => true));
	Router::connect('/activate/:hash/:id', array('controller' => 'users', 'action' => 'activate', array('hash' => '[0-9a-zA-Z]+', 'id' => '[0-9]+')));
	Router::connect('/reset/:hash/:id', array('controller' => 'users', 'action' => 'reset', array('hash' => '[0-9a-zA-Z]+', 'id' => '[0-9]+')));
	Router::connect('/contact', array('controller' => 'contacts', 'action' => 'index'));
	Router::connect('/admin', array('controller' => 'contacts', 'action' => 'dashboard', 'admin' => true));
	Router::connect('/computer_shop/*', array('controller' => 'contacts', 'action' => 'dashboard', 'admin' => true));
	Router::connect('/', array('controller' => 'products', 'action' => 'index'));

	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	CakePlugin::routes();


	require CAKE . 'Config' . DS . 'routes.php';
